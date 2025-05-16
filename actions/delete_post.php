<?php
session_start();

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Post non specificato";
    header('Location: ../pages/index.php');
    exit;
}

require_once '../config/config.php';

$post_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Verifica che l'utente sia il proprietario del post
$query = "SELECT id_utente FROM Post WHERE id = $post_id";
$result = $conn->query($query);

if ($result === false) {
    $_SESSION['error'] = "Errore nel database: " . $conn->error;
} elseif ($result->num_rows == 0) {
    $_SESSION['error'] = "Post non trovato";
} else {
    $post = $result->fetch_assoc();
    if ($post['id_utente'] != $user_id) {
        $_SESSION['error'] = "Non sei autorizzato a eliminare questo post";
    } else {
        $delete_query = "DELETE FROM Post WHERE id = $post_id";
        if ($conn->query($delete_query)) {
            $_SESSION['success'] = "Post eliminato con successo";
        } else {
            $_SESSION['error'] = "Errore durante l'eliminazione del post: " . $conn->error;
        }
    }
}

header('Location: ../pages/index.php');
exit;
?>