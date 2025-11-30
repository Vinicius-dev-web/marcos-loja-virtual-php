<?php
session_start();
$mensagem = $_SESSION['msg_recuperar'] ?? "";
unset($_SESSION['msg_recuperar']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="form">

    <form method="POST" action="php/enviarRecuperacao.php">
        <span>Recuperar Senha</span>

        <label>
            <i class="bi bi-envelope"></i>
            <input type="email" name="email" placeholder="Digite seu e-mail" required>
        </label>

        <button type="submit"><b>ENVIAR LINK</b></button>

        <div style="color: green; margin-top: 10px;">
            <b><?php echo $mensagem; ?></b>
        </div>

    </form>

</div>

</body>
</html>
