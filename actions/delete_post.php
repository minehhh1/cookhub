<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $user_id = $_SESSION['id_utente'];

    // Elimina prima i commenti associati
    $conn->query("DELETE FROM Commento WHERE post_id = $post_id");
    
    // Poi elimina il post
    if ($conn->query("DELETE FROM Post WHERE id = $post_id AND id_utente = $user_id")) {
        header("Location: ../pages/index.php?success=Post eliminato");
    } else {
        header("Location: ../pages/index.php?error=Errore durante l'eliminazione");
    }
    exit;
}

header("Location: ../pages/index.php");
?>