<?php
require "php/conexao.php";

if (!isset($_GET["token"])) {
    die("Token inválido.");
}

$token = $_GET["token"];

// Verificar token
$sql = "SELECT * FROM usuarios WHERE reset_token = ? AND reset_expira > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Token expirado ou inválido.");
}

$user = $res->fetch_assoc();

// Se enviou a nova senha
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $novaSenha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET senha = ?, reset_token = NULL, reset_expira = NULL WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $novaSenha, $user["id"]);
    $stmt->execute();

    echo "Senha alterada com sucesso! <a href='login.php'>Entrar</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="form">
    <form method="POST">
        <span>Nova Senha</span>

        <label>
            <i class="bi bi-key"></i>
            <input type="password" name="senha" placeholder="Digite a nova senha" required>
        </label>

        <button type="submit"><b>ALTERAR</b></button>
    </form>
</div>

</body>
</html>
