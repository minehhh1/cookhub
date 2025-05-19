<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ricetta_id'])) {
    $ricetta_id = intval($_POST['ricetta_id']);

    // Elimina prima dalle tabelle collegate
    $conn->query("DELETE FROM Piano_ricetta WHERE id_ricetta = $ricetta_id");
    
    // Poi elimina la ricetta
    if ($conn->query("DELETE FROM Ricetta WHERE id = $ricetta_id")) {
        $_SESSION['welcome'] = "Ricetta eliminata con successo";
    } else {
        $_SESSION['error'] = "Errore durante l'eliminazione";
    }
}

header("Location: ../pages/ricette.php");
exit;
?>