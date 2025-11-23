<?php
session_start();  // sempre no topo

require 'conexao_login.php';

$msg = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        $msg = "Usuário cadastrado com sucesso!";
    } else {
        $msg = "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Armazena a mensagem na sessão para exibir no login.php
$_SESSION['msg_cadastro'] = $msg;
header("Location: ../login.php");
exit;
?>
