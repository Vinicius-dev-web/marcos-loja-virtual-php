<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sua_loja";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro ao conectar: " . $conn->connect_error);
}
?>
