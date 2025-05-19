<?php
session_start();
require_once '../config/config.php';

// 1. Controllo login
if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/login.php");
    exit;
}

// 2. Controllo dati inviati
if (!isset($_POST['post_id'])) {
    header("Location: ../pages/index.php");
    exit;
}

// 3. Prendi i dati
$post_id = (int)$_POST['post_id'];
$user_id = (int)$_SESSION['id_utente'];

// 4. Elimina prima i commenti e like
$conn->query("DELETE FROM Commento WHERE post_id = $post_id");
$conn->query("DELETE FROM Likes WHERE post_id = $post_id");

// 5. Elimina il post solo se è dell'utente
if ($conn->query("DELETE FROM Post WHERE id = $post_id AND id_utente = $user_id")) {
    $_SESSION['success'] = "Post eliminato!";
} else {
    $_SESSION['error'] = "Errore nell'eliminazione";
}

header("Location: ../pages/index.php");
exit;
?>