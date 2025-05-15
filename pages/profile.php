<?php
session_start();
require_once '../config/config.php'; // Connessione DB

if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/index.php");
    exit;
}

$id_utente = $_SESSION['id_utente'];

$sql = "SELECT id, username, email, data_registrazione FROM Utente WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_utente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // Utente non trovato, puoi decidere cosa fare (es: logout e redirect)
    header("Location: ../pages/index.php");
    exit;
}

$utente = $result->fetch_assoc();
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
  <h1>Profilo di <?= htmlspecialchars($utente['username']) ?></h1>
  <div class="card p-4 shadow-sm">
    <p><strong>ID:</strong> <?= htmlspecialchars($utente['id']) ?></p>
    <p><strong>Username:</strong> <?= htmlspecialchars($utente['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($utente['email']) ?></p>
    <p><strong>Registrato il:</strong> <?= htmlspecialchars($utente['data_registrazione']) ?></p>
  </div>
  <a href="../pages/index.php" class="btn btn-primary mt-3">Torna alla home</a>
</div>

<?php include '../includes/footer.php'; ?>
