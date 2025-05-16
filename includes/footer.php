<footer class="bg-dark text-white text-center py-4 mt-5">
  <div class="container">
    <p class="mb-0">© <?= date('Y') ?> CookHub. Tutti i diritti riservati.</p>
  </div>
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const toggle = document.getElementById('themeToggle');
  const body = document.body;

  // Applica la preferenza salvata
  if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
    document.querySelectorAll('.navbar, footer, .card, .alert').forEach(el => el.classList.add('dark-mode'));
  }

  toggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    document.querySelectorAll('.navbar, footer, .card, .alert').forEach(el => el.classList.toggle('dark-mode'));

    // Salva la preferenza
    const theme = body.classList.contains('dark-mode') ? 'dark' : 'light';
    localStorage.setItem('theme', theme);

    // Cambia icona (opzionale)
    toggle.textContent = theme === 'dark' ? '☀️' : '🌙';
  });
</script>
</body>
</html>
