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
            $_SESSION['id_utente'] = $conn->insert_id;

            header("location: index.php");
        }else{
            echo "Inserimento fallito: " . $stmt->error;
        }
    }
}else{ ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="inserisci nome utente"><br>
        <input type="email" name="email" placeholder="inserisci email"><br>
        <input type="password" name="password" placeholder="inserisci la password"><br><br>
        <input type="submit" name="signUp" value="register">
    </form>
    </body>
    </html>

<?php } ?>