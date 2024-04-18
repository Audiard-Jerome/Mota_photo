console.log("JS gestion mouseover chargé")

//détection du survol de la fleche article précédent
let previousLink = document.querySelector(".paginationBtn .previousLink")
let paginationPhotoPrev = document.querySelector(".paginationPhotoPrev")
//vérifie que previousLink n'est pas null
if (previousLink) {
previousLink.addEventListener("mouseover", () => {
//affiche la photo de l'article précédent
paginationPhotoPrev.classList.add("active")
})


// n'affiche plus la photo quand la souris n'est plus sur le bouton
previousLink.addEventListener("mouseout", () => {
paginationPhotoPrev.classList.remove("active")
})
}


//détection du survol de la fleche article suivant
let nextLink = document.querySelector(".paginationBtn .nextLink")
let paginationPhotoNext = document.querySelector(".paginationPhotoNext")
//vérifie que la variable nextLink n'est pas null
if (nextLink) {
nextLink.addEventListener("mouseover", () => {
//affiche la photo de l'article suivant
paginationPhotoNext.classList.add("active")
})


// n'affiche plus la photo quand la souris n'est plus sur le bouton
nextLink.addEventListener("mouseout", () => {
paginationPhotoNext.classList.remove("active")
})
}
