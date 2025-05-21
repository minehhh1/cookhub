<?php
session_start();
$pageTitle = "Post Popolari";
$activePage = "popular";

include '../includes/header.php';
require_once '../config/config.php'; // Connessione al DB

// Mostra messaggio di benvenuto
if (isset($_SESSION['welcome'])) {
    ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['welcome'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php
    unset($_SESSION['welcome']);
}

// Caricamento post più popolari degli ultimi 3 giorni
$posts = [];
$threeDaysAgo = date('Y-m-d H:i:s', strtotime('-3 days'));

$query = "SELECT Post.*, Utente.username, 
          (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id) as like_count
          FROM Post 
          JOIN Utente ON Post.id_utente = Utente.id
          WHERE Post.data_creazione >= '$threeDaysAgo'
          ORDER BY like_count DESC, Post.data_creazione DESC
          LIMIT 10";

$result = $conn->query($query);

if ($result === false) {
    echo "<div class='container mt-3'><div class='alert alert-danger'>Errore nel caricamento dei post: " . $conn->error . "</div></div>";
} elseif ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Verifica se l'utente corrente ha messo like
        if (isset($_SESSION['id_utente'])) {
            $check_like = $conn->prepare("SELECT id FROM Likes WHERE post_id = ? AND user_id = ?");
            $check_like->bind_param("ii", $row['id'], $_SESSION['id_utente']);
            $check_like->execute();
            $row['user_liked'] = $check_like->get_result()->num_rows > 0;
        }
        $posts[] = $row;
    }
}
?>

<div class="page-wrapper d-flex flex-column min-vh-100">
  <main class="container mt-5 flex-grow-1">
    <div class="container mt-5">
        <!-- Intestazione modificata -->
        <h2 class="mb-4 fw-bold">🔥 Post più popolari degli ultimi 3 giorni</h2>

        <?php if (empty($posts)): ?>
            <div class="alert alert-secondary text-center">
                Nessun post popolare negli ultimi 3 giorni. Sii il primo a pubblicare qualcosa!
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="card-text fs-5"><?= nl2br(htmlspecialchars($post['contenuto'])) ?></p>
                        
                        <!-- Sezione Like con badge popolarità -->
                        <div class="like-section mt-3 d-flex align-items-center">
                            <form action="../actions/like_post.php" method="post" class="d-inline me-2">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <button type="submit" class="btn btn-sm <?= isset($post['user_liked']) && $post['user_liked'] ? 'btn-danger' : 'btn-outline-danger' ?>">
                                    <i class="fas fa-heart"></i> <?= $post['like_count'] ?>
                                </button>
                            </form>
                            <?php if ($post['like_count'] > 5): ?>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-fire"></i> Popolare
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Sezione Commenti -->
                        <div class="comment-section mt-3">
                            <?php if (isset($_SESSION['id_utente'])): ?>
                                <form action="../actions/aggiungi_commento.php" method="POST" class="mb-3">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <div class="input-group">
                                        <input type="text" name="testo" class="form-control form-control-sm" placeholder="Scrivi un commento..." required>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Invia</button>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <?php
                            $commenti = $conn->query("
                                SELECT c.*, u.username 
                                FROM Commento c 
                                JOIN Utente u ON c.utente_id = u.id 
                                WHERE c.post_id = {$post['id']} 
                                ORDER BY c.data_creazione
                            ");
                            
                            if ($commenti->num_rows > 0): ?>
                                <div class="commenti-list">
                                    <?php while($commento = $commenti->fetch_assoc()): ?>
                                        <div class="commento mb-2 p-2 rounded">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="../pages/profile.php?id=<?= $commento['utente_id'] ?>" class="text-decoration-none">
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
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted">
                                Post di 
                                <a href="../pages/profile.php?id=<?= $post['id_utente'] ?>" class="text-decoration-none">
                                    <strong class="text-primary"><?= htmlspecialchars($post['username']) ?></strong>
                                </a> 
                                il <?= date('d/m/Y H:i', strtotime($post['data_creazione'])) ?>
                            </small>
                            <?php if (isset($_SESSION['id_utente']) && $_SESSION['id_utente'] == $post['id_utente']): ?>
                                <form action="../actions/delete_post.php" method="POST" class="d-inline">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Elimina</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</div>

<style>
    .commenti-list {
        max-height: 200px;
        overflow-y: auto;
    }
    .commento {
        background-color: #f8f9fa;
        border-left: 3px solid #dee2e6;
    }
    .text-decoration-none:hover {
        text-decoration: underline !important;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>