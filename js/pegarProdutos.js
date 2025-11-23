async function carregarProdutos() {
    try {
        const resposta = await fetch("../php/getProdutos.php"); 
        const produtos = await resposta.json();

        const container = document.getElementById("lista-produtos");
        container.innerHTML = ""; 

        produtos.forEach(produto => {
            const card = document.createElement("div");
            card.classList.add("card-produto");

            card.innerHTML = `
                <img src="../php/${produto.imagem}" alt="${produto.nome}" class="img-produto">
                <h3>${produto.nome}</h3>
                <p class="preco">R$ ${Number(produto.preco).toFixed(2)}</p>
                <button class="btn-comprar">Comprar</button>
            `;

            container.appendChild(card);
        });

    } catch (erro) {
        console.error("Erro ao carregar produtos:", erro);
    }
}

carregarProdutos();
