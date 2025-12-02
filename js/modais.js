
function openDestaque(){

    const modal = document.getElementById("edit-destaque-create");

    modal.classList.add("abrir");

    modal.addEventListener("click", (e) =>{

        if(e.target.id == "fechar"){
            modal.classList.remove("abrir")
        }
    })
}