<?php
session_start();
$erro = $_SESSION['erro_admin'] ?? "";
$ok = $_SESSION['ok_admin'] ?? "";
unset($_SESSION['erro_admin'], $_SESSION['ok_admin']);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            width: 350px;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px #0002;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #4A73FF;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .msg {
            margin-top: 10px;
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Cadastrar Admin</h2>

        <form action="php/processa_admin.php" method="POST">
            <input type="text" name="nome" placeholder="Nome do Admin" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="password" name="confirma" placeholder="Confirmar Senha" required>
            <button type="submit">Criar Admin</button>
        </form>

        <?php if ($erro): ?>
            <div class="msg"><?= $erro ?></div>
        <?php endif; ?>

        <?php if ($ok): ?>
            <div class="msg success"><?= $ok ?></div>
        <?php endif; ?>
    </div>

</body>

</html>