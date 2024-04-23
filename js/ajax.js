// test ajax
console.log('Ajax JS chargé')

document.addEventListener("DOMContentLoaded", function() {
    var loadMoreButton = document.getElementById("load-more-btn");
    var container = document.getElementById("posts-container");
    var index = 1; // index en cours.
    console.log(index);
    
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
                    index++; // ajoute 1 a l'index
                    console.log(index);
                }
            }
        };
        xhr.send("action=load_more_photos&page=" + index);
    });
});