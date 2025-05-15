<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="../pages/index.php">
    <!-- <img src="../assets/CH_logoLungoBlack.svg" alt="Logo" width="130" height="50" class="d-inline-block align-text-top">-->
  <a class="navbar-brand" href="../pages/index.php">
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['email'])): ?>
          <li class="nav-item">
            <span class="navbar-text text-white me-3">
                <?= htmlspecialchars($_SESSION['email']) ?>
            </span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'login' ? 'active' : '' ?>" href="login.php" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'register' ? 'active' : '' ?>" href="register.php">Registrati</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
