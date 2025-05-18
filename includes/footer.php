<footer class="bg-dark text-white text-center py-4 mt-5">
  <div class="container">
    <p class="mb-0">© <?= date('Y') ?> CookHub. Tutti i diritti riservati.</p>
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
