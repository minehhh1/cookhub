<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ricetta_id'])) {
    $ricetta_id = (int)$_POST['ricetta_id'];
    $user_id = (int)$_SESSION['id_utente'];

    // Verifica che l'utente sia il proprietario
    $check = $conn->query("SELECT id FROM Ricetta WHERE id = $ricetta_id AND id_utente = $user_id");
    
    if ($check->num_rows > 0) {
        // Prima elimina dalla tabella Piano_ricetta
        $conn->query("DELETE FROM Piano_ricetta WHERE id_ricetta = $ricetta_id");
        
        // Poi elimina la ricetta
        if ($conn->query("DELETE FROM Ricetta WHERE id = $ricetta_id")) {
            $_SESSION['welcome'] = "Ricetta eliminata con successo";
        } else {
            $_SESSION['error'] = "Errore durante l'eliminazione";
        }
    } else {
        $_SESSION['error'] = "Non sei autorizzato a eliminare questa ricetta";
    }
}

header("Location: ../pages/ricette.php");
exit;
?>