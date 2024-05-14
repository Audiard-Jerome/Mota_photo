console.log("fichier lightbox.JS chargé")

let lightbox = null
let currentImageIndex = 0; // Index de l'image actuellement affichée dans la lightbox
let images = []; // Liste de toutes les images à afficher dans la lightbox


const openLightbox = function (e) {
    e.preventDefault()
    // Récupérer le photo block que j'ai cliqué
    const photo_block = e.target.closest('.photo_block');
    
    // Récupérer la valeur des champs de photoblock
    let refPhoto = photo_block.querySelector('.refPhoto');
    let catPhoto = photo_block.querySelector('.catPhoto');
    let photoUrl = photo_block.querySelector('.info').dataset.photourl;


    lightbox = document.querySelector(e.target.getAttribute('href'));
    // on affiche la ligntbox
    lightbox.style.display = null;
    // On récupere les champs de la lightbox
    let photoLightbox = lightbox.querySelector('.photoLightbox');
    let refPhotoLightbox = lightbox.querySelector('.refPhotoLightbox');
    let catPhotoLightbox = lightbox.querySelector('.catPhotoLightbox');


    // on affiche les valeurs de la carte cliqué.
    refPhotoLightbox.textContent = refPhoto.textContent
    catPhotoLightbox.textContent = catPhoto.textContent

    //on affiche la photo
    photoLightbox.innerHTML = photoUrl

    // event listener pour fermer la lightbox
    lightbox.querySelector('.closeLightbox').addEventListener('click', closeLightbox)
    images = Array.from(document.querySelectorAll('.photo_block')).map(block => ({
        ref: block.querySelector('.refPhoto').textContent,
        cat: block.querySelector('.catPhoto').textContent,
        url: block.querySelector('.info').dataset.photourl
    }));

    console.log(images)

    
}

const closeLightbox = function (e) {

    if (lightbox === null) return
    e.preventDefault()
    lightbox.setAttribute('aria-hidden', 'true')
    lightbox.removeEventListener('click', closeModal)
    // lightbox.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation)
    lightbox.style.display = "none"
    // lightbox.removeEventListener('animationend', hideLightbox)
    lightbox = null
    // modal.addEventListener('animationend', hideLightbox);
    //on efface la variable photo ref si on ferme la modale
    // photoRef = null    
}

function lightboxAdd() {
    document.querySelectorAll('.js-lightbox').forEach(a => {
    a.addEventListener('click', openLightbox)
})}
lightboxAdd()


window.addEventListener('keydown', function(e) {
    if (e.key === "Escape" || e.key === "Esc") {
        closeLightbox(e)
    }
})


