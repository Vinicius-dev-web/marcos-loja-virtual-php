<?php
require "conexao.php";
session_start();

// Verifica se a cor foi enviada
if (!isset($_POST["cor_tema"])) {
    die("Erro: Nenhuma cor recebida.");
}

$cor_tema = $_POST["cor_tema"];
$usuario_id = $_SESSION["usuario_id"];

// Atualiza no banco usando a coluna correta
$stmt = $conn->prepare("UPDATE lojas SET cor_tema = ? WHERE usuario_id = ?");
$stmt->bind_param("si", $cor_tema, $usuario_id);

if ($stmt->execute()) {
    header("Location: ../painel.php");
    exit;
} else {
    echo "Erro ao salvar cor.";
}
