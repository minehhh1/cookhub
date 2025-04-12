<?php
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    if ($email === "minehhhpro@gmail.com" && $password === "zitto") {
        $_SESSION['email'] = $email;
        $_SESSION['welcome'] = "Benvenuto " . $email;
        header("Location: index.php");
        exit();
    } else {
        $error = "Credenziali sbagliate!";
    }
}

$pageTitle = "Login";
$activePage = "login";
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <input type="text" name="email" placeholder="Email" required class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
        <input type="submit" value="Login" name="login" class="btn btn-primary">
    </form>
    <p class="mt-3">Prima volta su Cookhub? <a href="register.php">Iscriviti</a></p>
</div>

<?php include '../includes/footer.php'; ?>



