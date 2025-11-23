<?php
session_start();
require 'conexao_login.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['usuario_id'];

// Deleta o usuário do banco
$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Usuário removido → encerra a sessão
    session_unset();
    session_destroy();
    header("Location: ../login.php?conta_excluida=1");
    exit;
} else {
    echo "Erro ao excluir conta: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
