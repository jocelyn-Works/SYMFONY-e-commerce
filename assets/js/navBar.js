
// user menu 

(function () {
    const userIcon = document.getElementById('userIcon');
    const userMenu = document.querySelector('.user-menu');
    const VISIBLE = 'visible';
    const HIDDEN = 'hidden';

    // Fonction pour basculer la visibilité
    function toggleVisibility() {
        userMenu.style.visibility = (userMenu.style.visibility === VISIBLE) ? HIDDEN : VISIBLE;
    }

    // Afficher ou masquer userMenu au clic sur userIcon
    userIcon.addEventListener('click', toggleVisibility);

    // Masquer userMenu au clic en dehors
    document.addEventListener('click', (event) => {
        const isClickedInsideUserMenu = userMenu.contains(event.target);
        const isClickedOnUserIcon = event.target === userIcon || userIcon.contains(event.target); // Vérifie si le clic est dans ou sur userIcon

        if (!isClickedInsideUserMenu && !isClickedOnUserIcon) {
            userMenu.style.visibility = HIDDEN;
        }
    });
})();


// shopping  menu 

(function () {
    const shoppingIcon = document.getElementById('shoppingIcon');
    const cart_menu = document.querySelector('.cart_menu');
    const VISIBLE = 'visible';
    const HIDDEN = 'hidden';

    // Fonction pour basculer la visibilité
    function toggleVisibility() {
        cart_menu.style.visibility = (cart_menu.style.visibility === VISIBLE) ? HIDDEN : VISIBLE;
    }

    // Afficher ou masquer userMenu au clic sur userIcon
    shoppingIcon.addEventListener('click', toggleVisibility);

    // Masquer userMenu au clic en dehors
    document.addEventListener('click', (event) => {
        const isClickedInsideUserMenu = cart_menu.contains(event.target);
        const isClickedOnUserIcon = event.target === shoppingIcon || shoppingIcon.contains(event.target); // Vérifie si le clic est dans ou sur userIcon

        if (!isClickedInsideUserMenu && !isClickedOnUserIcon) {
            cart_menu.style.visibility = HIDDEN;
        }
    });
})();




// sous menu 

document.addEventListener('DOMContentLoaded', function() {
    // Attachez un gestionnaire d'événements à tous les éléments avec la classe "tab-links"
    document.querySelectorAll('.tab-links').forEach(function(tabLink) {
        tabLink.addEventListener('click', function(event) {
            var tabName = event.target.dataset.tabname;
            opentab(event, tabName);
            event.stopPropagation(); // Arrête la propagation de l'événement de clic
        });
    });

    // Ajoutez un gestionnaire d'événements de clic au document entier
    document.addEventListener('click', function(event) {
        // Vérifiez si l'élément cliqué n'appartient pas à la div active
        if (!event.target.closest('.tab-contents.active-tab')) {
            // Désactive toutes les classes "active-link" sur les liens de tab
            document.querySelectorAll('.tab-links').forEach(function(tablink) {
                tablink.classList.remove("active-link");
            });

            // Désactive toutes les classes "active-tab" sur les contenus de tab
            document.querySelectorAll('.tab-contents').forEach(function(tabcontent) {
                tabcontent.classList.remove("active-tab");
            });
        }
    });
});

window.opentab = function(event, tabname) {
    console.log('Function opentab called with tabname:', tabname);

    // Désactive toutes les classes "active-link" sur les liens de tab
    document.querySelectorAll('.tab-links').forEach(function(tablink) {
        tablink.classList.remove("active-link");
    });

    // Désactive toutes les classes "active-tab" sur les contenus de tab
    document.querySelectorAll('.tab-contents').forEach(function(tabcontent) {
        tabcontent.classList.remove("active-tab");
    });

    // Active la classe "active-link" sur le lien actuel
    event.currentTarget.classList.add("active-link");

    // Active la classe "active-tab" sur le contenu correspondant
    var selectedTab = document.getElementById(tabname);
    if (selectedTab) {
        selectedTab.classList.add("active-tab");
    }
};



