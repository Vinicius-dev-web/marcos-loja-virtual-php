<?php
session_start();
$mensagem = $_SESSION['msg_recuperar'] ?? "";
unset($_SESSION['msg_recuperar']);
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

        <form method="POST" action="php/enviarRecuperacao.php">
            <span>Recuperar Senha</span>

            <label id="recuperarLabel">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
            </label>

            <button type="submit"><b>ENVIAR LINK</b></button>

            <div style="color: green; margin-top: 10px;">
                <b>
                    <?php echo $mensagem; ?>
                </b>
            </div>

        </form>

    </div>

</body>

</html>