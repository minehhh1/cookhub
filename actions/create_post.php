<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Devi effettuare l'accesso per pubblicare un post";
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['post_content'])) {
    $content = trim($conn->real_escape_string($_POST['post_content']));
    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d');
    
    $query = "INSERT INTO Post (contenuto, data_creazione, id_utente) VALUES ('$content', '$date', $user_id)";
    
    if ($conn->query($query)) {
        $_SESSION['success'] = "Post pubblicato con successo!";
    } else {
        $_SESSION['error'] = "Errore durante la pubblicazione del post: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "Il contenuto del post non può essere vuoto";
}

header('Location: ../index.php');
exit;
?>