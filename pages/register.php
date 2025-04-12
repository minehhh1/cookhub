<?php
session_start();
// require_once 'config.php'; // Da attivare quando colleghi il DB

if (isset($_POST['registrati'])) {
    // Recupera i dati dal form
    $nome = $_POST['nome'] ?? "";
    $cognome = $_POST['cognome'] ?? "";
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    // 🔐 Consiglio: cifra la password
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Esempio simulato (quando userai il DB, lo inserirai qui)
    /*
    $sql = "INSERT INTO utente (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $cognome, $email, $hashedPassword);
    $stmt->execute();
    */

    // Salvo messaggio di successo
    $_SESSION['welcome'] = "Registrazione avvenuta con successo! Ora puoi accedere.";
    header("Location: login.php");
    exit();
}

// Altrimenti mostra il form
$pageTitle = "Registrazione";
$activePage = "register";
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">
    <h2>Registrati a Cookhub</h2>
    <form method="post" action="registrazione.php">
        <input type="text" name="nome" placeholder="Nome" required class="form-control mb-2">
        <input type="text" name="cognome" placeholder="Cognome" required class="form-control mb-2">
        <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
        <input type="submit" value="Registrati" name="registrati" class="btn btn-success">
    </form>
    <p class="mt-3">Hai già un account su Cookhub? <a href="login.php">Accedi</a></p>
</div>

<?php include '../includes/footer.php'; ?>

