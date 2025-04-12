<?php
session_start();

$login = $_POST['login'] ?? "";
$email = $_POST['email'] ?? "";
$password = $_POST['password'] ?? "";
if($login === 'login'){
    if($email === "minehhhpro@gmail.com" && $password === "zitto"){
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit();
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
            <input type="text" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <input type="submit" value="login" name="login">
        </form>
        Prima volta su CookHub? <a href="registrazione.php">Iscriviti</a>
<?php
    include '../includes/footer.php';
}
?>

