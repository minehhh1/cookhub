<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome'] ?? '');
    $descrizione = $conn->real_escape_string($_POST['descrizione'] ?? '');
    $id_utente = $_SESSION['id_utente'];

    if (!empty($nome) && !empty($descrizione)) {
        $sql = "INSERT INTO Ricetta (nome, descrizione, id_utente) 
                VALUES ('$nome', '$descrizione', $id_utente)";
        
        if ($conn->query($sql)) {
            $_SESSION['welcome'] = "Ricetta pubblicata con successo!";
        } else {
            $_SESSION['error'] = "Errore durante la pubblicazione: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Tutti i campi sono obbligatori";
    }
}

header("Location: ../pages/ricette.php");
exit;
?>