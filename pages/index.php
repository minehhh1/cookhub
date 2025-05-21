<?php
session_start();
$pageTitle = "Home";
$activePage = "home";

include '../includes/header.php';
require_once '../config/config.php';

// Mostra messaggio di benvenuto
if (isset($_SESSION['welcome'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                '.htmlspecialchars($_SESSION['welcome']).'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>';
    unset($_SESSION['welcome']);
}

// Caricamento post dal DB con conteggio like
$posts = [];
$query = "SELECT Post.*, Utente.username, 
          (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id) as like_count
          FROM Post 
          JOIN Utente ON Post.id_utente = Utente.id 
          ORDER BY Post.data_creazione DESC
          LIMIT 10";

$result = $conn->query($query);

if ($result === false) {
    echo "<div class='container mt-3'><div class='alert alert-danger'>Errore nel caricamento dei post: " . htmlspecialchars($conn->error) . "</div></div>";
} elseif ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['user_liked'] = false; // Default
        
        // Verifica like solo se l'utente è loggato
        if (isset($_SESSION['id_utente']) && !empty($_SESSION['id_utente'])) {
            $check_like = $conn->prepare("SELECT id FROM Likes WHERE post_id = ? AND user_id = ?");
            $check_like->bind_param("ii", $row['id'], $_SESSION['id_utente']);
            $check_like->execute();
            $row['user_liked'] = $check_like->get_result()->num_rows > 0;
        }
        $posts[] = $row;
    }
}
?>
<main class="container mt-5">
    <div class="container">
        <!-- Sezione nuovo post -->
        <?php if (isset($_SESSION['id_utente'])): ?>
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-3">Crea un nuovo post 🍽️</h4>
                    <form action="../actions/create_post.php" method="POST">
                        <div class="mb-3">
                            <textarea class="form-control" name="post_content" rows="4" placeholder="Scrivi qualcosa di gustoso..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Pubblica</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <a href="#" class="alert-link" data-bs-toggle="modal" data-bs-target="#loginModal">Accedi</a> per pubblicare un post.
            </div>
        <?php endif; ?>

        <!-- Lista post -->
        <h3 class="mb-4 fw-bold">Ultimi post dalla community</h3>

        <?php if (empty($posts)): ?>
            <div class="alert alert-secondary text-center">
                Nessun post disponibile. Sii il primo a pubblicare qualcosa!
            </div>
        <?php else: ?>
    <?php foreach ($posts as $post): ?>
        <!-- Post singolo -->
        <div class="card mb-4 post-card">
            <div class="card-body">

                <!-- Intestazione del post: autore e data -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <a href="../pages/profile.php?id=<?= $post['id_utente'] ?>" class="user-link">
                        <i class="bi bi-person-circle"></i>
                        <span class="user-username"><?= htmlspecialchars($post['username']) ?></span>
                    </a>
                    <small class="text-muted"><?= date('d/m/Y', strtotime($post['data_creazione'])) ?></small>
                </div>

                <!-- Testo del post -->
                <p class="card-text fs-5"><?= nl2br(htmlspecialchars($post['contenuto'])) ?></p>

                <!-- Sezione interazioni: like e commenti -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="d-flex align-items-center gap-3">

                        <!-- Like -->
                        <?php if (isset($_SESSION['id_utente'])): ?>
                            <form action="../actions/like_post.php" method="post" class="d-inline">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent like-btn">
                                    <i class="bi <?= $post['user_liked'] ? 'bi-heart-fill text-danger' : 'bi-heart text-muted' ?>"></i>
                                    <span><?= $post['like_count'] ?></span>
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted"><i class="bi bi-heart"></i> <?= $post['like_count'] ?></span>
                        <?php endif; ?>

                        <!-- Contatore commenti -->
                        <span class="text-muted"><i class="bi bi-chat-dots"></i> 
                            <?php
                            $count = $conn->query("SELECT COUNT(*) as total FROM Commento WHERE post_id = {$post['id']}");
                            $commentCount = $count->fetch_assoc()['total'];
                            echo $commentCount;
                            ?>
                        </span>
                    </div>

                    <!-- Bottone elimina (solo autore) -->
                    <?php if (isset($_SESSION['id_utente']) && $_SESSION['id_utente'] == $post['id_utente']): ?>
                        <form action="../actions/delete_post.php" method="POST" class="d-inline">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Elimina</button>
                        </form>
                    <?php endif; ?>
                </div>

                <!-- Sezione commenti -->
                <div class="comment-section mt-4">

                    <!-- Form nuovo commento (se loggato) -->
                    <?php if (isset($_SESSION['id_utente'])): ?>
                        <form action="../actions/aggiungi_commento.php" method="POST" class="mb-3">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <div class="input-group">
                                <input type="text" name="testo" class="form-control form-control-sm" placeholder="Scrivi un commento..." required>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Invia</button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <!-- Lista commenti -->
                    <?php
                    $commenti = $conn->query("SELECT c.*, u.username FROM Commento c JOIN Utente u ON c.utente_id = u.id WHERE c.post_id = {$post['id']} ORDER BY c.data_creazione");
                    if ($commenti->num_rows > 0): ?>
                        <div class="commenti-list">
                            <?php while($commento = $commenti->fetch_assoc()): ?>
                                <div class="commento mb-2 p-2 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="../pages/profile.php?id=<?= $commento['utente_id'] ?>" class="user-link">
                                            <strong><?= htmlspecialchars($commento['username']) ?></strong>
                                        </a>
                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($commento['data_creazione'])) ?></small>
                                    </div>
                                    <p class="mb-0 small mt-1"><?= htmlspecialchars($commento['testo']) ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php
include '../includes/footer.php';
?>