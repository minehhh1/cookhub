<?php
$login = $_POST['login'] ?? "";
$email = $_POST['email'] ?? "";
$password = $_POST['password'] ?? "";
if($login === 'login'){
    if($email === "minehhhpro@gmail.com" && $password === "zitto"){
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        echo 'sessione "penso" creata con successo!';
        echo 'la sessione non funziona quindi non è giusto';

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
            <form method="post" action="../public/start.html">
                <input type="submit" value="avanti">
            </form>
        </body>
        </html>
        <?php

    }else{
        echo 'credenziali sbagliate!';
    }
}else{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="post" action="login.php">
            <input type="text" name="email" value="email">
            <input type="password" name="password" value="password">
            <input type="submit" value="login" name="login">
        </form>
    </body>
    </html>
<?php }
?>

