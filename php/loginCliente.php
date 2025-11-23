<?php
session_start();
require 'conexao_login.php';

$erro = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['nome'];
            $_SESSION['usuario_id'] = $user['id']; 
            $stmt->close();
            $conn->close();
            header("Location: ../painel.php"); // Redireciona para painel
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Email não cadastrado!";
    }

    $stmt->close();
    $conn->close();
}

// Redireciona de volta para login.php apenas se houver erro
if (!empty($erro)) {
    $_SESSION['erro_login'] = $erro;
    header("Location: ../login.php");
    exit;
}
?>