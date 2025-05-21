<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $contenuto = $_POST['post_content'] ?? '';
    $id_utente = $_SESSION['id_utente'];
    $data_creazione = date('Y-m-d H:i:s'); // <-- ORA completa

    $sql = "INSERT INTO post (contenuto, data_creazione, id_utente) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $contenuto, $data_creazione, $id_utente);

    if ($stmt->execute()) {
        header("Location: ../pages/index.php");
        exit;
    } else {
        echo "Inserimento fallito: " . $stmt->error;
    }
}
?>
