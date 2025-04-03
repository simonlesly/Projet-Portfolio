class VueModifierManga {
    constructor() {
        this.html = document.getElementById("html-vue-modifier-manga").innerHTML;
        this.actionModifierManga = null;
    }

    initialiserActionModifierManga(actionModifierManga) {
        this.actionModifierManga = actionModifierManga;
    }

    afficher(manga) {
        if (!manga) {
            console.error("Aucun manga fourni à afficher.");
            return;
        }

        document.getElementsByTagName("body")[0].innerHTML = this.html;

        setTimeout(() => {
            document.getElementById('manga-nom').value = manga.nom || "";
            document.getElementById('manga-auteur').value = manga.auteur || "";
            document.getElementById('manga-type').value = manga.type || "";

            // Affichage de l'image par défaut ou de l'image du manga
            if (manga.imageURL) {
                document.getElementById("manga-image").innerHTML = `<img src="${manga.imageURL}" alt="${manga.nom}">`;
            } else {
                document.getElementById("manga-image").innerHTML = "<img src='image-par-defaut.jpg' alt='Image par défaut'>";
            }

            document.getElementById('manga-video').value = manga.video || "";
            document.getElementById('manga-description').value = manga.description || "";

            const formulaireModifier = document.getElementById('formulaire-modifier');
            if (formulaireModifier) {
                formulaireModifier.addEventListener('submit', evenement => this.enregistrer(evenement, manga));
            } else {
                console.error("Le formulaire de modification n'a pas été trouvé.");
            }
        }, 0);
    }

    enregistrer(evenement, manga) {
        evenement.preventDefault();

        let nom = document.getElementById('manga-nom').value;
        let auteur = document.getElementById('manga-auteur').value;
        let type = document.getElementById('manga-type').value;
        let imageInput = document.getElementById('manga-image').files[0];
        let imageURL = manga.imageURL;  // Si l'image n'est pas modifiée, on garde l'ancienne image

        if (imageInput) {
            let reader = new FileReader();
            reader.onloadend = function () {
                imageURL = reader.result;
                document.getElementById("manga-image").innerHTML = `<img src="${imageURL}" alt="Image du manga">`;
            };

            reader.readAsDataURL(imageInput);
        }

        let videoURL = document.getElementById('manga-video').value || manga.video;
        let description = document.getElementById('manga-description').value;

        // Créer un nouvel objet Manga avec les informations mises à jour
        this.actionModifierManga(new Manga(nom, auteur, type, imageURL, videoURL, description, manga.id));
    }
}