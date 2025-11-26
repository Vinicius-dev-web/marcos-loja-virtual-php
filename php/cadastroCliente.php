<?php
session_start();
require 'conexao_login.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // 1. Cadastrar usuário
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {

        $usuario_id = $conn->insert_id;

        // Gerar slug
        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $nome));

        // Evitar slug duplicado
        $checkSlug = $conn->prepare("SELECT id FROM lojas WHERE slug = ?");
        $checkSlug->bind_param("s", $slug);
        $checkSlug->execute();
        $checkSlug->store_result();

        if ($checkSlug->num_rows > 0) {
            $slug .= "-" . $usuario_id;
        }

        // --------------------------
        // UPLOAD DA IMAGEM DA LOJA
        // --------------------------

        $imagem_nome = null;

        if (!empty($_FILES['imagem']['name'])) {

            // Caminho real absoluto
            $pasta = __DIR__ . "/../uploads/lojas/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $imagem_nome = "loja_" . $usuario_id . "_" . time() . "." . $ext;

            // Salva fisicamente no servidor
            move_uploaded_file($_FILES['imagem']['tmp_name'], $pasta . $imagem_nome);
        }


        // Criar loja com imagem
        $sqlLoja = "INSERT INTO lojas (usuario_id, nome_fantasia, slug, imagem) 
                    VALUES (?, ?, ?, ?)";
        $stmtLoja = $conn->prepare($sqlLoja);
        $stmtLoja->bind_param("isss", $usuario_id, $nome, $slug, $imagem_nome);
        $stmtLoja->execute();

        $msg = "Usuário e loja criados com sucesso!";

        $_SESSION['slug_loja'] = $slug;

    } else {
        $msg = "Erro ao cadastrar usuário: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

$_SESSION['msg_cadastro'] = $msg;
header("Location: ../login.php");
exit;
?>