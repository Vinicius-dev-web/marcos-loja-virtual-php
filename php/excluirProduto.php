<?php
require "conexao.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID não recebido!");
}

$stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);

$stmt->execute();

// Depois de excluir, volta para a página principal
header("Location: ../painel.php");
exit;
