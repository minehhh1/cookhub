<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">

    <!-- Bottone hamburger personalizzato che apre l'offcanvas -->
    <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
      <img src="../assets/hamburger.svg" alt="Menu" width="30" height="30">
    </button>


    <a class="navbar-brand" href="index.php">
      <img src="../assets/cookhub.png" alt="Logo chiaro" class="logo-light d-inline-block align-text-top">
      <img src="../assets/cookhub.png" alt="Logo scuro" class="logo-dark d-none align-text-top">
    </a>


    <!-- Navbar principale -->
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['id_utente'])) { ?>
          <li class="nav-item d-flex align-items-center me-2">
            <a href="../pages/profile.php" class="nav-link p-0">
              <img width="26" height="26" src="https://img.icons8.com/ios-filled/50/FFFFFF/chef-hat.png" alt="chef-hat"/>
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

<!-- Menu -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Chiudi"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" href="../pages/popolari.php">Popolari</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="../pages/ricette.php">Ricette</a>
      </li>
    </ul>
  </div>
</div>
 <?php 
  include '../includes/loginModal.html';
  include '../includes/registerModal.html';
?>


