<?php
require "../php/conexao.php";

// Verifica se recebeu o slug
if (!isset($_GET["slug"])) {
    die("Loja não encontrada.");
}

$slug = $_GET["slug"];

// Buscar a loja pelo slug
$sql = "SELECT * FROM lojas WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$loja = $stmt->get_result()->fetch_assoc();

if (!$loja) {
    die("Loja não existe.");
}

$usuario_id = $loja["usuario_id"]; // loja pertence a esse usuário
$nome_loja = $loja["nome_fantasia"];
$imagem_db = $loja["imagem"] ?? ""; // o que está salvo no banco (pode ser nome do arquivo ou caminho)

// Função auxiliar para resolver o caminho correto da imagem (tenta várias possibilidades)
function resolverCaminhoImagemLoja($valorDb)
{
    // local onde este script está (loja/loja.php), precisamos subir 1 nível para acessar uploads
    $baseDir = __DIR__ . "/../"; // caminho físico para a raiz do projeto
    $candidates = [];

    // Normaliza
    $v = trim($valorDb);

    if ($v === "" || $v === null) {
        return null;
    }

    // Se o valor já contém "http" ou começa com "/" -> usa como está (externo ou absoluto)
    if (preg_match('#^https?://#i', $v) || strpos($v, '/') === 0) {
        return $v;
    }

    // Possíveis formatos que podem estar no DB:
    // 1) "uploads/loja/arquivo.jpg"
    // 2) "uploads/lojas/arquivo.jpg"
    // 3) "uploads/arquivo.jpg"
    // 4) "loja/arquivo.jpg"
    // 5) "arquivo.jpg" (apenas nome do arquivo, comum)
    // 6) "../uploads/loja/arquivo.jpg"
    // 7) any other (try raw)

    $candidates[] = 'uploads/loja/' . $v;
    $candidates[] = 'uploads/lojas/' . $v;
    $candidates[] = 'uploads/' . $v;
    $candidates[] = 'loja/' . $v;
    $candidates[] = $v;
    $candidates[] = '../' . $v;
    $candidates[] = $v; // fallback

    foreach ($candidates as $rel) {
        // path físico para verificar existência
        $physical = realpath($baseDir . $rel);
        if ($physical && file_exists($physical)) {
            // devolve caminho relativo para o HTML (a partir de loja/loja.php precisamos subir 1 nível)
            // Se $rel já começa com '../' ou '/', não modif.
            if (strpos($rel, '/') === 0) {
                return $rel;
            }
            // Caso retornado deve ser acessível via ../<rel> porque estamos em /loja/loja.php
            return '../' . $rel;
        }
    }

    // se não achou, tenta usar $v como URL absoluta se tiver http
    if (preg_match('#^https?://#i', $v))
        return $v;

    // nada encontrado
    return null;
}

// resolve imagem da loja
$imagem_loja_path = resolverCaminhoImagemLoja($imagem_db);

