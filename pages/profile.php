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
$sql = "SELECT username, email, data_registrazione FROM Utente WHERE id = ?";
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

<div class="page-wrapper d-flex flex-column min-vh-100">
  <main class="container mt-5 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-9">
        <div class="card profile-card shadow rounded-4 border-0 p-4">
          <div class="card-body text-center">
            
            <!-- Avatar utente (immagine di default) -->
            <div class="profile-avatar mb-4">
              <img src="https://www.gravatar.com/avatar/?d=mp&s=120" alt="Avatar di default" class="rounded-circle shadow-sm border" width="120" height="120">
            </div>

            <!-- Nome e descrizione -->
            <h2 class="card-title fw-bold mb-1"><?= htmlspecialchars($utente['username']) ?></h2>

            <!-- Info utente -->
            <ul class="list-group list-group-flush mb-4 text-start">
              <li class="list-group-item bg-transparent border-0 px-0 py-1 profile-info-item">
                <strong>Username:</strong> <?= htmlspecialchars($utente['username']) ?>
              </li>
              <li class="list-group-item bg-transparent border-0 px-0 py-1 profile-info-item">
                <strong>Email:</strong> <?= htmlspecialchars($utente['email']) ?>
              </li>
              <li class="list-group-item bg-transparent border-0 px-0 py-1 profile-info-item">
                <strong>Registrato il:</strong> <?= date('d/m/Y', strtotime($utente['data_registrazione'])) ?>
              </li>
            </ul>

            <!-- Pulsante torna alla home -->
            <a href="../pages/index.php" class="btn btn-primary rounded-pill px-4">
              Torna alla home
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</div>
<style>
/* filepath: c:\xampp\htdocs\cookhub\pages\profile.php */
.profile-info-item {
  color: var(--colore-grigio);
  transition: color 0.3s;
}
body.dark-mode .profile-info-item {
  color: var(--colore-bianco) !important;
}
</style>
