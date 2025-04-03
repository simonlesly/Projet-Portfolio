// Application.js
class Application {
    constructor(window, mangaDAO, vueListeManga, vueAjouterManga, vueManga, vueModifierManga) {
        this.window = window;
        this.mangaDAO = mangaDAO;

        this.vueListeManga = vueListeManga;
        this.vueAjouterManga = vueAjouterManga;
        this.vueModifierManga = vueModifierManga;
        this.vueManga = vueManga;

        // Initialisation des actions
        this.vueAjouterManga.initialiserActionAjouterManga(manga => this.actionAjouterManga(manga));
        this.vueModifierManga.initialiserActionModifierManga(manga => this.actionModifierManga(manga));

        document.addEventListener("deviceready", () => this.initialiserNavigation(), false);

    }
      initialiserNavigation(){
        console.log ("Application-->initialiserNavigation");
        this.window.addEventListener("hashchange", () => this.naviguer());

        setTimeout(() => this.naviguer(),3000);

        }

    naviguer() {
        let hash = window.location.hash;

        if (!hash) {
            this.vueListeManga.initialiserListeManga(this.mangaDAO.lister());
            this.vueListeManga.afficher();
        } else if (hash.match(/^#ajouter-manga/)) {
            this.vueAjouterManga.afficher();
        } else if (hash.match(/^#modifier-manga\/([0-9]+)/)) {
            let navigation = hash.match(/^#modifier-manga\/([0-9]+)/);
            if (navigation && navigation[1]) {
                let idManga = parseInt(navigation[1], 10);
                let manga = this.mangaDAO.lister().find(m => m.id === idManga);

                console.log("Manga récupéré pour modification:", manga); // Debug

                if (manga) {
                    this.vueModifierManga.afficher(manga);
                } else {
                    console.error("ID de manga non valide dans l'URL: " + idManga);
                    this.window.location.hash = "#";
                }
            } else {
                console.error("Format d'URL incorrect pour la modification du manga.");
            }
        } else if (hash.match(/^#manga\/([0-9]+)/)) {
            let navigation = hash.match(/^#manga\/([0-9]+)/);
            if (navigation && navigation[1]) {
                let idManga = parseInt(navigation[1], 10);
                let manga = this.mangaDAO.lister().find(m => m.id === idManga);

                if (manga) {
                    this.vueManga.initialiserManga(manga);
                    this.vueManga.afficher();
                }
            }
        }
    }




    actionAjouterManga(manga) {
        this.mangaDAO.ajouter(manga);
        this.window.location.hash = "#"; 
    }

    actionModifierManga(manga) {
        this.mangaDAO.modifier(manga);
        this.window.location.hash = "#"; 
    }
}

new Application(window, new MangaDAO(), new VueListeManga(), new VueAjouterManga(), new VueManga(), new VueModifierManga());
