<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/chatVendedor.css">

    <title>Bumi - Chat com Vendedor</title>

</head>

<body>

    <div class="painel-lateral">

        <ul>
            <li>
                <img src="get on the floor.jpg" alt="Vendedor">
                <span>Nome</span>
            </li>
            <li>
                <img src="get on the floor.jpg" alt="Vendedor">
                <span>Nome</span>
            </li>
            <li>
                <img src="get on the floor.jpg" alt="Vendedor">
                <span>Nome</span>
            </li>
            <li>
                <img src="get on the floor.jpg" alt="Vendedor">
                <span>Nome</span>
            </li>
            <li>
                <img src="get on the floor.jpg" alt="Vendedor">
                <span>Nome</span>
            </li>
        </ul>

        <button onclick="homePage()">
            <i class="bi bi-arrow-left"></i>
            <span>Sair</span>
        </button>

    </div>

    <div class="form">

        <form action="">

            <div class="chatMsg">

                <span>Teste</span>
                <span>Teste</span>
                <span>Teste</span>
                <span>Teste</span>

            </div>

            <div class="chatCommand">

                <label for="fileChatVendedor" class="fileChatVendedor">

                    <i class="bi bi-plus-lg"></i>

                    <input type="file" name="" id="fileChatVendedor" hidden>

                </label>

                <label for="msgChatVendedor" class="msgChatVendedor">

                    <input type="text" name="" id="msgChatVendedor" placeholder="Envie uma mensagem">

                </label>

                <label for="submitChatVendedor" class="submitChatVendedor">

                    <i class="bi bi-send"></i>

                    <input type="submit" name="" id="submitChatVendedor" hidden>

                </label>

            </div>
        </form>

    </div>
</body>

<script src="js/links.js"></script>

<script>
    function homePage(){

        location.href = "http://localhost/marcos_lojavirtual/index.php"
    }
</script>

</html>