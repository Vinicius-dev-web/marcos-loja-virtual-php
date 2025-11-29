<?php
header("Content-type: text/css"); // isso é essencial para o navegador interpretar como CSS
require "../php/conexao.php";

$slug = $_GET['slug'] ?? '';
$stmt = $conn->prepare("SELECT * FROM lojas WHERE slug=?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$loja = $stmt->get_result()->fetch_assoc();

$cor_tema = $loja['cor_tema'] ?? '#4e75ff';
?>

:root {
--cor_tema: <?php echo $cor_tema; ?>;
--cor-primaria: #1D2123;
--cor-secundaria: #1A1E1F;
--cor-loja3: #4618ac;
/* resto das variáveis */
}