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