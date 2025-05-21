<footer class="footer-custom">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-4 text-center text-lg-start mb-4 mb-lg-0">
        <a href="../pages/index.php" class="footer-logo text-decoration-none" style="display: inline-flex; align-items: center;">
          <img src="../assets/cookhub.png" alt="CookHub Logo" style="height: 38px; width: auto;">
        </a>
      </div>
      <div class="col-lg-4 text-center mb-4 mb-lg-0">
        <div class="footer-links">
          <a href="../pages/about.php" class="footer-link">Chi siamo</a>
          <a href="../pages/contact.php" class="footer-link">Contatti</a>
          <a href="../pages/privacy.php" class="footer-link">Privacy</a>
          <a href="../pages/terms.php" class="footer-link">Termini</a>
        </div>
      </div>
      <div class="col-lg-4 text-center text-lg-end">
        <div class="footer-social">
          <a href="https://facebook.com" target="_blank" class="social-icon">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="https://instagram.com" target="_blank" class="social-icon">
            <i class="bi bi-instagram"></i>
          </a>
          <a href="https://twitter.com" target="_blank" class="social-icon">
            <i class="bi bi-twitter"></i>
          </a>
          <a href="https://pinterest.com" target="_blank" class="social-icon">
            <i class="bi bi-pinterest"></i>
          </a>
        </div>
      </div>
    </div>
    
    <hr class="footer-divider">
    
    <div class="text-center">
      <p class="footer-copyright mb-0">
        © <?= date('Y') ?> CookHub. Tutti i diritti riservati.
      </p>
    </div>
  </div>
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const toggleButton = document.getElementById('themeToggle');
  const themeIcon = document.getElementById('themeIcon');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && prefersDark)) {
    document.body.classList.add('dark-mode');
    document.querySelectorAll('.navbar, footer, .card').forEach(el => el.classList.add('dark-mode'));
    document.querySelectorAll('.hamburger-icon-light, .hamburger-icon-dark').forEach(el => {
      el.classList.toggle('d-none');
    });
    themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
  }

  toggleButton.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    document.querySelectorAll('.navbar, footer, .card').forEach(el => el.classList.toggle('dark-mode'));
    document.querySelectorAll('.hamburger-icon-light, .hamburger-icon-dark').forEach(el => {
      el.classList.toggle('d-none');
    });

    const isDark = document.body.classList.contains('dark-mode');
    themeIcon.classList.toggle('bi-moon-stars-fill', !isDark);
    themeIcon.classList.toggle('bi-sun-fill', isDark);
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
  });
</script>

</body>
</html>
