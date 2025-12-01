<?php
session_start();
require __DIR__ . "/php/conexao.php"; // caminho CORRETO

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Campos do formulário
    $nome = trim($_POST['nome_fantasia'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');

    if (empty($nome) || empty($categoria)) {
        $_SESSION['erro_loja'] = "Nome e categoria são obrigatórios.";
        header("Location: painel.php");
        exit;
    }

    // Gera o slug a partir do nome
    $slug = strtolower($nome);                  // Tudo minúsculo
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug); // Remove caracteres especiais
    $slug = preg_replace('/\s+/', '-', $slug);  // Espaços viram hífen
    $slug = preg_replace('/-+/', '-', $slug);   // Remove hífens duplicados
    $slug = trim($slug, '-');                   // Remove hífens do início/fim

    // Pasta para upload de imagens
    $pasta = "uploads/lojas/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    try {
        if (!empty($_FILES['imagem']['name'])) {
            $nomeImg = uniqid() . "-" . basename($_FILES['imagem']['name']);
            $caminho = $pasta . $nomeImg;

            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
                throw new Exception("Erro ao enviar a imagem.");
            }

            $sql = "UPDATE lojas SET 
                        nome_fantasia = ?, 
                        descricao = ?, 
                        cor_tema = ?, 
                        slug = ?,
                        imagem = ?
                    WHERE usuario_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nome, $descricao, $categoria, $slug, $nomeImg, $usuario_id);

        } else {

            $sql = "UPDATE lojas SET 
                        nome_fantasia = ?, 
                        descricao = ?, 
                        cor_tema = ?, 
                        slug = ?
                    WHERE usuario_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nome, $descricao, $categoria, $slug, $usuario_id);
        }

        $stmt->execute();

        $_SESSION['sucesso_loja'] = "Loja atualizada com sucesso!";
    } catch (Exception $e) {
        $_SESSION['erro_loja'] = $e->getMessage();
    }

    header("Location: painel.php");
    exit;

} else {
    header("Location: painel.php");
    exit;
}
