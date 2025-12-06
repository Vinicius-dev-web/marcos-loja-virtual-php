<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$erro = $_SESSION['erro_login'] ?? "";
$msg_cadastro = $_SESSION['msg_cadastro'] ?? "";
unset($_SESSION['erro_login'], $_SESSION['msg_cadastro']);

require "php/conexao.php";
$usuario_id = $_SESSION['usuario_id'];

// Buscar dados da loja
$stmt = $conn->prepare("SELECT id, slug, imagem, cor_tema, nome_fantasia, telefone, categoria FROM lojas WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$loja = $result->fetch_assoc();

// Variáveis da loja
$loja_id = $loja['id'] ?? "";
$slug_loja = $loja['slug'] ?? "";
$imagem_loja = $loja['imagem'] ?? "";
$cor_tema = $loja['cor_tema'] ?? "#000000";
$nome_loja = $loja['nome_fantasia'] ?? "";
$categoria = $loja['categoria'] ?? "Sem descrição";
$telefone = $loja['telefone'] ?? "Sem telefone";
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

    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/painel.css">

    <link rel="icon" href="uploads/lojas/<?php echo $imagem_loja; ?>">

    <title>Painel de controle - Administrativo</title>

</head>

<body>

    <aside class="painel">

        <div class="painel-info">

            <div class="adm-site">
                <div class="info-adm">

                    <img src="Bolvier.png" alt="">
                    

                    <div>
                        <div class="title-start-user">
                            <h2>
                                <span>BolvierTeam</span>
                            </h2>
                        </div>
                        <h6 id="descrição_loja">
                            <span>Painel Administrativo</span>
                        </h6>
                    </div>
                </div>

                <!-- <button data-target="cog">Editar loja</button> -->
            </div>

            <ul>
                <li data-target="dashboard">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span><b>PAINEL</b></span>
                </li>
                <li data-target="produtos">
                    <i class="bi bi-box-seam-fill"></i>
                    <span><b>PRODUTOS</b></span>
                </li>
                <li data-target="create">
                    <i class="bi bi-plus-square-fill"></i>
                    <span><b>CRIAR</b></span>
                </li>
                <li data-target="cog">
                    <i class="bi bi-brush-fill"></i>
                    <span><b>Aparência</b></span>
                </li>
                <li data-target="loja" id="menuLoja">
                    <i class="bi bi-globe"></i>
                    <span><b>Minha Loja</b></span>
                </li>
                <!-- <li data-target="" id="">
                    <i class="las la-crown"></i>
                    <span>VIP</span>
                </li> -->
            </ul>

        </div>

        <div class="info-loja-painel">

            <div class="adm-user">
                <div class="info-adm">
                    <?php if (!empty($imagem_loja)): ?>
                    <img src="uploads/lojas/<?php echo $imagem_loja; ?>" alt="Foto da loja">
                    <?php endif; ?>

                    <div>
                        <div class="title-start-user">
                            <h2>
                                <?php echo htmlspecialchars($nome_loja); ?>
                            </h2>
                        </div>
                        <h6 id="descrição_loja">
                            <?php echo htmlspecialchars($categoria); ?>
                        </h6>
                    </div>
                </div>

                <!-- <button data-target="cog">Editar loja</button> -->
            </div>

            <div class="logout" id="logout" onclick="window.location.href='php/logout.php'">
                <i class="bi bi-box-arrow-right"></i>
                <span>SAIR</span>
            </div>

        </div>


    </aside>

    <nav class="main-content" style="display: none;">

        <div class="adm-user">
            <div class="info-adm">
                <?php if (!empty($imagem_loja)): ?>
                <img src="uploads/lojas/<?php echo $imagem_loja; ?>" alt="Foto da loja">
                <?php endif; ?>

                <div>
                    <div class="title-start-user">
                        <h2>
                            <?php echo htmlspecialchars($nome_loja); ?>>
                        </h2>
                    </div>
                    <h6 id="descrição_loja">
                        <?php echo htmlspecialchars($categoria); ?>
                    </h6>
                </div>
            </div>

            <!-- <button data-target="cog">Editar loja</button> -->
        </div>

        <!-- <div class="adm-info-up">
            <h2>Painel de controle</h2>
            <span>Administrativo</span>
        </div> -->

        <div class="info-now-up">
            <span id="dataAtual"></span>

            <button id="toggleThemeBtn" class="toggle-theme-btn">
                <i id="themeIcon" class="bi bi-brightness-high"></i>
            </button>
        </div>

    </nav>

    <main class="page">

        <section class="dashboard" id="dashboard">

            <h1>
                <b>
                    Bem-vindo de volta,
                    <?php echo htmlspecialchars($nome_loja); ?>
                </b>
            </h1>

            <span>Aqui estão todos os seus marcus e suas performaces na loja</span>

            <div class="dash-cards" id="dash-cards">


                <div class="card">
                    <h3>Estoque</h3>

                    <h2><b>22</b></h2>
                </div>
                <div class="card">
                    <h3>Pedidos realizados</h3>

                    <h2><b>40</b></h2>
                </div>
                <div class="card">
                    <h3>Ganhos totais</h3>

                    <h2><b>R$1.459,90</b></h2>
                </div>

            </div>

            <div class="form-div">

                <!-- <div class="tabela-container">
                    <table class="tabela-estilo">


                        <thead>

                            <tr>
                                <th>Foto</th>
                                <th>Produto</th>
                                <th>Preço</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        require "php/conexao.php";

                        $usuario_id = $_SESSION['usuario_id'];
                        $sql = "SELECT * FROM produtos WHERE usuario_id = $usuario_id ORDER BY id DESC";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($p = $result->fetch_assoc()) {
                                echo "<tr>
    <td><img src='" . $p['imagem'] . "' width='60'></td>
    <td>" . $p['nome'] . "</td>
    <td>R$ " . number_format($p['preco'], 2, ',', '.') . "</td>

</tr>";

                            }
                        } else {
                            echo "<tr><td colspan='6'>Nenhum produto cadastrado.</td></tr>";
                        }
                        ?>

                        </tbody>
                    </table>
                </div> -->

                <div class="infos-user">

                    <h2>Informações da loja</h2>

                    <div class="table-infos-user">

                        <span><b>Nome da loja:</b> <?php echo htmlspecialchars($nome_loja); ?></span>

                        <span><b>WhatsApp:</b> <?php echo htmlspecialchars($telefone); ?></span>

                        <span><b>Localização:</b> <i>Sem localização definida.</i></span>

                    </div>
                </div>
            </div>


        </section>

        <section class="produtos" id="produtos">

            <!-- <div class="adm-user">
                <div class="info-adm">
                    <?php if (!empty($imagem_loja)): ?>
                    <img src="uploads/lojas/<?php echo $imagem_loja; ?>" alt="Foto da loja">
                    <?php endif; ?>

                    <div>
                        <div class="title-start-user">
                            Olá,
                            <?php echo htmlspecialchars($nome_loja); ?> VINI!
                        </div>
                        <h4 id="descrição_loja">
                            <?php echo htmlspecialchars($categoria); ?>
                            Informática
                        </h4>
                    </div>
                </div>

                <button data-target="cog">Editar loja</button>
            </div> -->

            <h1>Produtos</h1>

            <label for="search">

                <input type="text" name="" id="search" placeholder="Pesquise aqui...">
                <i class="bi bi-search"></i>

            </label>

            <div class="tabela-container">
                <table class="tabela-estilo">


                    <thead>

                        <tr>
                            <th>Foto</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Tamanho</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require "php/conexao.php";

                        $usuario_id = $_SESSION['usuario_id'];
                        $sql = "SELECT * FROM produtos WHERE usuario_id = $usuario_id ORDER BY id DESC";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($p = $result->fetch_assoc()) {
                                echo "<tr>
    <td><img src='" . $p['imagem'] . "' width='60'></td>
    <td>" . $p['nome'] . "</td>
    <td>R$ " . number_format($p['preco'], 2, ',', '.') . "</td>
    <td>" . $p['tamanho'] . "</td>
    <td>
        <button class='btn-editar' onclick='editarProduto(" . $p['id'] . ", \"" . addslashes($p['nome']) . "\", " . $p['preco'] . ")'>
            <span>Editar</span>
        </button>
    </td>
</tr>";

                            }
                        } else {
                            echo "<tr><td colspan='6'>Nenhum produto cadastrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="create" id="create">

            <h1>Novo produto</h1>

            <div class="form-div" id="file-create">

                <form action="php/cadastroProduto.php" method="POST" enctype="multipart/form-data" class="form-prod">

                    <label id="labelImagemProd">
                        <i class="bi bi-card-image" id="iconeLabelProd"></i>
                        <span id="textoLabelProd">Coloque uma imagem*</span>

                        <input type="file" id="inputImagem" name="imagem" accept="image/*" required hidden>

                        <img id="previewImagemProd">
                    </label>

                    <div class="values-create" id="values-create">

                        <div class="input-values-create">

                            <input type="text" name="nome" placeholder="Nome do produto*" maxlength="25" required>

                            <input type="text" name="preco" step="0.01" placeholder="Preço do produto*" maxlength="6"
                                required>

                            <div class="select-info-outfit">

                                <!-- SELECT PRINCIPAL -->
                                <select class="choose-option" id="choose-option">
                                    <option value="">Tipo (opcional)</option>
                                    <option value="roupa">Roupa Adulto</option>
                                    <option value="roupa-infantil">Roupa Infantil</option>
                                    <option value="sapato">Sapato Adulto</option>
                                    <option value="sapato-infantil">Sapato Infantil</option>
                                </select>


                                <!-- TAMANHO SAPATO -->
                                <select class="checkBoxes" id="tam-sapato">
                                    <option value="null">Escolha um tamanho</option>
                                    <option value="33/34">33/34</option>
                                    <option value="34/35">34/35</option>
                                    <option value="35/36">35/36</option>
                                    <option value="36/37">36/37</option>
                                    <option value="37/38">37/38</option>
                                    <option value="38/39">38/39</option>
                                    <option value="39/40">39/40</option>
                                    <option value="40/41">40/41</option>
                                    <option value="41/42">41/42</option>
                                    <option value="42/43">42/43</option>
                                    <option value="43/44">43/44</option>
                                    <option value="44/45">44/45</option>
                                    <option value="45/46">45/46</option>
                                    <option value="46/47">46/47</option>
                                </select>

                                <select class="checkBoxes" id="tam-sapato-infantil">
                                    <option value="null">Escolha um tamanho</option>
                                    <option value="17/18">17/18</option>
                                    <option value="19/20">19/20</option>
                                    <option value="21/22">21/22</option>
                                    <option value="23/24">23/24</option>
                                    <option value="25/26">25/26</option>
                                    <option value="27/28">27/28</option>
                                    <option value="29/30">29/30</option>
                                    <option value="31/32">31/32</option>
                                </select>

                                <!-- TAMANHO ROUPA -->
                                <div id="tam-roupa" class="checkBoxes">

                                    <div class="checkBox">
                                        <div class="values">
                                            <span>PP</span>
                                            <input type="checkbox" value="PP">
                                        </div>
                                        <div class="values">
                                            <span>P</span>
                                            <input type="checkbox" value="P">
                                        </div>
                                        <div class="values">
                                            <span>M</span>
                                            <input type="checkbox" value="M">
                                        </div>
                                        <div class="values">
                                            <span>G</span>
                                            <input type="checkbox" value="G">
                                        </div>
                                        <div class="values">
                                            <span>GG</span>
                                            <input type="checkbox" value="GG">
                                        </div>
                                    </div>

                                </div>

                                <div id="tam-roupa-infantil" class="checkBoxes">

                                    <div class="checkBox">
                                        <div class="values"><span>RN</span><input type="checkbox" value="RN"></div>
                                        <div class="values"><span>P</span><input type="checkbox" value="P"></div>
                                        <div class="values"><span>M</span><input type="checkbox" value="M"></div>
                                        <div class="values"><span>G</span><input type="checkbox" value="G"></div>
                                        <div class="values"><span>1</span><input type="checkbox" value="1"></div>
                                        <div class="values"><span>2</span><input type="checkbox" value="2"></div>
                                        <div class="values"><span>3</span><input type="checkbox" value="3"></div>
                                        <div class="values"><span>4</span><input type="checkbox" value="4"></div>
                                        <div class="values"><span>6</span><input type="checkbox" value="6"></div>
                                        <div class="values"><span>8</span><input type="checkbox" value="8"></div>
                                        <div class="values"><span>10</span><input type="checkbox" value="10"></div>
                                        <div class="values"><span>12</span><input type="checkbox" value="12"></div>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <input type="hidden" name="tamanho" id="tamanho-final">
                        <button type="submit">Cadastrar</button>

                    </div>

                </form>

                <!-- <h1>Banner</h1>

                <form action="php/cadastroBanner.php" method="POST" enctype="multipart/form-data" class="form-banner">

                    <div class="banner-div">

                        <div class="label">

                            <label id="labelImagemBanner">

                                <i class="bi bi-card-image" id="iconeLabelBanner"></i>

                                <span id="textoLabelBanner">Coloque uma imagem*</span>

                                <input type="file" name="imagem" accept="image/*" required hidden>

                                <img id="previewImagemBanner">

                            </label>

                            <button type="submit">Cadastrar</button>
                        </div>

                        <div class="remove-div">
                            <?php
                            // Buscar banners do usuário
                            $stmtB = $conn->prepare("SELECT id, imagem FROM banners WHERE usuario_id = ?");
                            $stmtB->bind_param("i", $usuario_id);
                            $stmtB->execute();
                            $resultB = $stmtB->get_result();

                            while ($banner = $resultB->fetch_assoc()):
                                ?>
                                <div class="banner-item" data-id="<?php echo $banner['id']; ?>">
                                    <img src="uploads/banners/<?php echo htmlspecialchars($banner['imagem']); ?>"
                                        alt="Banner">
                                    <button class="remover-banner" type="button">Remover</button>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    </div>


                </form> -->

            </div>
        </section>

        <section class="cog" id="cog">

            <h1>Personalizar</h1>

            <div class="form-div">

                <form action="atualizar_loja.php" method="POST" class="form-input" enctype="multipart/form-data">

                    <div class="values-create" id="values-create">

                        <div class="input-values-create">

                            <input type="text" name="nome_fantasia" value="<?php echo htmlspecialchars($nome_loja); ?>"
                                maxlength="12" required>

                            <input type="text" name="telefone" id="telLabel" value="<?php echo htmlspecialchars($telefone); ?>">


                            <!-- <input type="text" name="descricao"placeholder="Descrição"
                                value="<?php echo htmlspecialchars($loja['descricao'] ?? ''); ?>"> -->

                            <select name="categoria" id="categoria" required>
                                <option value="Sem descrição" <?=($categoria=="Sem descrição" ? "selected" : "" ) ?>>Sem
                                    descrição</option>
                                <option value="Roupas" <?=($categoria=="Roupas" ? "selected" : "" ) ?>>Roupas</option>
                                <option value="Sapatos" <?=($categoria=="Sapatos" ? "selected" : "" ) ?>>Sapataria
                                </option>
                                <option value="Roupas e Sapatos" <?=($categoria=="Roupas e Sapatos" ? "selected" : "" )
                                    ?>>Roupas e sapatos</option>
                                <option value="Eletrônicos" <?=($categoria=="Eletrônicos" ? "selected" : "" ) ?>>
                                    Eletrônicos</option>
                                <option value="Informática" <?=($categoria=="Informática" ? "selected" : "" ) ?>>
                                    Informática</option>
                                <option value="Eletrônicos e Informática" <?=($categoria=="Eletrônicos e Informática"
                                    ? "selected" : "" ) ?>>Eletrônicos e informática</option>
                                <option value="Diversos" <?=($categoria=="Diversos" ? "selected" : "" ) ?>>Diversos
                                </option>
                            </select>


                            <input type="hidden" name="loja_id" value="<?php echo $loja_id; ?>">


                        </div>
                        <button type="submit">Salvar Alterações</button>
                    </div>

                    <label id="labelImagemCog">

                        <i class="bi bi-card-image" id="iconeLabelCog"></i>
                        <span id="textoLabelCog">Coloque uma imagem*</span>

                        <input type="file" id="inputImagem" name="imagem" accept="image/*" hidden>

                        <img id="previewImagemCog">
                    </label>

                </form>

            </div>
        </section>

        <section class="loja" id="loja">
            <div class="msg" id="msg">
                <h1>Você está acessando a loja...</h1>
                <span>Verifique se outra aba está aberta no seu navegador. Caso não esteja, considere como um erro
                    técnico ou que os arquivos ainda estejam sendo enviados ao servidor.</span>
                <img src="https://png.pngtree.com/png-clipart/20190120/ourmid/pngtree-go-to-bed-sleeping-pig-piggy-pig-sleeping-png-image_493040.png"
                    alt="error">
            </div>
        </section>

    </main>

    <!-- Modais edits -->

    <div class="edit-produto-table" id="edit-produto-table">

        <div class="edit-table">

            <div class="form">

                <input type="hidden" id="edit-id">

                <label>
                    <i class="bi bi-pencil"></i>
                    <input type="text" id="edit-nome" placeholder="Nome do produto" maxlength="25">
                </label>


                <label>
                    <i class="bi bi-pencil"></i>
                    <input type="number" id="edit-preco" placeholder="Preço do produto" step="0.01" maxlength="6">
                </label>

                <label class="upload-edit">
                    <i class="bi bi-image"></i>
                    <input type="file" id="edit-imagem" accept="image/*" hidden>
                </label>

                <button id="save-table">Salvar</button>

                <div class="btn-edit-table">
                    <button id="delete-produto">Excluir</button>
                    <button id="cancel">Cancelar</button>
                </div>

            </div>
        </div>
    </div>

    <div class="edit-destaque-create" id="edit-destaque-create">

        <form action="">

            <label for="imageDestaqueEdit" id="imageDestaqueLabel">

                <input type="file" name="" id="imageDestaqueEdit" hidden>

                <i class="bi bi-card-image"></i>

                <span>Adicione uma imagem*</span>

                <img src="" alt="" id="previewImagemDestaqueEdit">

            </label>

            <label for="inputDestaque" id="inputDestaqueLabel">
                <i class="bi bi-pencil-fill"></i>
                <input type="text" name="" id="inputDestaque" placeholder="Nome do destaque">
            </label>

            <button>Salvar</button>
            <button id="fechar">Fechar</button>
        </form>
    </div>

    <!-- Menu Mobile  -->

    <div class="menu-mobile">

        <ul class="mobile-menu">

            <li data-target="produtos">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>PAINEL</span>
            </li>
            <li data-target="create">
                <i class="bi bi-plus-square-fill"></i>
                <span>CRIAR</span>
            </li>
            <li data-target="cog">
                <i class="bi bi-brush-fill"></i>
                <span>EDITAR</span>
            </li>
            <li data-target="loja" id="menuLoja">
                <i class="bi bi-globe"></i>
                <span>LOJA</span>
            </li>
            <!-- <li data-target="" id="">
                    <i class="las la-crown"></i>
                    <span>VIP</span>
                </li> -->
        </ul>


    </div>

</body>

<script src="js/painel.js"></script>
<script src="js/datas.js"></script>
<script src="js/editTable.js"></script>
<script src="js/links.js"></script>
<script src="js/modais.js"></script>

<!--  -->

<script>
    document.getElementById("telLabel").addEventListener("input", function () {
        let v = this.value.replace(/\D/g, "");
        if (v.length > 11) v = v.slice(0, 11);

        if (v.length > 6) {
            this.value = `(${v.slice(0, 2)}) ${v.slice(2, 7)}-${v.slice(7)}`;
        } else if (v.length > 2) {
            this.value = `(${v.slice(0, 2)}) ${v.slice(2)}`;
        } else {
            this.value = v;
        }
    });
</script>

<!-- Tema / Modo claro/escuro -->
<script>
    function updateIcon(theme) {
        const icon = document.getElementById("themeIcon");
        if (!icon) return;
        if (theme === "light") {
            icon.classList.remove("bi-brightness-high");
            icon.classList.add("bi-moon");
        } else {
            icon.classList.remove("bi-moon");
            icon.classList.add("bi-brightness-high");
        }
    }

    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute("data-theme");
        const newTheme = currentTheme === "light" ? "dark" : "light";
        document.documentElement.setAttribute("data-theme", newTheme);
        localStorage.setItem("theme", newTheme);
        updateIcon(newTheme);
    }

    document.addEventListener("DOMContentLoaded", () => {
        const savedTheme = localStorage.getItem("theme") || "dark";
        document.documentElement.setAttribute("data-theme", savedTheme);
        updateIcon(savedTheme);

        // Loja - menu e botão
        const urlLoja = "loja/loja.php?slug=<?php echo $slug_loja; ?>";

        const liLoja = document.getElementById("menuLoja");
        if (liLoja) {
            liLoja.addEventListener("click", () => window.open(urlLoja, "_blank"));
            liLoja.querySelector("span").textContent = "Minha Loja";
        }

        const btnLoja = document.querySelector("#loja button");
        if (btnLoja) {
            btnLoja.addEventListener("click", () => window.open(urlLoja, "_blank"));
        }
    });
