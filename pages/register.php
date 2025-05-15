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
            echo "Utente inserito correttamente";
            $_SESSION['username'] = $username;

            header("location: login.php");
        }else{
            echo "Inserimento fallito: " . $stmt->error;
        }
    }
}
if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    