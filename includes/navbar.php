<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg py-3">
  <div class="container">

    <!-- Logo -->
    <a class="navbar-brand ms-2" href="index.php" style="display: flex; align-items: center;">
      <img src="../assets/cookhub.png" alt="Logo" class="d-inline-block align-text-top" style="max-height: 40px;">
    </a>

    <!-- Navbar principale -->
    <div class="collapse navbar-collapse">
      <!-- Menu sinistra: Popolari e Ricette -->
      <ul class="navbar-nav me-auto ms-2">
        <li class="nav-item">
          <a class="nav-link" href="../pages/popular_posts.php">Popolari</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/ricette.php">Ricette</a>
        </li>
      </ul>
      <!-- Menu destra: Profilo, Login, Registrati, Tema -->
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['id_utente'])) { ?>
          <li class="nav-item d-flex align-items-center me-2">
            <a href="../pages/profile.php?id=<?= $_SESSION['id_utente'] ?>" class="nav-link p-0">
              <img src="https://img.icons8.com/ios-filled/50/FFFFFF/chef-hat.png" alt="Profilo" width="26" height="26" class="profile-icon-light">
              <img src="https://img.icons8.com/ios-filled/50/chef-hat.png" alt="Profilo" width="26" height="26" class="profile-icon-dark">
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Registrati</a>
          </li>
        <?php } ?>
        <li class="nav-item d-flex align-items-center">
          <button id="themeToggle" class="btn btn-sm btn-outline-light ms-3">
            <i id="themeIcon" class="bi bi-moon-stars-fill"></i>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php 
  include '../includes/loginModal.html';
  include '../includes/registerModal.html';
?>


