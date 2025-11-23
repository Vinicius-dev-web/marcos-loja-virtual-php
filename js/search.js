async function carregarProdutos() {
    const container = document.getElementById("cards-prods");
    container.innerHTML = "<p>Carregando produtos...</p>";

    try {
        const resposta = await fetch("listar_produtos.php");
        const produtos = await resposta.json();

        container.innerHTML = "";

        produtos.forEach(produto => {
            const card = document.createElement("div");
            card.classList.add("card");

            card.innerHTML = `
                <img src="${produto.imagem}" alt="${produto.nome}">
                <h3>${produto.nome}</h3>
                <span>R$ ${produto.preco}</span>
                <button class="btn-comprar" data-produto="${produto.nome}">
                    Adicionar ao Carrinho
                </button>
            `;

            container.appendChild(card);
        });

    } catch (erro) {
        container.innerHTML = "<p>Erro ao carregar produtos.</p>";
    }
}

carregarProdutos();
