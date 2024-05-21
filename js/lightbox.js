//lightbox

let lightbox = null
let currentPhotoIndex = 0; // Index de l'image actuellement affichée dans la lightbox
let photos = []; // Liste de toutes les photos à afficher dans la lightbox

//fonction pour l'ouverture de la lightbox
function openLightbox (e) {
    e.preventDefault(); 
    // Récupère les infos du photo block
    let photo_block = e.target.closest('.photo_block');
    let photoUrl = photo_block.querySelector('.info').dataset.photourl;
    // Récupère les boutons next et previous
    let lightbox = document.querySelector(e.target.getAttribute('href'));
    let nextButton = lightbox.querySelector('.next');
    let prevButton = lightbox.querySelector('.previous');
    
    // Affiche la lightbox 
    lightbox.style.display = null;

    // Récupère toutes les infos de tout les photos block pour tout mettre dans un tableau.
    photos = Array.from(document.querySelectorAll('.photo_block')).map(block => ({
        ref: block.querySelector('.refPhoto').textContent,
        cat: block.querySelector('.catPhoto').textContent,
        url: block.querySelector('.info').dataset.photourl
    }));

    // On recupere l'index de la photo en cours.
    currentPhotoIndex = photos.findIndex(img => img.url === photoUrl);
    //On affiche la photo et les infos.
    displayImageInLightbox(lightbox, photos[currentPhotoIndex]);

    // Gestion de la fermeture de la lightbox avec un test. 
    if (!lightbox.dataset.listenerAdded) {
        lightbox.querySelector('.closeLightbox').addEventListener('click', closeLightbox);
        lightbox.dataset.listenerAdded = true;
    }

    // gestionnaire d'evenement pour les boutons next et previous.
    nextButton.addEventListener('click', function() {
        currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
        displayImageInLightbox(lightbox, photos[currentPhotoIndex]);
    });

    prevButton.addEventListener('click', function() {
        currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
        displayImageInLightbox(lightbox, photos[currentPhotoIndex]);
    });
}

// fonction pour afficher l'image et l'info de la lightbox.
function displayImageInLightbox(lightbox, image) {
    lightbox.querySelector('.refPhotoLightbox').textContent = image.ref;
    lightbox.querySelector('.catPhotoLightbox').textContent = image.cat;
    lightbox.querySelector('.photoLightbox').innerHTML = image.url;
}

//fonction pour gerer la fermeture de la lightbox
function closeLightbox(e) {
    const clickedLightbox = e.target.closest('.lightbox');
    if (clickedLightbox === null) return;

    clickedLightbox.setAttribute('aria-hidden', 'true');
    clickedLightbox.removeEventListener('click', closeModal);
    clickedLightbox.style.display = "none";
}


//fonction pour ajouter l'ecouteur d'evenement sur les boutons "ouverture lightbox"
function lightboxAdd() {
    document.querySelectorAll('.js-lightbox').forEach(a => {
    a.addEventListener('click', openLightbox)
})}
lightboxAdd()

//fonction pour fermer la lightbox avec la touche ESC.
window.addEventListener('keydown', function(e) {
    if (e.key === "Escape" || e.key === "Esc") {
        closeLightbox(e)
    }
})