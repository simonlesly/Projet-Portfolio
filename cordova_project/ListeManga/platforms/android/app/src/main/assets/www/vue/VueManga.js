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
        document.getElementById("manga-type").innerText = this.manga.type;

        // Afficher l'image
        if (this.manga.imageURL) {
            document.getElementById("manga-image").innerHTML = `<img src="${this.manga.imageURL}" alt="${this.manga.nom}" style="max-width: 100%; height: auto;">`;
        } else {
            document.getElementById("manga-image").innerHTML = "<img src='image-par-defaut.jpg' alt='Image par défaut' style='max-width: 100%; height: auto;'>";
        }

        // Afficher la vidéo si elle existe
        let videoContainer = document.getElementById('manga-video-container');
       if (this.manga.videoURL) {
           videoContainer.innerHTML =
               `<video width="100%" controls>
                   <source src="${this.manga.videoURL}" type="video/mp4">
                   Votre navigateur ne supporte pas la lecture de vidéo.
               </video>`;
       } else {
           videoContainer.innerHTML = "<p>Pas de vidéo disponible.</p>";
       }


        document.getElementById("manga-description").innerText = this.manga.description;

        document.querySelector(".action[href='#modifier-manga']").href = `#modifier-manga/${this.manga.id}`;
    }
}
