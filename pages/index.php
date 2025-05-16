<?php
session_start();
$pageTitle = "Home";
$activePage = "home";

include '../includes/header.php';
include '../includes/navbar.php';
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

// Caricamento post dal DB
$posts = [];
$query = "SELECT Post.*, Utente.username 
          FROM Post 
          JOIN Utente ON Post.id_utente = Utente.id 
          ORDER BY Post.data_creazione DESC";

$result = $conn->query($query);

if ($result === false) {
    echo "<div class='container mt-3'><div class='alert alert-danger'>Errore nel caricamento dei post: " . $conn->error . "</div></div>";
} elseif ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
?>

<div class="container mt-5">
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
    <h3 class="mb-4 fw-bold text-dark">Ultimi post dalla community</h3>

    <?php if (empty($posts)): ?>
        <div class="alert alert-secondary text-center">
            Nessun post disponibile. Sii il primo a pubblicare qualcosa!
        </div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <p class="card-text fs-5"><?= nl2br(htmlspecialchars($post['contenuto'])) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Post di <strong><?= htmlspecialchars($post['username']) ?></strong> 
                            il <?= date('d/m/Y', strtotime($post['data_creazione'])) ?>
                        </small>
                        <?php if (isset($_SESSION['id_utente']) && $_SESSION['id_utente'] == $post['id_utente']): ?>
                            <a href="../actions/delete_post.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-danger">Elimina</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
include '../includes/footer.php';
?>