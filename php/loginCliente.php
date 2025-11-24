<?php
session_start();
require __DIR__ . '/conexao_login.php'; // caminho seguro

$erro = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        $erro = "Preencha todos os campos!";
    } else {

        // Busca usuário pelo email
        $sql = "SELECT id, nome, email, senha, role FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Achou usuário
            if ($result->num_rows === 1) {

                $user = $result->fetch_assoc();

                // Verifica senha
                if (password_verify($senha, $user['senha'])) {

                    // Salva a sessão
                    $_SESSION['usuario'] = $user['nome'];
                    $_SESSION['usuario_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'] ?: 'user';

                    // Libera recursos
                    $stmt->close();
                    $conn->close();

                    // Redireciona conforme a role
                    if ($_SESSION['role'] === 'admin') {
                        header("Location: ../adminMasterPanel.php");
                        exit;
                    }

                    header("Location: ../painel.php");
                    exit;

                } else {
                    $erro = "Senha incorreta!";
                }

            } else {
                $erro = "Email não cadastrado!";
            }

            $stmt->close();
        } else {
            $erro = "Erro interno ao consultar o banco!";
        }
    }

    $conn->close();
}

// Se ocorrer erro, volta para o login
if (!empty($erro)) {
    $_SESSION['erro_login'] = $erro;
    header("Location: ../login.php");
    exit;
}
?>
