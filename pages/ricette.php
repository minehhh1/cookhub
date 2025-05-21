<?php
session_start();
$pageTitle = "Ricette";
$activePage = "ricette";

include '../includes/header.php';
require_once '../config/config.php';

// Mostra messaggi
if (isset($_SESSION['welcome'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                '.$_SESSION['welcome'].'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>';
    unset($_SESSION['welcome']);
}

// Mostra errori
if (isset($_SESSION['error'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                '.$_SESSION['error'].'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>';
    unset($_SESSION['error']);
}

// Query semplificata
$query = "SELECT 
            r.id,
            r.nome,
            r.descrizione,
            COUNT(pr.id) as usage_count
          FROM Ricetta r
          LEFT JOIN Piano_ricetta pr ON r.id = pr.id_ricetta
          GROUP BY r.id
          ORDER BY usage_count DESC
          LIMIT 10";

$result = $conn->query($query);
$ricette = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <!-- Form nuova ricetta -->
    <?php if (isset($_SESSION['id_utente'])): ?>
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title mb-3">Aggiungi una nuova ricetta 👨‍🍳</h4>
                <form action="../actions/create_ricetta.php" method="POST">
                    <div class="mb-3">
                        <input type="text" name="nome" class="form-control" placeholder="Nome ricetta" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="descrizione" rows="4" placeholder="Ingredienti e preparazione..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Pubblica ricetta</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <a href="#" class="alert-link" data-bs-toggle="modal" data-bs-target="#loginModal">Accedi</a> per pubblicare una ricetta.
        </div>
    <?php endif; ?>

    <!-- Lista ricette -->
    <h3 class="mb-4 fw-bold">🍳 Ricette più utilizzate</h3>

    <?php if (empty($ricette)): ?>
        <div class="alert alert-secondary text-center">
            Nessuna ricetta disponibile. Sii il primo a pubblicarne una!
        </div>
    <?php else: ?>
        <?php foreach ($ricette as $ricetta): ?>
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><?= htmlspecialchars($ricetta['nome']) ?></h5>
                    <p class="card-text fs-5"><?= nl2br(htmlspecialchars($ricetta['descrizione'])) ?></p>
                    
                    <div class="usage-section mt-3">
                        <span class="badge bg-success">
                            <i class="fas fa-clipboard-list"></i> Utilizzata in <?= $ricetta['usage_count'] ?> piani
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            Ricetta pubblicata
                        </small>
                        <?php if (isset($_SESSION['id_utente'])): ?>
                            <form action="../actions/delete_ricetta.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questa ricetta?');">
                                <input type="hidden" name="ricetta_id" value="<?= $ricetta['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt"></i> Elimina
                                </button>
                            </form>
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