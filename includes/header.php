<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?? "CookHub" ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icone di bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="../style/styles.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .like-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        font-size: 1.1rem;
    }
    
    .fa-heart {
        color: #ccc; /* Grigio chiaro */
        transition: all 0.3s;
    }
    
    .fa-heart.liked {
        color: #ff6b35; /* Arancione */
    }
    
    .fa-heart:hover {
        transform: scale(1.2);
    }
    
    .like-button span {
        margin-left: 5px;
        font-size: 0.9rem;
    }
</style>

</head>
<body style="font-family: 'Nunito', sans-serif;">
  <?php include '../includes/navbar.php'; ?>

