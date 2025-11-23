<?php
header("Content-Type: application/json");
require "conexao.php";

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$result = $conn->query($sql);

$produtos = [];

while ($p = $result->fetch_assoc()) {
    $produtos[] = $p;
}

echo json_encode($produtos);
?>
