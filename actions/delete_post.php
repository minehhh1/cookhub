<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = (int)$_POST['post_id'];
    $user_id = (int)$_SESSION['id_utente'];

    // Verifica che l'utente sia il proprietario del post
    $check = $conn->prepare("SELECT id FROM Post WHERE id = ? AND id_utente = ?");
    if (!$check) {
        $_SESSION['error'] = "Errore nella query di verifica: " . $conn->error;
        header("Location: ../pages/home.php");
        exit;
    }

    $check->bind_param("ii", $post_id, $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Elimina i commenti
        $del_commenti = $conn->prepare("DELETE FROM Commento WHERE post_id = ?");
        if ($del_commenti) {
            $del_commenti->bind_param("i", $post_id);
            $del_commenti->execute();
        }

        // Elimina i like
        $del_like = $conn->prepare("DELETE FROM Likes WHERE post_id = ?");
        if ($del_like) {
            $del_like->bind_param("i", $post_id);
            $del_like->execute();
        }

        // Elimina il post
        $delete = $conn->prepare("DELETE FROM Post WHERE id = ?");
        if ($delete) {
            $delete->bind_param("i", $post_id);
            if ($delete->execute()) {
                $_SESSION['welcome'] = "Post eliminato con successo.";
            } else {
                $_SESSION['error'] = "Errore durante l'eliminazione del post: " . $delete->error;
            }
        } else {
            $_SESSION['error'] = "Errore nella query di eliminazione: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Non sei autorizzato a eliminare questo post.";
    }
}

header("Location: ../pages/index.php");
exit;
