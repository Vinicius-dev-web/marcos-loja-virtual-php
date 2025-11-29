<?php
session_start();
require './conexao_login.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: usuário não autenticado.");
}

$usuario_id = $_SESSION['usuario_id'];

// Caminhos reais no seu PC
$produtosDir = "C:/xampp/htdocs/marcos_lojavirtual/uploads/produtos/";
$lojasDir = "C:/xampp/htdocs/marcos_lojavirtual/uploads/lojas/";

/* ======================================================
   1. APAGAR TODAS AS IMAGENS DOS PRODUTOS
====================================================== */
if (is_dir($produtosDir)) {

    $arquivos = glob($produtosDir . "*");

    foreach ($arquivos as $arquivo) {
        if (is_file($arquivo)) {
            unlink($arquivo);
        }
    }
}

/* ======================================================
   2. APAGAR IMAGENS DA LOJA
====================================================== */
if (is_dir($lojasDir)) {

    $arquivosLoja = glob($lojasDir . "*");

    foreach ($arquivosLoja as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

/* ======================================================
   3. Deletar produtos
====================================================== */
$stmtProd = $conn->prepare("DELETE FROM produtos WHERE usuario_id = ?");
$stmtProd->bind_param("i", $usuario_id);
$stmtProd->execute();
$stmtProd->close();

/* ======================================================
   4. Deletar loja
====================================================== */
$stmtLoja = $conn->prepare("DELETE FROM lojas WHERE usuario_id = ?");
$stmtLoja->bind_param("i", $usuario_id);
$stmtLoja->execute();
$stmtLoja->close();

/* ======================================================
   5. Deletar usuário
====================================================== */
$stmtUser = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
$stmtUser->bind_param("i", $usuario_id);
$stmtUser->execute();
$stmtUser->close();

/* ======================================================
   6. Finalizar sessão
====================================================== */
session_destroy();

header("Location: ../login.php?msg=Conta+excluída+com+sucesso");
exit;
?>
