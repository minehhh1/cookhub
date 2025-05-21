<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['testo'])) {
    $post_id = intval($_POST['post_id']);
    $testo = trim($conn->real_escape_string($_POST['testo']));
    $utente_id = $_SESSION['id_utente'];
    $data_creazione = date('Y-m-d H:i:s'); // <-- aggiunto orario completo

    if (!empty($testo)) {
        $sql = "INSERT INTO Commento (post_id, utente_id, testo, data_creazione) 
                VALUES ($post_id, $utente_id, '$testo', '$data_creazione')";
        if ($conn->query($sql)) {
            header("Location: ../pages/index.php?success=Commento aggiunto");
        } else {
            header("Location: ../pages/index.php?error=Errore database");
        }
    } else {
        header("Location: ../pages/index.php?error=Commento vuoto");
    }
    exit;
}

header("Location: ../pages/index.php");
?>