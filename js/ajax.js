// test ajax
console.log('Ajax JS chargé')

document.addEventListener("DOMContentLoaded", function() {
    var loadMoreButton = document.getElementById("load-more-btn");
    var container = document.getElementById("posts-container");
    var page = 2; // Commencez à charger à partir de la deuxième page
    
    loadMoreButton.addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", MYSCRIPT.ajaxurl, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status == 200) {
                var newPosts = JSON.parse(this.responseText);
                if (newPosts.length > 0) {
                    newPosts.forEach(function(post) {
                        container.innerHTML += post;
                    });
                    page++; // Incrémentez la page pour charger la suivante lors du prochain clic
                } else {
                    loadMoreButton.style.display = "none"; // Masquez le bouton s'il n'y a plus de photos à charger
                }
            }
        };
        xhr.send("action=load_more_photos&page=" + page);
    });
});