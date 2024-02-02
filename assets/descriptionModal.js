document.addEventListener('DOMContentLoaded', function() {
    var addNewAdress = document.querySelector('.add-new-adress');
    var modal = document.querySelector('.modal-content');

    addNewAdress.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche la propagation de l'événement à l'élément parent
        modal.style.display = 'block';
    });

    // Ferme le modal si l'utilisateur clique en dehors du contenu du modal
    document.addEventListener('click', function(event) {
        if (!modal.contains(event.target) && modal.style.display === 'block') {
            modal.style.display = 'none';
        }
    });
});