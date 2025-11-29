<?php
session_start(); // precisa para acessar o usuário logado
require "./conexao_login.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: usuário não autenticado.");
}

$usuario_id = $_SESSION['usuario_id'];

// Recebe os dados do formulário
$nome = $_POST['nome'];
$preco = $_POST['preco'];

// Pasta onde a imagem será salva
$pasta = "../uploads/produtos/";
if (!is_dir($pasta)) {
    mkdir($pasta, 0777, true);
}

// Arquivo enviado
$arquivo = $_FILES['imagem'];
$nomeOriginal = basename($arquivo['name']);
$tipoArquivo = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
$nomeImagem = uniqid() . "-" . $nomeOriginal;

// Tipos de imagem permitidos
$tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Tamanho máximo (5 MB)
$tamanhoMaximo = 5 * 1024 * 1024;

// Verificações
if (!in_array($tipoArquivo, $tiposPermitidos)) {
    die("Erro: Tipo de arquivo não permitido.");
}

if ($arquivo['size'] > $tamanhoMaximo) {
    die("Erro: Arquivo muito grande.");
}

// Move o arquivo para a pasta correta
if (move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeImagem)) {

    // Caminho salvo no banco (caminho usado pelo navegador)
    $caminhoImagem = "uploads/produtos/" . $nomeImagem;

    // Inserção no banco com o usuario_id
    $sql = "INSERT INTO produtos (nome, preco, imagem, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $nome, $preco, $caminhoImagem, $usuario_id);

    if ($stmt->execute()) {
        header("Location: ../painel.php?sucesso=1");
        exit;
    } else {
        echo "Erro ao cadastrar produto: " . $stmt->error;
    }

} else {
    echo "Erro ao enviar a imagem.";
}

$conn->close();
?>
