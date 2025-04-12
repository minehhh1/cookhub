<?php
$pageTitle = "Home";
$activePage = "home";
include '../includes/header.php';
include '../includes/navbar.php';
include '../includes/footer.php';

// Simulazione post (array vuoto)
$posts = array();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <hr>
    <!-- Form per creare un nuovo post -->
    <h2>Crea un nuovo post</h2>
    <form action="create_post.php" method="POST">
        <textarea name="post_content" rows="4" cols="50" placeholder="Scrivi qualcosa..."></textarea><br>
        <input type="submit" value="Pubblica">
    </form>
    <!-- Lista dei post -->
    <h2>Post pubblicati</h2>
    <?php if(empty($posts)): ?>
        <p>Non c'è ancora nessun post</p>
    <?php else: ?>
        <?php foreach($posts as $post): ?>
            <div>
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <small>Autore: <?php echo htmlspecialchars($post['author']); ?></small>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>