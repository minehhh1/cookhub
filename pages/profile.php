<?php
session_start();
require_once '../config/config.php';

// Ottieni l'ID utente dall'URL
$id_utente_selezionato = $_GET['id'] ?? null;

if (!$id_utente_selezionato) {
    header("Location: ../pages/index.php");
    exit;
}

// Recupera i dati dell'utente selezionato
$sql = "SELECT id, username, email, data_registrazione FROM Utente WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_utente_selezionato); // Usa l'ID dall'URL
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: ../pages/index.php");
    exit;
}

$utente = $result->fetch_assoc();
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <!-- Card profilo utente -->
      <div class="card shadow rounded-4 border-0">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Ciao, <?= htmlspecialchars($utente['username']) ?>!</h2>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>ID:</strong> <?= htmlspecialchars($utente['id']) ?></li>
            <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($utente['username']) ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($utente['email']) ?></li>
            <li class="list-group-item"><strong>Registrato il:</strong> <?= date('d/m/Y', strtotime($utente['data_registrazione'])) ?></li>
          </ul>
          <div class="text-center mt-4">
            <a href="../pages/index.php" class="btn btn-primary">Torna alla home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
