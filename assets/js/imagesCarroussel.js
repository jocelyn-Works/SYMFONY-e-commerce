
document.addEventListener("DOMContentLoaded", function() {
    var container = document.getElementById("carousel-container");
    var images = Array.from(container.querySelectorAll(".product-image"));

    // Mélanger l'ordre des images
    for (var i = images.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = images[i];
        images[i] = images[j];
        images[j] = temp;
    }

    // Ajouter la classe 'active' à la première image
    images[0].classList.add("active");

    // Définir l'index de l'image active
    var currentIndex = 0;

    // Mettre à jour l'image toutes les 2 secondes
    setInterval(function() {
        // Masquer l'image actuelle
        images[currentIndex].classList.remove("active");

        // Choisir un nouvel index aléatoire
        var newIndex = Math.floor(Math.random() * images.length);

        // Mettre à jour l'index actuel
        currentIndex = newIndex;

        // Afficher la nouvelle image
        images[currentIndex].classList.add("active");
    }, 3000);
});