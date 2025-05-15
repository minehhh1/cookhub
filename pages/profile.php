<?php
session_start();
require_once '../config/config.php'; // File di configurazione del DB

$profile = $_GET['profile'] ?? '';
$prova;
if (isset($_GET['profile']) && isset($_SESSION['id_utente'])) {
    $id_utente = $_SESSION['id_utente'];

    $sql = "SELECT * FROM Utente WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_utente); // "i" = integer
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>CookHub</title>
</head>
<body>
    <p>
    <?php
    if ($result->num_rows > 0) {
		$utente = $result->fetch_assoc();
        echo "ID utente: " . htmlspecialchars($utente['id']) . "<br>";
		echo "username utente: " . htmlspecialchars($utente['username']) . "<br>";
		echo "email utente: " . htmlspecialchars($utente['email']) . "<br>";
		echo "data utente: " . htmlspecialchars($utente['data_registrazione']) . "<br>";
    } else {
        echo "Utente non trovato o non loggato.";
    }
    ?>
    </p>
</body>
</html>