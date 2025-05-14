<?php
//session_start();
require_once '../config/config.php'; // Connessione al DB

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($_POST['login'])) {
    $sql = "SELECT id, email, password FROM utente WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $utente = $result->fetch_assoc();

        if (password_verify($password, $utente['password'])) {
            $_SESSION['email'] = $utente['email'];
            $_SESSION['id_utente'] = $utente['id'];
            header("location: index.php");
            exit;
        } else {
            echo "Password errata";
        }
    } else {
        echo "Utente non trovato";
    }
}
?>



