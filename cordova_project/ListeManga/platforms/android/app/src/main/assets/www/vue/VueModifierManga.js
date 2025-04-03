class VueModifierManga {
    constructor() {
        this.html = document.getElementById("html-vue-modifier-manga").innerHTML;
        this.actionModifierManga = null;
    }

    initialiserActionModifierManga(actionModifierManga) {
        this.actionModifierManga = actionModifierManga;
    }

    afficher(manga) {
        // Vérification si l'objet manga est défini
        if (!manga) {
            console.error("Aucun manga fourni à afficher.");
            return; // Ne pas continuer si manga est indéfini
        }
    
        // Changer le contenu du corps
        document.getElementsByTagName("body")[0].innerHTML = this.html;
    
        // Utiliser setTimeout pour s'assurer que le DOM est mis à jour avant d'accéder aux éléments
        setTimeout(() => {
            // Préremplir les champs du formulaire avec les informations du manga existant
            document.getElementById('manga-nom').value = manga.nom || "";
            document.getElementById('manga-auteur').value = manga.auteur || "";
            document.getElementById('manga-type').value = manga.type || "";
            if (this.manga.imageURL) {
                document.getElementById("manga-image").innerHTML = `<img src="${this.manga.imageURL}" alt="${this.manga.nom}">`;
            } else {
                document.getElementById("manga-image").innerHTML = "<img src='image-par-defaut.jpg' alt='Image par défaut'>";
            }
            document.getElementById('manga-video').value = manga.video || "";
            document.getElementById('manga-description').value = manga.description || "";
    
            // Ajouter l'événement de soumission au formulaire
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
    let imageURL = imageInput ? URL.createObjectURL(imageInput) : manga.imageURL; // Utiliser l'ancienne image si aucune nouvelle image n'est téléchargée
    let videoURL = document.getElementById('manga-video').value || manga.videoURL;
    let description = document.getElementById('manga-description').value;

    // Créer un nouvel objet Manga avec les informations mises à jour
    this.actionModifierManga(new Manga(nom, auteur, type, imageURL, videoURL, description, manga.id));
}



}
