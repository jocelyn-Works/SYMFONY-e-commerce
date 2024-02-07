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


var tablinks = document.getElementsByClassName("tab-links");
var tabcontents = document.getElementsByClassName("tab-contents");

function opentab(tabname){
    for(tablink of tablinks){
        tablink.classList.remove("active-link");
    }
    for(tabcontent of tabcontents){
        tabcontent.classList.remove("active-tab");
    }
    event.currentTarget.classList.add("active-link");
    document.getElementById(tabname).classList.add("active-tab");
}





