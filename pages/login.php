<?php
session_start();

$login = $_POST['login'] ?? "";
$email = $_POST['email'] ?? "";
$password = $_POST['password'] ?? "";
if($login === 'login'){
    if($email === "minehhhpro@gmail.com" && $password === "zitto"){
        $_SESSION['email'] = $email;
        echo 'sessione "penso" creata con successo!';
        echo 'la sessione non funziona quindi non è giusto';
        header("index.php");
        ?>
        <?php

    }else{
        echo 'credenziali sbagliate!';
    }
}else{
    $pageTitle = "Login";
    $activePage = "login";
    include '../includes/header.php';
    include '../includes/navbar.php';
    ?>
        <form method="post" action="login.php">
            <input type="text" name="email">
            <input type="password" name="password">
            <input type="submit" value="login" name="login">
        </form>
    </body>
    </html>
<?php }
?>