// placeholder se não tiver imagem
if (!$imagem_loja_path) {
    $imagem_loja_path = '../uploads/default-loja.png'; // ajuste: coloque um placeholder nesse caminho
    // se não existir placeholder, podemos usar um externo
    if (!file_exists(__DIR__ . '/../uploads/default-loja.png')) {
        $imagem_loja_path = 'https://via.placeholder.com/300x120?text=Loja';
    }
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
        href="https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="loja.css">

    <title>
        <?php echo htmlspecialchars($nome_loja) ?> - Loja Virtual
    </title>

</head>

<body>

    <nav>

        <span class="logo" id="logo">
            <?php echo htmlspecialchars($nome_loja) ?>
        </span>

        <div class="icons-menu">

            <div class="bag-area">
                <i class="bi bi-handbag-fill" id="abrirCarrinho"></i>
                <span id="contadorCarrinho">0</span>
            </div>

            <div class="menu-mobile" id="abrirMenuMobile">
                <i class="bi bi-list"></i>
            </div>

        </div>

    </nav>

    <aside class="esquerda" id="esquerda">

        <div class="fecharMenuMobile" id="fecharMenuMobile">
            <i class="bi bi-arrow-left" style="margin-right: 10px;"></i>
            <span>Voltar</span>
        </div>

        <div class="menu-left">

            <div class="info-client">
                <img src="<?php echo $imagem_loja_path ?>" alt="<?php echo htmlspecialchars($nome_loja) ?>"
                    loading="lazy">

                <h4>
                    <?php echo htmlspecialchars($nome_loja) ?>
                </h4>

            </div>

            <ul>

                <li>
                    <i class="bi bi-house"></i>
                    <span>PAGINA INICIAL</span>
                </li>
                <li>
                    <i class="bi bi-columns-gap"></i>
                    <span>PRODUTOS</span>
                </li>
                <li>
                    <details>

                        <summary>
                            <i class="bi bi-funnel"></i>
                            <span>FILTRAR</span>
                        </summary>

                        <div class="list-deitails">
                            <span>Camisas</span>
                            <span>Perfumes</span>
                            <span>Outros</span>
                        </div>

                    </details>
                </li>

            </ul>

        </div>

    </aside>

    <!-- ----------- CARRINHO ----------- -->

    <div id="carrinho">
        <button id="fecharCarrinho">
            <i class="bi bi-x-lg"></i>
        </button>

        <h2>Seu Carrinho</h2>
        <div id="lista-carrinho"></div>
        <button class="btn-finalizar" id="btnFinalizar">Finalizar Pedido</button>
    </div>

    <header>
        <img class="header-banner"
            src="https://marketplace.canva.com/EAFONczDVWo/1/0/1600w/canva-banner-promo%C3%A7%C3%A3o-de-roupas-para-site-marrom-e-cinza-Yv34J28l6yU.jpg"
            alt="Banner">
    </header>

    <main class="page" id="page">

        <section class="home" id="home">
            <div class="info-client">

                <img src="<?php echo $imagem_loja_path ?>" alt="<?php echo htmlspecialchars($nome_loja) ?>"
                    loading="lazy">

                <h1>
                    <?php echo htmlspecialchars($nome_loja) ?>
                </h1>

            </div>
        </section>


        <!-- ----------- Produtos ----------- -->

        <section class="produtos" id="produtos">

            <h2>Produtos</h2>

            <div id="lista-produtos" class="lista-produtos">
                <?php
                $sql = "SELECT * FROM produtos WHERE usuario_id = ? ORDER BY id DESC";
                $stmtProdutos = $conn->prepare($sql);
                $stmtProdutos->bind_param("i", $usuario_id);
                $stmtProdutos->execute();
                $result = $stmtProdutos->get_result();

                if ($result && $result->num_rows > 0) {
                    while ($p = $result->fetch_assoc()) {
                        // resolve caminho da imagem do produto de forma segura
                        $prod_img_db = $p['imagem'] ?? '';
                        $prod_candidates = [
                            'uploads/loja/' . $prod_img_db,
                            'uploads/lojas/' . $prod_img_db,
                            'uploads/' . $prod_img_db,
                            $prod_img_db,
                        ];
                        $prod_path = null;
                        foreach ($prod_candidates as $c) {
                            $physical = realpath(__DIR__ . "/../" . $c);
                            if ($physical && file_exists($physical)) {
                                $prod_path = '../' . $c;
                                break;
                            }
                        }
                        if (!$prod_path) {
                            // tenta usar como já relativo (se por exemplo p['imagem'] for 'uploads/loja/x.png')
                            if ($prod_img_db && (strpos($prod_img_db, 'uploads/') === 0 || strpos($prod_img_db, '../') === 0)) {
                                $prod_path = strpos($prod_img_db, '../') === 0 ? $prod_img_db : '../' . $prod_img_db;
                            } else {
                                $prod_path = '../uploads/default-prod.png';
                                if (!file_exists(__DIR__ . '/../uploads/default-prod.png')) {
                                    $prod_path = 'https://via.placeholder.com/300?text=Produto';
                                }
                            }
                        }

                        echo '<div class="card">
            <img src="' . htmlspecialchars($prod_path) . '" alt="' . htmlspecialchars($p['nome']) . '" loading="lazy">
            <h3>' . htmlspecialchars($p['nome']) . '</h3>
            <p class="preco"><b>R$ ' . number_format($p['preco'], 2, ',', '.') . '</b></p>
            <button class="btn-comprar" 
                data-produto="' . htmlspecialchars($p['nome']) . '" 
                data-preco="' . $p['preco'] . '" 
                data-imagem="' . htmlspecialchars($prod_path) . '">
                Adicionar ao Carrinho
            </button>
        </div>';
                    }
                } else {
                    echo '<p>Nenhum produto cadastrado nesta loja.</p>';
                }

                $conn->close();
                ?>

            </div>

        </section>

        <!-- ----------- banners -----------  -->

        <section class="banners" id="banners">

            <h2>Destaques</h2>

            <div class="banners-div" id="banners-div">

                <img src="https://marketplace.canva.com/EAF0RxuySjc/1/0/800w/canva-banner-de-black-friday-formato-paisagem-org%C3%A2nico-delicado-em-lavanda-e-cinza-ard%C3%B3sia-yiGSUITHLd0.jpg"
                    alt="banner">

            </div>

        </section>

        <!-- ----------- Contato -----------  -->

        <!-- <section class="contato" id="contato">

            <h2>Contato</h2>

            <div class="contato-div" id="contato-div">

                <div class="contato-labels">

                    <label for="">
                        <button id="">
                            <i class="bi bi-person"></i>
                            <?php echo $nome_loja ?>
                        </button>
                    </label>

                    <label for="tel">
                        <button id="tel">
                            <i class="bi bi-telephone"></i>
                            <?php echo $tel_loja ?>
                        </button>
                    </label>

                    <label for="">
                        <button id=""></button>
                    </label>

                    <label for="">
                        <button id=""></button>
                    </label>

                </div>

            </div>
        </section> -->

        <!-- <footer>
            &copy;BolvierTeam
        </footer> -->

    </main>

</body>

<script src="../js/compras.js"></script>
<script src="../js/links.js"></script>
<script src="../js/produtos.js"></script>
<script src="../js/pegarProduto.js"></script>

</html>