</script>

<script>
    document.getElementById("labelImagemProd").addEventListener("change", function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const preview = document.getElementById("previewImagemProd");
                preview.src = e.target.result;
                preview.style.display = "block"; // mostra a imagem

                document.getElementById("iconeLabelProd").style.display = "none";
                document.getElementById("textoLabelProd").style.display = "none";
            };

            reader.readAsDataURL(file);
        }
    });
</script>

<script>
    document.getElementById("labelImagemCog").addEventListener("change", function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const preview = document.getElementById("previewImagemCog");
                preview.src = e.target.result;
                preview.style.display = "block";

                document.getElementById("iconeLabelCog").style.display = "none";
                document.getElementById("textoLabelCog").style.display = "none";
            };

            reader.readAsDataURL(file);
        }
    });
</script>

<!-- Select roupas/sapatos -->

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const selectCategoria = document.getElementById("choose-option");
        const sapatoAdulto = document.getElementById("tam-sapato");
        const sapatoInfantil = document.getElementById("tam-sapato-infantil");
        const roupaAdulto = document.getElementById("tam-roupa");
        const roupaInfantil = document.getElementById("tam-roupa-infantil");

        const tamanhoFinal = document.getElementById("tamanho-final");

        // Oculta todos
        function ocultarTudo() {
            sapatoAdulto.style.display = "none";
            sapatoInfantil.style.display = "none";
            roupaAdulto.style.display = "none";
            roupaInfantil.style.display = "none";
        }

        ocultarTudo();

        // Monitorar a escolha da categoria
        selectCategoria.addEventListener("change", () => {

            ocultarTudo();
            tamanhoFinal.value = ""; // zera o tamanho escolhido

            let categoria = selectCategoria.value;

            if (categoria === "sapato") {
                sapatoAdulto.style.display = "block";
            }
            if (categoria === "sapato-infantil") {
                sapatoInfantil.style.display = "block";
            }
            if (categoria === "roupa") {
                roupaAdulto.style.display = "block";
            }
            if (categoria === "roupa-infantil") {
                roupaInfantil.style.display = "block";
            }
        });

        // Para selects de sapato
        sapatoAdulto.addEventListener("change", () => {
            tamanhoFinal.value = sapatoAdulto.value;
        });

        sapatoInfantil.addEventListener("change", () => {
            tamanhoFinal.value = sapatoInfantil.value;
        });

        // Para checkboxes de roupa
        document.querySelectorAll("#tam-roupa input[type=checkbox]").forEach(chk => {
            chk.addEventListener("change", () => {
                let selecionados = [...document.querySelectorAll("#tam-roupa input:checked")].map(e => e.value);
                tamanhoFinal.value = selecionados.join(",");
            });
        });

        // Para roupa infantil
        document.querySelectorAll("#tam-roupa-infantil input[type=checkbox]").forEach(chk => {
            chk.addEventListener("change", () => {
                let selecionados = [...document.querySelectorAll("#tam-roupa-infantil input:checked")].map(e => e.value);
                tamanhoFinal.value = selecionados.join(",");
            });
        });

    });
</script>

<!-- pesquisa -->

<script>
    document.getElementById("search").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll(".tabela-estilo tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

<!-- remover Banner -->

<script>
    document.querySelectorAll(".remover-banner").forEach(btn => {
        btn.addEventListener("click", function () {
            const bannerItem = this.closest(".banner-item");
            const bannerId = bannerItem.getAttribute("data-id");

            if (confirm("Deseja realmente remover este banner?")) {
                fetch("php/removerBanner.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "id=" + bannerId
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            bannerItem.remove(); // remove do HTML imediatamente
                        } else {
                            alert("Erro ao remover: " + data.msg);
                        }
                    })
                    .catch(err => alert("Erro na requisição: " + err));
            }
        });
    });

</script>

</html>