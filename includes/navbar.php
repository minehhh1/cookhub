<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
  <a class="navbar-brand" href="../pages/index.php">
      <img src="../assets/CH_logoLungo.svg" alt="Logo" width="130" height="50" class="d-inline-block align-text-top">
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['email'])): ?>
          <!-- Se l'utente è loggato, mostra Logout e Profilo -->
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profilo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <!-- Se l'utente NON è loggato, mostra Login e Registrati -->
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Registrati</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>