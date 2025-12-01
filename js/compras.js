// ADICIONAR AO CARRINHO
document.querySelectorAll(".btn-comprar").forEach(btn => {
    btn.addEventListener("click", function () {

        const nome = this.dataset.produto;
        const preco = this.dataset.preco;
        const imagem = this.dataset.imagem;
        const tamanho = this.dataset.tamanho; // <<< PEGANDO O TAMANHO

        // PEGAR SLUG DIRETO DO PHP
        const slug = document.body.dataset.slug;

        fetch("../php/add_carrinho.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body:
                `nome=${encodeURIComponent(nome)}` +
                `&preco=${encodeURIComponent(preco)}` +
                `&imagem=${encodeURIComponent(imagem)}` +
                `&tamanho=${encodeURIComponent(tamanho)}` +   // <<< ENVIANDO O TAMANHO
                `&slug=${encodeURIComponent(slug)}`
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById("contadorCarrinho").innerText = data.total_itens;
        });
    });
});
