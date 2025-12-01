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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">

    <link rel="icon" href="Bolvier.png">

    <title>Recuperar conta</title>
</head>

<body>

    <div class="form">
        <form method="POST">
            <span>Nova Senha</span>

            <label id="recuperarLabel">
                <i class="bi bi-key"></i>
                <input type="password" name="senha" placeholder="Digite a nova senha" required>
            </label>

            <button type="submit"><b>ALTERAR</b></button>
        </form>
    </div>

</body>

</html>