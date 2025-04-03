class MangaDAO
{
    constructor(){
        /*
        this.listeManga = [
            {nom : "Naruto "  , auteur : "Masashi Kishimoto", type :  "Shonen"  , description :  "Naruto est orphelin et a servi de réceptacle, étant bébé, pour sceller en lui le démon Juubi qui menaçait son village. Avec le temps les habitants ne voient plus en lui que le démon et lemettent à l'écart. Toujours seul, son caractère fougueux ne l'aide pas vraiment à se faire apprécier dans son village"   , id:0},
            {nom : "Noragami " , auteur : " Adachitoka" , type :  "Shonen"  , description :  "Hiyori Iki passe une scolarité difficile, subissant les brimades de ses camarades. Tandis qu'elle se réfugie dans les toilettes pour pleurer, elle lit sur le mure un message, “je résous vos problèmes” et un numéro de téléphone. En l'appelant, elle fait la connaissance d'un sans-abri qui prétend être un dieu…"   , id:1},
            {nom : "Attaque des titants " , auteur : "Hajime Isayama."  , type :"Shonen"    , description : "Dans un monde ravagé par des titans mangeurs d'homme depuis plus d'un siècle, les rares survivants de l'Humanité n'ont d'autre choix pour survivre que de se barricader dans une cité-forteresse."    , id:2}]
        */

        this.listeManga = [];
    }

    lister(){
        if( localStorage['manga']){
            this.listeManga = JSON.parse(localStorage['manga']);
        }
            for (let i = 0; i < this.listeManga.length; i++) {
                this.listeManga[i] = new Manga (
                    this.listeManga[i].nom,
                    this.listeManga[i].auteur,
                    this.listeManga[i].type,
                    this.listeManga[i].imageURL,
                    this.listeManga[i].videoURL,
                    this.listeManga[i].description,
                    this.listeManga[i].id
                );
            }
      return this.listeManga;
    }   

   ajouter(manga) {
       if (this.listeManga.length > 0)
           manga.id = this.listeManga[this.listeManga.length-1].id + 1;
       else
           manga.id = 0;

       // Gérer l'URL de l'image
       if (manga.imageURL && typeof manga.imageURL !== 'string') {
           // Si l'image est un objet Blob ou un autre type
           let fileReader = new FileReader();
           fileReader.onloadend = function () {
               manga.imageURL = fileReader.result;  // Convertir en DataURL
               this.listeManga[manga.id] = manga;
               localStorage['manga'] = JSON.stringify(this.listeManga);
           };
           fileReader.readAsDataURL(manga.imageURL); // Lire comme DataURL
       } else {
           this.listeManga[manga.id] = manga;
           localStorage['manga'] = JSON.stringify(this.listeManga);
       }

       console.log("JSON.stringify(this.listeManga) : " + JSON.stringify(this.listeManga));
   }



modifier(mangaModifie) {
    const index = this.listeManga.findIndex(manga => manga.id === mangaModifie.id);

    if (index !== -1) {
        console.log("Avant modification :", this.listeManga[index]);

        this.listeManga[index] = mangaModifie;

        console.log("Après modification :", this.listeManga[index]);

        localStorage['manga'] = JSON.stringify(this.listeManga);

        // Rediriger vers la liste des mangas
        window.location.hash = "#liste-manga";
    }
}


}
 
