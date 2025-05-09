<?php
session_start();
$pageTitle = "Home";
$activePage = "home";

include '../includes/header.php';
include '../includes/navbar.php';
require_once '../config/config.php'; // Il tuo file config.php

// Gestione dei messaggi di benvenuto
if (isset($_SESSION['welcome'])) {
    ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['welcome'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
    unset($_SESSION['welcome']);
}

// Recupera i post dal database
$posts = [];
$query = "SELECT Post.*, Utente.username 
          FROM Post 
          JOIN Utente ON Post.id_utente = Utente.id 
          ORDER BY Post.data_creazione DESC";

$result = $conn->query($query);

if ($result === false) {
    echo "<div class='alert alert-danger'>Errore nel caricamento dei post: " . $conn->error . "</div>";
} elseif ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
?>

<div class="container mt-4">
    <!-- Form per creare un nuovo post -->
    <?php if(isset($_SESSION['id_utente'])){ ?>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Crea un nuovo post</h2>
                <form action="../actions/create_post.php" method="POST">
                    <div class="mb-3">
                        <textarea class="form-control" name="post_content" rows="4" placeholder="Scrivi qualcosa..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Pubblica</button>
                </form>
            </div>
        </div>
    <?php }else{ ?>
        <div class="alert alert-info">
            <a href="login.php" class="alert-link">Accedi</a> per pubblicare un post
        </div>
    <?php } ?>

    <!-- Lista dei post -->
    <h2 class="mb-3">Post pubblicati</h2>
    <?php if(empty($posts)): ?>
        <div class="alert alert-secondary">
            Non c'è ancora nessun post. Sii il primo a pubblicare qualcosa!
        </div>
    <?php else: ?>
        <?php foreach($posts as $post): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text"><?= nl2br(htmlspecialchars($post['contenuto'])) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Pubblicato da <strong><?= htmlspecialchars($post['username']) ?></strong> 
                            il <?= date('d/m/Y', strtotime($post['data_creazione'])) ?>
                        </small>
                        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['id_utente']): ?>
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