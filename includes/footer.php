<footer class="bg-dark text-white text-center py-5 mt-5 shadow-lg footer-custom">
  <div class="container">
    <div class="row align-items-center mb-3">
      <div class="col-md-4 mb-2 mb-md-0">
        <a href="/" class="text-white text-decoration-none fs-4 fw-bold">
          </i>CookHub
        </a>
      </div>
      <div class="col-md-4 mb-2 mb-md-0">
        <a href="/about.php" class="text-white-50 text-decoration-none mx-2">Chi siamo</a>
        <a href="/contact.php" class="text-white-50 text-decoration-none mx-2">Contatti</a>
        <a href="/privacy.php" class="text-white-50 text-decoration-none mx-2">Privacy</a>
      </div>
      <div class="col-md-4">
        <a href="https://facebook.com" target="_blank" class="text-white-50 mx-1"><i class="bi bi-facebook fs-5"></i></a>
        <a href="https://instagram.com" target="_blank" class="text-white-50 mx-1"><i class="bi bi-instagram fs-5"></i></a>
        <a href="https://twitter.com" target="_blank" class="text-white-50 mx-1"><i class="bi bi-twitter fs-5"></i></a>
      </div>
    </div>
    <hr class="border-secondary my-3">
    <p class="mb-0 small text-white-50">© <?= date('Y') ?> CookHub. Tutti i diritti riservati.</p>
  </div>
</footer>
<style>
  .footer-custom {
    background: linear-gradient(90deg, #232526 0%, #414345 100%);
    border-top-left-radius: 1.5rem;
    border-top-right-radius: 1.5rem;
    letter-spacing: 0.03em;
  }
  .footer-custom a:hover {
    color: #ffc107 !important;
    text-decoration: underline;
  }
</style>
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
