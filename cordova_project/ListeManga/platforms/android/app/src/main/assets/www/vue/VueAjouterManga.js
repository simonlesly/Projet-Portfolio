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
        let imageURL = document.getElementById('manga-image').files[0] ? URL.createObjectURL(document.getElementById('manga-image').files[0]) : "";
        let videoURL = document.getElementById('manga-video').value;
        let description = document.getElementById('manga-description').value;


        this.actionAjouterManga(new Manga(nom, auteur, type, imageURL, videoURL, description, null));

      }
}        

