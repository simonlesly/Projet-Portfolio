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
            document.getElementById('manga-description').value = manga.description || "";
    
            // Ajouter l'événement de soumission au formulaire
            const formulaireModifier = document.getElementById('formulaire-modifier');
            if (formulaireModifier) {
                formulaireModifier.addEventListener('submit', evenement => this.enregistrer(evenement, manga.id));
            } else {
                console.error("Le formulaire de modification n'a pas été trouvé.");
            }
        }, 0);
    }
    
    enregistrer(evenement, mangaId) {
        evenement.preventDefault();

        // Récupérer les valeurs mises à jour des champs du formulaire
        let nom = document.getElementById('manga-nom').value;
        let auteur = document.getElementById('manga-auteur').value;
        let type = document.getElementById('manga-type').value;
        let description = document.getElementById('manga-description').value;

        // Appeler la fonction de modification avec une instance de Manga mise à jour
        this.actionModifierManga(new Manga(nom, auteur, type, description, mangaId));
    }
}
