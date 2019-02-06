//Quand l'internaute descend la page de 20 px, montrer le bouton
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("boutonTop").style.display = "block";
    } else {
        document.getElementById("boutonTop").style.display = "none";
    }
}

// Quand l'internaute clique sur le bouton, faire remonter la page.
function topFunction() {
    document.body.scrollTop = 0; // Testé sur Safari.
    document.documentElement.scrollTop = 0; // Pour les autres navigateurs.
}