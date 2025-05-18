<?php
session_start();

// 1. Controlla se l'utente è loggato
if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/login.php");
    exit;
}

// 2. Controlla se è stato passato l'ID del post
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: ../pages/index.php?error=ID non valido");
    exit;
}

// 3. Connessione al database
require_once '../config/config.php';

// 4. Prendi i dati
$post_id = intval($_GET['id']);
$user_id = $_SESSION['id_utente'];

// 5. Eliminazione in transazione per maggiore efficienza
$conn->begin_transaction();

try {
    // Prima elimina i like associati (se esiste la tabella)
    @$conn->query("DELETE FROM Likes WHERE post_id = $post_id");
    
    // Poi elimina il post
    $result = $conn->query("DELETE FROM Post WHERE id = $post_id AND id_utente = $user_id");
    
    if ($conn->affected_rows === 0) {
        throw new Exception("Post non trovato o non hai i permessi");
    }
    
    $conn->commit();
    header("Location: ../pages/index.php?success=Post eliminato");
    
} catch (Exception $e) {
    $conn->rollback();
    header("Location: ../pages/index.php?error=" . urlencode($e->getMessage()));
}

$conn->close();
exit;
?>