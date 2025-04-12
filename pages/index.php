<?php
session_start();
$pageTitle = "Home";
$activePage = "home";

include '../includes/header.php';
include '../includes/navbar.php';

if (isset($_SESSION['welcome'])) {
    echo "<div class='alert alert-success text-center mt-3'>" . $_SESSION['welcome'] . "</div>";
    unset($_SESSION['welcome']);
}
?>

<!-- Contenuto della home -->

<?php include '../includes/footer.php'; ?>
