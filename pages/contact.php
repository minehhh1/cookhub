<?php
$pageTitle = "Contatti";
include '../includes/header.php';
?>
<div class="page-wrapper d-flex flex-column min-vh-100">
  <main class="flex-grow-1">
    <div class="container mt-5">
        <h1 class="mb-4">Contattaci</h1>
        <p>
            Hai domande, suggerimenti o vuoi collaborare con noi? Scrivici!
        </p>
        <ul>
            <li>Email: <a href="mailto:info@cookhub.com">info@cookhub.com</a></li>
            <li>Instagram: <a href="https://instagram.com" target="_blank">@cookhub</a></li>
        </ul>
        <form class="mt-4" method="post" action="#">
            <div class="mb-3">
                <label for="email" class="form-label">La tua email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="tuo@email.com" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Messaggio</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</div>
