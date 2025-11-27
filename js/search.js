
const searchInput = document.getElementById('search');
const listaProdutos = document.getElementById('lista-produtos');

// Cria o card de erro
let cardErro = document.createElement('div');
cardErro.className = "card card-error";
cardErro.innerHTML = `
    <img src="https://png.pngtree.com/png-clipart/20190120/ourmid/pngtree-go-to-bed-sleeping-pig-piggy-pig-sleeping-png-image_493040.png" alt="error404">
`;
cardErro.style.display = "none"; // começa escondido
listaProdutos.appendChild(cardErro);

searchInput.addEventListener('input', function() {
    const termo = this.value.toLowerCase().trim();
    const cards = listaProdutos.querySelectorAll('.card:not(.card-error)'); // ignora o card de erro
    let count = 0;

    cards.forEach(card => {
        const nomeH3 = card.querySelector('h3');
        if (!nomeH3) return;

        const nomeProduto = nomeH3.textContent.toLowerCase();
        if (nomeProduto.includes(termo)) {
            card.style.display = "flex";
            count++;
        } else {
            card.style.display = "none";
        }
    });

    // mostra o card de erro se nenhum outro estiver visível
    cardErro.style.display = count === 0 ? "flex" : "none";
});
