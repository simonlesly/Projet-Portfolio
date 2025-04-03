// vue/VueManga.js
class VueManga {
    constructor() {
        this.html = document.getElementById("html-vue-manga").innerHTML;
        this.manga = null;
    }

    initialiserManga(manga) {
        this.manga = manga;
    }

    afficher() {
        document.body.innerHTML = this.html;
        document.getElementById("manga-nom").innerText = this.manga.nom;
        document.getElementById("manga-auteur").innerText = this.manga.auteur;
        document.getElementById("manga-type").innerText =  this.manga.type;

        // Afficher l'image
        if (this.manga.imageURL) {
            document.getElementById("manga-image").innerHTML = `<img src="${this.manga.imageURL}" alt="${this.manga.nom}">`;
        } else {
            document.getElementById("manga-image").innerHTML = "<img src='image-par-defaut.jpg' alt='Image par défaut'>";
        }

        // Afficher la vidéo
        if (this.manga.videoURL) {
            document.getElementById("manga-video").innerHTML = `<video controls><source src="${this.manga.videoURL}" type="video/mp4"></video>`;
        }
        document.getElementById("manga-description").innerText = this.manga.description;

        document.querySelector(".action[href='#modifier-manga']").href = `#modifier-manga/${this.manga.id}`;
    }

}