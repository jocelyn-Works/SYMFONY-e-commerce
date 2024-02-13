document.addEventListener("DOMContentLoaded", function() {
    var productShow = document.getElementById("product-show");
    var additionalImages = productShow.querySelectorAll(".additional-image");
    var firstImage = productShow.querySelector(".first-image img");
  
    additionalImages.forEach(function(image) {
      image.addEventListener("mouseover", function() {
        var src = image.querySelector("img").getAttribute("src");
        firstImage.setAttribute("src", src);
        firstImage.classList.add("hovered"); // Ajouter une classe au survol
      });
  
      image.addEventListener("mouseout", function() {
        firstImage.classList.remove("hovered"); // Retirer la classe en quittant le survol
      });
    });
  });