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

document.addEventListener("DOMContentLoaded", function () {
    const filtreCatgegorie = document.querySelectorAll(".filtreCategorie .filtreItems");
    filtreCatgegorie.forEach(element => {
        element.addEventListener("click", function (event) {
            let valeurFiltreCategorie = event.target.dataset.categorie
            console.log(valeurFiltreCategorie)
        })
    });
    const filtreFormat = document.querySelectorAll(".filtreFormat .filtreItems");
    filtreFormat.forEach(element => {
        element.addEventListener("click", function (event) {
            let valeurFiltreFormat = event.target.dataset.format
            console.log(valeurFiltreFormat)
        })
    });
    const filtreTrier = document.querySelectorAll(".filtreTrier .filtreItems");
    filtreTrier.forEach(element => {
        element.addEventListener("click", function (event) {
            let valeurFiltreTrier = event.target.dataset.trier
            console.log(valeurFiltreTrier)
            loadMorePhoto()
        })
    });
});

function loadFiltrePhoto() {
    const container = document.getElementById("posts-container");
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
            }
        }
    };
    xhr.send("action=load_more_photos");

};