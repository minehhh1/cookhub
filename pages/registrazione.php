<?php
    //require_once 'config.php';
$registrazione = $_POST['registrati'] ?? "";
$email = $_POST['email'] ?? "";
$password = $_POST['password'] ?? "";

if($registrazione === 'registrati'){
    /*$sql = "INSERT INTO utente(email, password) VALUES('$email', '$password')";
    $result = $conn->query($sql);
    if($result === TRUE){
        echo 'registrato con successo!';
    }else{
        $conn->error;
    }*/
    
    echo 'registrato con successo!';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="post" action="../public/index.html">
            <input type="submit" value="avanti">
        </form>

        
    </body>
    </html>

    <?php
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
        <form method="post" action="registrazione.php">
            <input type="text" name="nome" placeholder="nome" required>
            <input type="text" name="cognome" placeholder="cognome" required>
            <input type="email" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="submit" value="registrati" name="registrati">
        </form>

        Hai gia un account su CookHub? <a href="login.php">Accedi</a>
    </body>
    </html>

<?php } ?>
