<?php
session_start();

require_once "conexao_login.php";

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']);
$confirma = trim($_POST['confirma']);

// Verificações
if (empty($nome) || empty($email) || empty($senha) || empty($confirma)) {
    $_SESSION['erro_admin'] = "Preencha todos os campos!";
    header("Location: ../criar_admin.php");
    exit;
}

if ($senha !== $confirma) {
    $_SESSION['erro_admin'] = "As senhas não coincidem!";
    header("Location: ../criar_admin.php");
    exit;
}

// Verifica se email já existe
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['erro_admin'] = "Email já cadastrado!";
    header("Location: ../criar_admin.php");
    exit;
}

$stmt->close();

// INSERIR ADMIN
$hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha, role) 
        VALUES (?, ?, ?, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $hash);

if ($stmt->execute()) {

    // ADMIN CRIADO — SEM CRIAR LOJA
    $_SESSION['ok_admin'] = "Administrador criado com sucesso!";

} else {
    $_SESSION['erro_admin'] = "Erro ao criar admin!";
}

$stmt->close();
$conn->close();

header("Location: ../criar_admin.php");
exit;
