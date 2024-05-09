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

let titreCategorie = document.querySelector('.filtreCategorie .btnFiltre');
let titreFormat = document.querySelector('.filtreFormat .btnFiltre');
let titreTrier = document.querySelector('.filtreTrier .btnFiltre');

document.addEventListener("DOMContentLoaded", function () {
    const filtreCategorie = document.querySelectorAll(".filtreCategorie .filtreItem");
    filtreCategorie.forEach(element => {
        element.addEventListener("click", function (event) {
            //test pour savoir si on a déja selectionner un filtre
            if (valeurFiltreCategorie != event.target.dataset.categorie) {
            // met la valeur du filtre dans valeur filtre categorie
            valeurFiltreCategorie = event.target.dataset.categorie
            // Enleve le rouge
            filtreCategorie.forEach(item => {
                item.classList.remove("selected")
            });
            // colorie le lien en rouge au click
            event.target.classList.add("selected")
            // entoure en bleu le titre
            titreCategorie.classList.add("selected")
            // change le titre
            titreCategorie.firstChild.nodeValue = event.target.textContent
            } else {
                //enleve le lien en rouge
                filtreCategorie.forEach(item => {
                    item.classList.remove("selected")
                });
                // enleve le bleu autour du titre
                titreCategorie.classList.remove("selected")
                //enleve la valeur de valeurFiltreCategorie
                valeurFiltreCategorie = '';
                //remet le titre d'origine.
                titreCategorie.firstChild.nodeValue = "Catégorie"
            }         
            //charge les photos
            loadFiltrePhoto()
        })
    });
    //idem mais pour filtre format
    const filtreFormat = document.querySelectorAll(".filtreFormat .filtreItem");
    filtreFormat.forEach(element => {
        element.addEventListener("click", function (event) {
            if (valeurFiltreFormat != event.target.dataset.format) {
            valeurFiltreFormat = event.target.dataset.format
            filtreFormat.forEach(item => {
                item.classList.remove("selected")
            });
            event.target.classList.add("selected")
            titreFormat.classList.add("selected")
            // titreFormat = document.querySelector('.filtreFormat .btnFiltre')
            titreFormat.firstChild.nodeValue = event.target.textContent;
        } else {
            filtreFormat.forEach(item => {
                item.classList.remove("selected")
            });
            titreFormat.classList.remove("selected")
            valeurFiltreFormat = '';
            titreFormat.firstChild.nodeValue = "Format"
        }
            loadFiltrePhoto()
        })
    });
    //idem mais pour filtre trier
    const filtreTrier = document.querySelectorAll(".filtreTrier .filtreItem");
    filtreTrier.forEach(element => {
        element.addEventListener("click", function (event) {
            if (valeurFiltreTrier != event.target.dataset.trier) {
            valeurFiltreTrier = event.target.dataset.trier
            filtreTrier.forEach(item => {
                item.classList.remove("selected")
            });
            event.target.classList.add("selected")
            titreTrier.classList.add("selected")
            titreTrier.firstChild.nodeValue = event.target.textContent
        } else {
            filtreTrier.forEach(item => {
                item.classList.remove("selected")
            });
            titreTrier.classList.remove("selected")
            valeurFiltreTrier = '';
            titreTrier.firstChild.nodeValue = "Trier par"
        }
            loadFiltrePhoto()
        })
    });
});

// fonction pour charger les photos en fonction des filtres.


let index = 8; // nombre de photo affiché.

function loadFiltrePhoto() {
    
    const loadMoreButton = document.getElementById("load-more-btn");
    const container = document.getElementById("posts-container");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", MYSCRIPT.ajaxurl, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            index = response.nbrPhoto;
            console.log(index)
            if (response.posts.length > 0) {
                // on vide le container
                container.innerHTML = '';
                //on ajoute les nouvelles photos
                response.posts.forEach(function (post) {
                    container.innerHTML += post;
                });
                if (response.has_more_posts) {
                    loadMoreButton.style.display = 'unset'; // Masquer le bouton s'il n'y a plus de posts à charger
                } else {
                    loadMoreButton.style.display = 'none'; // Affiche le bouton s'il n'y a plus de posts à charger
                }
            }
        }
    };
    xhr.send(
        "action=load_filtre_photos&valeurFiltreCategorie=" + valeurFiltreCategorie +
        "&valeurFiltreFormat=" + valeurFiltreFormat +
        "&valeurFiltreTrier=" + valeurFiltreTrier +
        "&nonce=" + MYSCRIPT.ajaxNonce +
        "&index=" + index
    );

};


//fonction pour gerer les boutons filtres
const btnFiltres = document.querySelectorAll('.btnFiltre');

// Pour chaque élément avec la classe "btnFiltre"
btnFiltres.forEach(function(btnFiltre) {
    // Ajout d'un écouteur d'événements pour le clic
    btnFiltre.addEventListener('click', function() {
        btnFiltre.classList.toggle('active');
        // Sélection de l'élément parent (filtreCategorie)
        let parent = this.parentElement;
        // Toggle la classe "active" sur l'élément avec la classe "chevron"
        parent.querySelector('.chevron').classList.toggle('active');
        // Toggle la classe "active" sur l'élément avec la classe "filtreItems"
        parent.querySelector('.filtreItems').classList.toggle('active');
    });
});


