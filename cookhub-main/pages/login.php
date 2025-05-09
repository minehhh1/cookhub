<?php
session_start();
require_once '../config/config.php'; // Connessione al DB

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($_POST['login'])) {
    $sql = "SELECT id, email, password FROM utente WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $utente = $result->fetch_assoc();

        if (password_verify($password, $utente['password'])) {
            $_SESSION['email'] = $utente['email'];
            $_SESSION['id_utente'] = $utente['id'];
            header("location: index.php");
            exit;
        } else {
            echo "Password errata";
        }
    } else {
        echo "Utente non trovato";
    }
}

$pageTitle = "Login";
$activePage = "login";
include '../includes/header.php';
include '../includes/navbar.php';
?>


<div class="modal fade modal-dialog modal-dialog-centered" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Welcome Back!</h1>
      </div>
      <div class="modal-body">
        <div class="container mt-5">
            <form method="post" action="login.php">
                <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
                <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </form>
            <p class="mt-3">Prima volta su Cookhub? <a href="register.php">Iscriviti</a></p>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>



