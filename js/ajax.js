// test ajax
console.log('Ajax JS chargé')


function loadMorePhoto() {
    const loadMoreButton = document.getElementById("load-more-btn");
    const container = document.getElementById("posts-container");
    let index = 1; // index en cours.

    loadMoreButton.addEventListener("click", function () {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", MYSCRIPT.ajaxurl, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.posts.length > 0) {
                    response.posts.forEach(function (post) {
                        container.innerHTML += post;
                    });
                    index++; // ajoute 1 a l'index
                    if (!response.has_more_posts) {
                        loadMoreButton.style.display = 'none'; // Masquer le bouton s'il n'y a plus de posts à charger
                    }
                }
            }
        };
        xhr.send("action=load_more_photos&index=" + index + "&nonce=" + MYSCRIPT.ajaxNonce);
    });
}

document.addEventListener("DOMContentLoaded", loadMorePhoto);

// filtres.

// récupere la variable selectionné.

let valeurFiltreCategorie = '';
let valeurFiltreFormat = '';
let valeurFiltreTrier = 'DESC';

document.addEventListener("DOMContentLoaded", function () {
    const filtreCatgegorie = document.querySelectorAll(".filtreCategorie .filtreItems");
    filtreCatgegorie.forEach(element => {
        element.addEventListener("click", function (event) {
            // met la valeur du filtre dans valeur filtre categorie
            valeurFiltreCategorie = event.target.dataset.categorie
            // Enleve le rouge
            filtreCatgegorie.forEach(item => {
                item.style.removeProperty('background')
                item.style.removeProperty('color')
            });
            // colorie le lien en rouge au click
            event.target.style.background = "#E00000";
            event.target.style.color = "#FFFFFF";
            console.log(valeurFiltreCategorie)
            //charge les photos
            loadFiltrePhoto()
        })
    });
    const filtreFormat = document.querySelectorAll(".filtreFormat .filtreItems");
    filtreFormat.forEach(element => {
        element.addEventListener("click", function (event) {
            valeurFiltreFormat = event.target.dataset.format
            filtreFormat.forEach(item => {
                item.style.removeProperty('background')
                item.style.removeProperty('color')
            });
            // colorie le lien en rouge au click
            event.target.style.background = "#E00000";
            event.target.style.color = "#FFFFFF";
            console.log(valeurFiltreFormat)
            loadFiltrePhoto()


        })
    });
    const filtreTrier = document.querySelectorAll(".filtreTrier .filtreItems");
    filtreTrier.forEach(element => {
        element.addEventListener("click", function (event) {
            valeurFiltreTrier = event.target.dataset.trier
            filtreTrier.forEach(item => {
                item.style.removeProperty('background')
                item.style.removeProperty('color')
            });
            event.target.style.background = "#E00000";
            event.target.style.color = "#FFFFFF";
            console.log(valeurFiltreTrier)
            loadFiltrePhoto()

        })
    });
});

// fonction pour charger les photos en fonction des filtres.


function loadFiltrePhoto() {
    const container = document.getElementById("posts-container");
    let index = 1; // index en cours.
    const xhr = new XMLHttpRequest();
    xhr.open("POST", MYSCRIPT.ajaxurl, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.posts.length > 0) {
                // on vide le container
                container.innerHTML = '';
                //on ajoute les nouvelles photos
                response.posts.forEach(function (post) {
                    container.innerHTML += post;
                });
                index++; // ajoute 1 a l'index

            }
        }
    };
    xhr.send(
        "action=load_filtre_photos&index=" + index +
        "&valeurFiltreCategorie=" + valeurFiltreCategorie +
        "&valeurFiltreFormat=" + valeurFiltreFormat +
        "&valeurFiltreTrier=" + valeurFiltreTrier +
        "&nonce=" + MYSCRIPT.ajaxNonce);
};
