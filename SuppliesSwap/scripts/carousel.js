const carouselSlide = document.querySelector('.carousel-slide');
const carouselImages = document.querySelectorAll('.carousel-slide img');

// Boutons
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

// Initialisation du compteur et de la largeur d'image
let counter = 0;

// Fonction pour calculer la taille de l'image en fonction de la taille actuelle du conteneur
function updateCarouselSize() {
    const size = carouselImages[0].clientWidth;
    carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
}

// Redimensionner le carrousel automatiquement lors du redimensionnement de la fenêtre
window.addEventListener('resize', updateCarouselSize);

// Bouton suivant
nextBtn.addEventListener('click', () => {
    if (counter >= carouselImages.length - 1) return; // Empêche de dépasser la dernière image
    counter++;
    updateCarouselSize();
});

// Bouton précédent
prevBtn.addEventListener('click', () => {
    if (counter <= 0) return; // Empêche de revenir avant la première image
    counter--;
    updateCarouselSize();
});

// Initialiser le carrousel à la bonne taille au chargement de la page
window.onload = updateCarouselSize;
