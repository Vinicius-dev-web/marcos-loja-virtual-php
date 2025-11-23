
function editTable(){

    const modal = document.getElementById("edit-produto-table")
    
    modal.classList.add('abrir')
    
    modal.addEventListener('click', (e) => {
    
        if(e.target.id == "cancel"){

            modal.classList.remove('abrir')

        }
    })

}