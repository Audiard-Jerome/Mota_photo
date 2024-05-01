// test ajax
console.log('Ajax JS chargé')


function loadMorePhoto () {
    const loadMoreButton = document.getElementById("load-more-btn");
    const container = document.getElementById("posts-container");
    let index = 1; // index en cours.

    loadMoreButton.addEventListener("click", function() {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", MYSCRIPT.ajaxurl, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.posts.length > 0) {
                    response.posts.forEach(function(post) {
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





// document.addEventListener("DOMContentLoaded", function() {
//     var filtreCatgegorie = document.querySelectorAll(".filtreCategorie .filtreItems");
//     filtreCatgegorie.forEach(element => {
//         element.addEventListener("click", function(event) {
//             var valeurFiltreCategorie = event.target.dataset.categorie
//             console.log(valeurFiltreCategorie)
//         })
//     });
//     var filtreFormat = document.querySelectorAll(".filtreFormat .filtreItems");
//     filtreFormat.forEach(element => {
//         element.addEventListener("click", function(event) {
//             var valeurFiltreFormat = event.target.dataset.format
//             console.log(valeurFiltreFormat)
//         })
//     });
//     var filtreTrier = document.querySelectorAll(".filtreTrier .filtreItems");
//     filtreTrier.forEach(element => {
//         element.addEventListener("click", function(event) {
//             var valeurFiltreTrier = event.target.dataset.trier
//             console.log(valeurFiltreTrier)
//         })
//     });

//     var container = document.getElementById("posts-container");
//     var index = 1; // index en cours.
//     console.log(index);
    
//     loadMoreButton.addEventListener("click", function() {
//         var xhr = new XMLHttpRequest();
//         xhr.open("POST", MYSCRIPT.ajaxurl, true);
//         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         xhr.onload = function() {
//             if (this.status == 200) {
//                 var newPosts = JSON.parse(this.responseText);
//                 if (newPosts.length > 0) {
//                     newPosts.forEach(function(post) {
//                         container.innerHTML += post;
//                     });
//                     index++; // ajoute 1 a l'index
//                     console.log(index);
//                 }
//             }
//         };
//         xhr.send("action=load_more_photos&index=" + index);
//     });
// });