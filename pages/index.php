<?php
session_start();
date_default_timezone_set('Europe/Rome');

$pageTitle = "Home";
$activePage = "home";

include '../includes/header.php';
require_once '../config/config.php';

// Mostra messaggi
if (isset($_SESSION['welcome'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                '.htmlspecialchars($_SESSION['welcome']).'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>';
    unset($_SESSION['welcome']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                '.htmlspecialchars($_SESSION['error']).'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>';
    unset($_SESSION['error']);
}

// Caricamento post con conteggio like e commenti
$posts = [];
$query = "SELECT 
            p.*, 
            u.username,
            (SELECT COUNT(*) FROM Likes WHERE post_id = p.id) as like_count,
            (SELECT COUNT(*) FROM Commento WHERE post_id = p.id) as comment_count
          FROM Post p
          JOIN Utente u ON p.id_utente = u.id 
          ORDER BY p.data_creazione DESC
          LIMIT 10";

$result = $conn->query($query);

if ($result === false) {
    echo "<div class='container mt-3'><div class='alert alert-danger'>Errore nel caricamento dei post: " . htmlspecialchars($conn->error) . "</div></div>";
} elseif ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['user_liked'] = false;
        
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

<div class="page-wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container mt-5">
            <!-- Form nuovo post -->
            <?php if (isset($_SESSION['id_utente'])): ?>
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Crea un nuovo post</h4>
                        <form action="../actions/create_post.php" method="POST">
                            <div class="mb-3">
                                <textarea class="form-control" name="post_content" rows="4" placeholder="Scrivi qualcosa di gustoso..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Pubblica</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert custom-accedi-alert text-center border-0">
                    <a href="#" class="alert-link custom-accedi-link" data-bs-toggle="modal" data-bs-target="#loginModal">Accedi</a> per pubblicare un post.
                </div>
            <?php endif; ?>

            <!-- Lista post -->
            <h3 class="mb-4 fw-bold">Ultimi post dalla community</h3>

            <?php if (empty($posts)): ?>
                <div class="alert alert-secondary text-center">
                    Nessun post disponibile. Sii il primo a pubblicare qualcosa!
                </div>
            <?php else: ?>
                <div class="post-list">
                    <?php foreach ($posts as $post): ?>
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body">
                                <!-- Intestazione post -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                            <div>
                                                <a href="../pages/profile.php?id=<?= $post['id_utente'] ?>" class="text-decoration-none d-flex">
                                                <strong class="user-link"><?= htmlspecialchars($post['username']) ?></strong>
                                                </a>
                                                <small class="text-muted d-block"><?= date('d/m/Y H:i', strtotime($post['data_creazione'])) ?></small>
                                            </div>
                                    </div>
                                    <?php if (isset($_SESSION['id_utente']) && $_SESSION['id_utente'] == $post['id_utente']): ?>
                                        <form action="../actions/delete_post.php" method="POST" 
                                            onsubmit="return confirm('Sei sicuro di voler eliminare questo pos?t');">
                                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <!-- Contenuto post -->
                                <p class="card-text fs-5 mb-3"><?= nl2br(htmlspecialchars($post['contenuto'])) ?></p>

                                <!-- Interazioni -->
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <div class="d-flex gap-3">
                                        <!-- Like -->
                                        <?php if (isset($_SESSION['id_utente'])): ?>
                                            <form action="../actions/like_post.php" method="post" class="d-inline">
                                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent like-btn">
                                                    <i class="fa-heart fa<?= $post['user_liked'] ? 's liked text-danger' : 'r text-muted' ?>"></i>
                                                    <span class="ms-1"><?= $post['like_count'] ?></span>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="far fa-heart"></i> <?= $post['like_count'] ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <!-- Commenti -->
                                        <span class="text-muted">
                                            <i class="far fa-comment"></i> <?= $post['comment_count'] ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Sezione commenti -->
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
                                    
                                    if ($commenti && $commenti->num_rows > 0): ?>
                                        <div class="commenti-list">
                                            <?php while($commento = $commenti->fetch_assoc()): ?>
                                                <div class="commento mb-2 p-2 rounded">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <a href="../pages/profile.php?id=<?= $commento['utente_id'] ?>" class="text-decoration-none user-link">
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
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</div>

<style>
    .post-list .card {
        border-radius: 12px;
        transition: transform 0.2s;
    }
    .post-list .card:hover {
        transform: translateY(-3px);
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .commento {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    .like-btn {
        transition: transform 0.2s;
    }
    .like-btn:hover {
        transform: scale(1.1);
    }
    .bi-heart-fill {
        animation: like 0.5s;
    }
    @keyframes like {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }
    .custom-accedi-link {
        color: var(--colore-primario) !important;
        font-weight: 700;
        text-decoration: underline;
        transition: color 0.2s;
    }
    .custom-accedi-link:hover {
        color: var(--colore-primario-chiaro) !important;
    }
    body.dark-mode .custom-accedi-link {
        color: #fff !important;
    }
    .custom-accedi-alert {
        font-size: 1.08rem;
        background: linear-gradient(90deg, #fff7f0 0%, #ffe0cc 100%);
        color: var(--colore-grigio);
        border-radius: 14px;
        border: none;
        box-shadow: 0 2px 12px rgba(240,138,93,0.08);
    }
    body.dark-mode .custom-accedi-alert {
        background: linear-gradient(90deg, #232526 0%, #1e1e1e 100%);
        color: #fff;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.13);
    }
</style>