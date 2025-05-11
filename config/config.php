<?php
/*$hostname=getenv("cookhubhost");
$username=getenv("cookhubusername");
$password=getenv("cookhubpassword");
$database=getenv("cookhubdb");*/
$hostname='cookhubsql.mysql.database.azure.com';
$username='cookhub_admin';
$password='LoreMelekLaSalvia!';
$database='cookhub';
$port="3306";
// creo la connessione
$conn=new mysqli($hostname,$username,$password,$database,$port);

// controllo la connessione
if ($conn->connect_error) {
  die("Connessione fallita: " . $conn->connect_error);
} 
// echo "Connessione ok";
?>