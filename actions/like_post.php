<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $user_id = $_SESSION['id_utente'];
    
    // Verifica se esiste già il like
    $check = $conn->prepare("SELECT id FROM Likes WHERE post_id = ? AND user_id = ?");
    $check->bind_param("ii", $post_id, $user_id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        // Rimuovi il like
        $delete = $conn->prepare("DELETE FROM Likes WHERE post_id = ? AND user_id = ?");
        $delete->bind_param("ii", $post_id, $user_id);
        $delete->execute();
    } else {
        // Aggiungi il like
        $insert = $conn->prepare("INSERT INTO Likes (post_id, user_id) VALUES (?, ?)");
        $insert->bind_param("ii", $post_id, $user_id);
        $insert->execute();
    }
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

header("Location: ../index.php");
exit();
?>