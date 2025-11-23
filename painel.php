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
    <link rel="stylesheet" href="css/painel.css">
    <link rel="stylesheet" href="css/modal.css">

    <title>Painel de controle - Administativo</title>

</head>

<body>

    <div class="painel">

        <div class="painel-info">

            <h1>MarcosTech</h1>

            <ul>
                <li data-target="produtos">
                    <i class="bi bi-speedometer2"></i>
                    <span>PAINEL</span>
                </li>
                <li data-target="create">
                    <i class="bi bi-images"></i>
                    <span>PRODUTO</span>
                </li>
                <li data-target="users">
                    <i class="bi bi-people"></i>
                    <span>USUÁRIOS</span>
                </li>
                <li data-target="cog">
                    <i class="bi bi-building"></i>
                    <span>EMPRESA</span>
                </li>
                <li data-target="loja" onclick="loja()">
                    <i class="bi bi-basket3"></i>
                    <span>Loja</span>
                </li>
            </ul>


        </div>

        <!-- <button>sair</button> -->

        <div class="logout" id="logout" onclick="logout()">
            <i class="bi bi-box-arrow-right"></i>
            <span>SAIR</span>
        </div>

    </div>

    <nav class="main-content">

        <div class="adm-info-up">

            <h2>Marcos</h2>
            <span>Administrador</span>

        </div>

        <div class="info-now-up">

            <span id="dataAtual"></span>
            <!-- <i class="bi bi-cloud"></i> -->

            <button id="data-theme"  onclick="toggleTheme()">
                <!-- <span>Tema</span> -->
                <i id="themeIcon" class="bi bi-brightness-high"></i>
            </button>

        </div>

    </nav>

    <main class="page">

        <section class="produtos" id="produtos">

            <!-- <div class="info-pdt-cards">
                <div class="info-card" id="estoque">

                    <div class="title-card">
                        <h2>Estoque</h2>
                        <i class="bi bi-archive"></i>
                    </div>

                    <span class="qntd-prod" id="qntd-prod"><b>0</b></span>

                </div>
            </div> -->

            <div class="tabela-container">

                <table class="tabela-estilo">

                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Editar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        require "php/conexao.php";

                        if ($conn->connect_error) {
                            die("Erro de conexão: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM produtos ORDER BY id DESC";
                        $result = $conn->query($sql);

                        while ($p = $result->fetch_assoc()) {
                            echo "
        <tr>
            <td><img src='" . $p['imagem'] . "' width='60'></td>
            <td>" . $p['nome'] . "</td>
            <td>R$ " . number_format($p['preco'], 2, ',', '.') . "</td>
            <td>" . date('d/m/Y', strtotime($p['data_criacao'])) . "</td>
            <td>" . date('H:i', strtotime($p['data_criacao'])) . "</td>
            <td><i class='bi bi-pencil-square' onclick='editProduto(" . $p['id'] . ")'></i></td>
        </tr>
        ";
                        }
                        ?>
                    </tbody>


                </table>
            </div>

            <!-- <div class="cards-prod">

                <img src="img/GARRAFINHA-C-SILICONE-BRANCO.webp" alt="sem foto">

                <h2>Produto</h2>
                <span>R$0,00</span>
            </div> -->

        </section>

        <section class="create" id="create">

            <div class="form-div" id="file-create">

                <h2>Cadastrar Produto</h2>

                <form action="php/cadastroProduto.php" method="POST" enctype="multipart/form-data">

                    <label>Nome do Produto</label>
                    <input type="text" name="nome" required>

                    <label>Preço</label>
                    <input type="number" name="preco" step="0.01" required>

                    <label>Imagem</label>
                    <input type="file" name="imagem" accept="image/*" required>

                    <button type="submit">Cadastrar</button>

                </form>

            </div>
        </section>


        <section class="users" id="users">

            <div class="form-div">

                <form action="">

                    <label for="file" id="file-user">

                        <i class="bi bi-person-bounding-box"></i>
                        <span>Adicione um perfil</span>

                        <input type="file" name="" id="file" hidden>

                    </label>

                    <input type="text" name="" id="name-user" placeholder="Nome do funcionário" required>

                    <input type="tel" name="" id="email-user" placeholder="Email do usuário" required>

                    <input type="password" name="" id="pwr-user" placeholder="Senha" required>

                    <input type="tel" name="" id="tel-user" placeholder="Número de telefone (opcional)">

                    <input type="text" name="" id="date-user" placeholder="Data de nascimento (opcional)">

                    <!-- <div class="checkboxes">

                        <ul>
                            <li>
                                <span>Permitir enviar produtos</span>
                                <input type="checkbox" checked>
                            </li>
                            <li>
                                <span>Permitir editar produtos</span>
                                <input type="checkbox" checked>
                            </li>
                            <li>
                                <span>Permitir cadastrar usuários</span>
                                <input type="checkbox">
                            </li>
                        </ul>
                    </div> -->

                    <button class="submit" id="submit">Criar</button>

                </form>
            </div>

        </section>

        <section class="cog" id="cog">

            <div class="form-div">

                <form action="">

                    <label for="file" id="file-cog">

                        <i class="bi bi-building-gear"></i>
                        <span>Adicione uma logo</span>

                        <input type="file" name="" id="file" hidden>

                    </label>

                    <input type="text" name="" id="cog-name-user" placeholder="Nome da empresa">

                    <input type="tel" name="" id="cog-tel-user" placeholder="Número de telefone (opcional)">

                    <!-- <input type="text" name="" id="date-user" placeholder="Data de nascimento (opcional)"> -->

                    <button class="submit" id="submit">Salvar</button>

                </form>
            </div>

        </section>

        <section class="loja" id="loja">

            <div class="msg" id="msg">

                <h1>Você está acessando a loja...</h1>

                <span>Verifique se outra aba está aberta no seu navegador. Caso não esteja, considere como um erro no
                    sistema ou recursos adicionais que estão sendo enviados ao servidor.</span>

                <img src="https://png.pngtree.com/png-clipart/20190120/ourmid/pngtree-go-to-bed-sleeping-pig-piggy-pig-sleeping-png-image_493040.png"
                    alt="error">

            </div>
        </section>

    </main>

    <!-- Editar produto -->

    <div class="edit-produto-table" id="edit-produto-table">

        <div class="edit-table">

            <div class="form">

                <input type="text" name="" id="" placeholder="Nome do produto">
                <input type="text" name="" id="" placeholder="Preço do produto">

                <button>Excluir</button>

                <div class="btn-edit-table">

                    <button id="save-table">Salvar</button>
                    <button id="cancel">Cancelar</button>

                </div>

            </div>
        </div>
    </div>

</body>

<script>

    function logout() {
        location.href = "login.html"
    }
</script>

<script src="/marcos_lojavirtual/js/painel.js"></script>
<script src="/marcos_lojavirtual/js/datas.js"></script>
<script src="/marcos_lojavirtual/js/editTable.js"></script>
<script src="/marcos_lojavirtual/js/cadastroProduto.js"></script>
<script src="/marcos_lojavirtual/js/links.js"></script>


<script>
    function loja() {

        // location.href = "index.html"

        window.open('https://marcos-loja.vercel.app/', '_blank')
    }
</script>

<script>
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute("data-theme");
        const newTheme = currentTheme === "light" ? "dark" : "light";

        document.documentElement.setAttribute("data-theme", newTheme);
        localStorage.setItem("theme", newTheme);

        updateIcon(newTheme);
    }

    function updateIcon(theme) {
        const icon = document.getElementById("themeIcon");

        if (theme === "light") {
            icon.classList.remove("bi-brightness-high");
            icon.classList.add("bi-moon");
        } else {
            icon.classList.remove("bi-moon");
            icon.classList.add("bi-brightness-high");
        }
    }

    // Carregar tema salvo
    const savedTheme = localStorage.getItem("theme") || "dark";
    document.documentElement.setAttribute("data-theme", savedTheme);
    updateIcon(savedTheme);
</script>


</html>