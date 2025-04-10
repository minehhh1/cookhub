<?php
$hostname="localhost";
$username="root";
$password="";
$database="es_1";
$port="3306";
// creo la connessione
$conn=new mysqli($hostname,$username,$password,$database,$port);

// controllo la connessione
if ($conn->connect_error) {
  die("Connessione fallita: " . $conn->connect_error);
} 
// echo "Connessione ok";
?>