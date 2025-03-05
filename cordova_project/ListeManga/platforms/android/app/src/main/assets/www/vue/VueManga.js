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
        document.getElementById("manga-description").innerText = this.manga.description;

        
        document.querySelector(".action[href='#modifier-manga']").href = `#modifier-manga/${this.manga.id}`;
    }
}
