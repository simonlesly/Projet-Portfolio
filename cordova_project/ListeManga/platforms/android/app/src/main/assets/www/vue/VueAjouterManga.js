class VueAjouterManga{
    constructor(){
        this.html = document.getElementById("html-vue-ajouter-manga").innerHTML;
        this.actionAjouterManga = null;
    }

    initialiserActionAjouterManga(actionAjouterManga) {
        this.actionAjouterManga = actionAjouterManga
    }

    afficher() {
        document.getElementsByTagName("body")[0].innerHTML = this.html; 
        document.getElementById('formulaire-ajouter').addEventListener('submit', evenement => this.enregistrer(evenement));
    }

    enregistrer(evenement) {
        evenement.preventDefault();

        let nom = document.getElementById('manga-nom').value;
        let auteur = document.getElementById('manga-auteur').value;
        let type = document.getElementById('manga-type').value;
        let imageInput = document.getElementById('manga-image').files[0];
        let imageURL = imageInput ? URL.createObjectURL(imageInput) : "";
        let videoURL = document.getElementById('manga-video').value;
        let description = document.getElementById('manga-description').value;

        // Si une image est choisie, la convertir en DataURL
        if (imageInput) {
            let reader = new FileReader();
            reader.onloadend = () => {
                imageURL = reader.result;
                this.actionAjouterManga(new Manga(nom, auteur, type, imageURL, videoURL, description, null));
            };
            reader.readAsDataURL(imageInput);
        } else {
            this.actionAjouterManga(new Manga(nom, auteur, type, imageURL, videoURL, description, null));
        }
    }

}        

