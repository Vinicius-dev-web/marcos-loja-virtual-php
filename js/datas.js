function atualizarDataHora() {

    const elemento = document.getElementById("dataAtual");

    const data = new Date();

    const dia = String(data.getDate()).padStart(2, "0");
    const mes = String(data.getMonth() + 1).padStart(2, "0");
    const ano = data.getFullYear();

    const hora = String(data.getHours()).padStart(2, "0");
    const min = String(data.getMinutes()).padStart(2, "0");

    // elemento.textContent = `${dia}/${mes}/${ano}`;
    elemento.textContent = `${dia}/${mes}/${ano} |  ${hora}:${min}`;
}

setInterval(atualizarDataHora, 1000);
atualizarDataHora();



