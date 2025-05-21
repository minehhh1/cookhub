<?php
session_start();
require_once '../config/config.php'; // File di configurazione del DB

$register = $_POST['signUp'] ?? '';

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if($register === 'register'){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utente(username, email, password, data_registrazione) VALUES( ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $temp2 = date('Y-m-d');
        $stmt->bind_param("ssss", $username, $email, $hashPassword, $temp2);

        if($stmt->execute()){
            // Login automatico dopo la registrazione (opzionale)
            $_SESSION['username'] = $username;
            $_SESSION['welcome'] = "Registrazione avvenuta con successo! Benvenuto su CookHub.";
            // Reindirizza alla home
            header("Location: ../pages/index.php");
            exit;
        }else{
            $error = "Inserimento fallito: " . $stmt->error;
        }
    }
}

if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
