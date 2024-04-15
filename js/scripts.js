console.log("JS fenetre modale contact chargé")
let modal = null

const openModal = function (e) {
    e.preventDefault()
    modal = document.querySelector(e.target.getAttribute('href'));
    modal.style.display = null
    modal.removeAttribute('aria-hidden')
    modal.addEventListener('click', closeModal)
    modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation)
    //recupere la reference de la photo.
    let photoRef = document.querySelector('.photoRef')
    //si photoRef n'existe pas on arrete. 
    if (photoRef === null) return
    //Sinon on copie le texte de photoRef dans la modale
    let modalRef = document.querySelector('.modalRef')
    modalRef.value = photoRef.textContent
}

const closeModal = function (e) {
    if (modal === null) return
    e.preventDefault()
    modal.setAttribute('aria-hidden', 'true')
    modal.removeEventListener('click', closeModal)
    modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation)
    const hideModal = function () {
        modal.style.display = "none"
        modal.removeEventListener('animationend', hideModal)
        modal = null
    }
    modal.addEventListener('animationend', hideModal);
    //on efface la variable photo ref si on ferme la modale
    photoRef = null    
}

const stopPropagation = function (e) {
    e.stopPropagation()
}

document.querySelectorAll('.js-modal').forEach(a => {
    a.addEventListener('click', openModal)
})

window.addEventListener('keydown', function(e) {
    if (e.key === "Escape" || e.key === "Esc") {
        closeModal(e)
    }
})