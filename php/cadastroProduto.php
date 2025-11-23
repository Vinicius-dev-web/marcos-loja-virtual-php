<?php
require "./conexao.php";


$nome = $_POST['nome'];
$preco = $_POST['preco'];

// Pasta onde a imagem será salva
$pasta = "uploads/";
if (!is_dir($pasta)) {
    mkdir($pasta, 0777, true);
}

// Nome único para a imagem
$nomeImagem = uniqid() . "-" . $_FILES['imagem']['name'];
$caminhoImagem = $pasta . $nomeImagem;

// Move a imagem para a pasta
move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem);

// Cadastrar no banco
$sql = "INSERT INTO produtos (nome, preco, imagem) VALUES ('$nome', '$preco', '$caminhoImagem')";

if ($conn->query($sql)) {
    header("Location: painel.php?sucesso=1");
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>