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

// Mostra solo le ricette dell'utente loggato
$ricette = [];

if (isset($_SESSION['id_utente'])) {
    $id_utente = $_SESSION['id_utente'];

    $query = "SELECT 
                r.id,
                r.nome,
                r.descrizione,
                r.id_utente,
                u.username as creatore,
                u.id as id_creatore,
                COUNT(pr.id) as usage_count
              FROM Ricetta r
              LEFT JOIN Piano_ricetta pr ON r.id = pr.id_ricetta
              LEFT JOIN Utente u ON r.id_utente = u.id
              WHERE r.id_utente = ?
              GROUP BY r.id
              ORDER BY usage_count DESC";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $ricette = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
    } else {
        echo '<div class="container mt-3">
                <div class="alert alert-danger" role="alert">
                    Errore nella preparazione della query: ' . htmlspecialchars($conn->error) . '
                </div>
              </div>';
    }
}
?>

<div class="page-wrapper d-flex flex-column min-vh-100">
  <main class="flex-grow-1">
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
                <a href="../pages/login.php" class="alert-link">Accedi</a> per pubblicare una ricetta.
            </div>
        <?php endif; ?>

        <!-- Lista ricette -->
        <h3 class="mb-4 fw-bold">🍳 Le tue ricette</h3>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($ricette)): ?>
                <div class="col-12">
                    <div class="alert alert-secondary text-center">
                        Non hai ancora pubblicato nessuna ricetta.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($ricette as $ricetta): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 recipe-card" 
                             data-bs-toggle="modal" 
                             data-bs-target="#recipeModal<?= $ricetta['id'] ?>"
                             style="cursor: pointer;">
                            <div class="card-body text-center">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($ricetta['nome']) ?></h5>
                                <div class="usage-section mt-3">
                                </div>
                                <?php if (!empty($ricetta['creatore'])): ?>
                                    <small class="text-muted d-block mt-2">
                                        di <?= htmlspecialchars($ricetta['creatore']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Modal per la ricetta -->
                    <div class="modal fade" id="recipeModal<?= $ricetta['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= htmlspecialchars($ricetta['nome']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6 class="text-muted mb-3">Ingredienti e preparazione:</h6>
                                    <p class="card-text"><?= nl2br(htmlspecialchars($ricetta['descrizione'])) ?></p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div>
                                            <?php if (!empty($ricetta['creatore'])): ?>
                                                <span class="ms-2">
                                                    Creatore: 
                                                    <a href="../pages/profile.php?id=<?= $ricetta['id_creatore'] ?>" class="text-decoration-none">
                                                        <?= htmlspecialchars($ricetta['creatore']) ?>
                                                    </a>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <form action="../actions/delete_ricetta.php" method="POST" 
                                              onsubmit="return confirm('Sei sicuro di voler eliminare questa ricetta?');">
                                            <input type="hidden" name="ricetta_id" value="<?= $ricetta['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i> Elimina
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</div>

<style>
    .recipe-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 15px;
        overflow: hidden;
    }
    .recipe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
    .badge {
        font-size: 0.9rem;
    }
</style>

<?php
include '../includes/footer.php';
?>