<?php
header("Content-Type: application/json");
require "conexao.php";

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$result = $conn->query($sql);

$produtos = [];

while ($p = $result->fetch_assoc()) {
    $p['imagem'] = "img/" . $p['imagem']; // caminho correto sem mudar pastas
    $produtos[] = $p;
}

echo json_encode($produtos);
