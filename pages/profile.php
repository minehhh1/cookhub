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

<main class="container profile-page mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
      <div class="card profile-card shadow rounded-4 border-0 p-4">
        <div class="card-body text-center">
          <div class="profile-avatar mb-3">
            <img src="../assets/img/default-avatar.png" alt="Avatar" class="rounded-circle shadow" width="100" height="100">
          </div>
          <h2 class="card-title mb-2"><?= htmlspecialchars($utente['username']) ?></h2>
          <p class="text-muted mb-4">Profilo utente</p>
          <ul class="list-group list-group-flush mb-4 text-start">
            <li class="list-group-item bg-transparent border-0 px-0"><strong>ID:</strong> <?= htmlspecialchars($utente['id']) ?></li>
            <li class="list-group-item bg-transparent border-0 px-0"><strong>Username:</strong> <?= htmlspecialchars($utente['username']) ?></li>
            <li class="list-group-item bg-transparent border-0 px-0"><strong>Email:</strong> <?= htmlspecialchars($utente['email']) ?></li>
            <li class="list-group-item bg-transparent border-0 px-0"><strong>Registrato il:</strong> <?= date('d/m/Y', strtotime($utente['data_registrazione'])) ?></li>
          </ul>
          <a href="../pages/index.php" class="btn btn-primary rounded-pill px-4">Torna alla home</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
