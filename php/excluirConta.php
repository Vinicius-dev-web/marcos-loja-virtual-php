<?php
session_start();
require 'conexao_login.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['usuario_id'];

// 1. Buscar imagens dos produtos antes de excluir
$sqlImgs = "SELECT imagem FROM produtos WHERE usuario_id = ?";
$stmtImgs = $conn->prepare($sqlImgs);
$stmtImgs->bind_param("i", $id);
$stmtImgs->execute();
$resultImgs = $stmtImgs->get_result();

// Deleta os arquivos fisicamente
while ($row = $resultImgs->fetch_assoc()) {
    $caminho = "../" . $row['imagem'];
    if (file_exists($caminho)) {
        unlink($caminho);
    }
}
$stmtImgs->close();

// 2. Excluir o usuário (e o CASCADE apaga os produtos)
$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
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
