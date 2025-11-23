<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "loja_virtual"; // <-- banco já existente

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Erro ao conectar: " . $conn->connect_error);
}
?>
