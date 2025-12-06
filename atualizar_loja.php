<?php
session_start();
require __DIR__ . "/php/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome_fantasia'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if (empty($nome) || empty($telefone) || empty($categoria)) {
        $_SESSION['erro_loja'] = "Nome, telefone e categoria são obrigatórios.";
        header("Location: painel.php");
        exit;
    }

    // SLUG
    $slug = strtolower($nome);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/\s+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $pasta = "uploads/lojas/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    try {

        // SE TIVER IMAGEM
        if (!empty($_FILES['imagem']['name'])) {
            $nomeImg = uniqid() . "-" . basename($_FILES['imagem']['name']);
            $caminho = $pasta . $nomeImg;

            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
                throw new Exception("Erro ao enviar a imagem.");
            }

            $sql = "UPDATE lojas SET 
                        nome_fantasia = ?, 
                        descricao = ?, 
                        categoria = ?, 
                        telefone = ?,
                        slug = ?,
                        imagem = ?
                    WHERE usuario_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $nome, $descricao, $categoria, $telefone, $slug, $nomeImg, $usuario_id);

        } else {
            // SEM IMAGEM
            $sql = "UPDATE lojas SET 
                        nome_fantasia = ?, 
                        descricao = ?, 
                        categoria = ?, 
                        telefone = ?,
                        slug = ?
                    WHERE usuario_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nome, $descricao, $categoria, $telefone, $slug, $usuario_id);
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