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
}else{ 
    $pageTitle = "Login";
    $activePage = "login";
    include '../includes/header.php';
    include '../includes/navbar.php';?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        
    <div class="container mt-5">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="inserisci nome utente" required class="form-control mb-2">
        <input type="email" name="email" placeholder="inserisci email" required class="form-control mb-2">
        <input type="password" name="password" placeholder="inserisci la password" required class="form-control mb-2"><br>
        <input type="submit" name="signUp" value="register" class="btn btn-primary">
    </form>
    <p class="mt-3">Hai gia un account su Cookhub? <a href="login.php">Accedi</a></p>

    <?php include '../includes/footer.php'; ?>
    </body>
    </html>

<?php } ?>