
function showMsg() {

    const modal = document.getElementById("chat-div");

    modal.classList.add("abrir")

    modal.addEventListener('click', (e) => {

        if(e.target.id == "closeMsg"){

            modal.remove("abrir")
        }
    })
}