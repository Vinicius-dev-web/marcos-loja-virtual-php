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
    <link rel="stylesheet" href="tema.php?slug=<?php echo urlencode($slug); ?>">
    <link rel="stylesheet" href="carrinho.css">


    <title>
        <?php echo htmlspecialchars($nome_loja) ?> - Carrinho
    </title>

</head>

<body>

    <nav>

        <div class="logo">
            <?php echo htmlspecialchars($nome_loja) ?>
        </div>

        <div class="icons">
            <i class="bi bi-shield-check"></i>
            <span>Carrinho</span>
        </div>
    </nav>

    <div class="carrinho" id="carrinho">

        <div class="card-prod">

            <div class="lista-carrinho" id="lista-carrinho">

                <!-- <div class="card">

                    <img src="get on the floor.jpg" alt="">

                    <div class="info-prod">
                        <h3>Produto</h3>

                        <p>R$50,00</p>
                    </div>

                </div> -->

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

            <div class="info-prod">

                <h3>' . htmlspecialchars($p['nome']) . '</h3>

                <p class="preco"><b>R$ ' . number_format($p['preco'], 2, ',', '.') . '</b></p>

            </div>
            
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
        </div>

        <div class="card-price">

            <h2>Sumário</h2>

            <div class="price">

                <div class="price-ofc">

                    <span>Preço oficial</span>
                    <span>R$0,00</span>

                </div>

                <div class="price-off">

                    <span>desconto</span>
                    <span>R$0,00</span>

                </div>

            </div>

            <button class="btn-finalizar" id="btnFinalizar">Finalizar Pedido</button>
        </div>
    </div>

</body>

<script src="../js/compras.js"></script>

</html>