<?php
session_start();

require_once "conexao_login.php"; // AJUSTE SE NECESSÁRIO

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']);
$confirma = trim($_POST['confirma']);

// Verificações básicas
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

// Insere admin
$hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha, role) VALUES (?, ?, ?, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $hash);

if ($stmt->execute()) {

    // ✔ Pega o ID do usuário recém-criado
    $user_id = $stmt->insert_id;

    // ✔ Criando slug único baseado no nome
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $nome));
    $slug = trim($slug, '-');

    // ✔ Criar loja automaticamente
    $sql_loja = "INSERT INTO lojas (usuario_id, nome_fantasia, slug) VALUES (?, ?, ?)";
    $stmt_loja = $conn->prepare($sql_loja);
    $stmt_loja->bind_param("iss", $user_id, $nome, $slug);
    $stmt_loja->execute();

    $_SESSION['ok_admin'] = "Admin criado com sucesso! Loja criada automaticamente.";

} else {
    $_SESSION['erro_admin'] = "Erro ao criar admin!";
}

$stmt->close();
$conn->close();

header("Location: ../criar_admin.php");
exit;

?>
