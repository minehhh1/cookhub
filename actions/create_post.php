<?php
session_start();
require_once '../config/config.php'; // File di configurazione del DB

$contenuto = $_POST['post_content'] ?? '';

if (!isset($_SESSION['id_utente'])) {
    header("Location: index.php");
    exit;
}

$id_utente = $_SESSION['id_utente'];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $contenuto = $_POST['post_content'];

	$sql = "INSERT INTO post(contenuto, data_creazione, id_utente) VALUES( ?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$temp2 = date('Y-m-d');
	$stmt->bind_param("sss", $contenuto, $temp2, $id_utente);

	if($stmt->execute()){
		echo "Post creato correttamente";
		//$_SESSION[''] = ;

		header("location: ../pages/index.php");
	}else{
		echo "Inserimento fallito: " . $stmt->error;
	}
}

if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    