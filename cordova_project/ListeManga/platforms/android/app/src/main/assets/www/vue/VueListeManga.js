// vue/VueListeManga.js
class VueListeManga {
    constructor() {
        this.html = document.getElementById("html-vue-liste-manga").innerHTML;
        this.listeMangaDonnee = null;
    }

    initialiserListeManga(listeMangaDonnee) {
        this.listeMangaDonnee = listeMangaDonnee;
    }

    afficher() {
        document.body.innerHTML = this.html;
        document.getElementById('barre-de-recherche').addEventListener('input', (event) => {
            let mangaDAO = new MangaDAO(); // Crée une instance de MangaDAO
            mangaDAO.initialiserListeManga(this.listeMangaDonnee); // Initialise avec les mangas actuels
            mangaDAO.filtrerMangas(event.target.value); // Filtre les mangas avec la valeur de l'input
        });


        let listeManga = document.getElementById("liste-manga");
        const listeMangaItemHTML = listeManga.innerHTML;
        let listeMangaHTMLRemplacement = "";

        for (var numeroManga in this.listeMangaDonnee) {
            let listeMangaItemHTMLRemplacement = listeMangaItemHTML;
            listeMangaItemHTMLRemplacement = listeMangaItemHTMLRemplacement.replace("{Manga.id}", this.listeMangaDonnee[numeroManga].id);
            listeMangaItemHTMLRemplacement = listeMangaItemHTMLRemplacement.replace("{Manga.nom}", this.listeMangaDonnee[numeroManga].nom);

            // Ajouter l'image
            let imageHTML = this.listeMangaDonnee[numeroManga].imageURL ? `<img src="${this.listeMangaDonnee[numeroManga].imageURL}" alt="${this.listeMangaDonnee[numeroManga].nom}">` : "<img src='image-par-defaut.jpg' alt='Image par défaut'>";
            listeMangaItemHTMLRemplacement = listeMangaItemHTMLRemplacement.replace("{Manga.image}", imageHTML);

            listeMangaHTMLRemplacement += listeMangaItemHTMLRemplacement;
        }

        listeManga.innerHTML = listeMangaHTMLRemplacement;
    }


}