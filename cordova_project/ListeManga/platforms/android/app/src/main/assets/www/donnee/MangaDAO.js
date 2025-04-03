// Déclaration de la classe MangaDAO
class MangaDAO {
    constructor() {
        this.listeManga = [];
    }

     initialiserListeManga(liste) {
            this.listeManga = liste;
        }




    lister() {
        if (localStorage['manga']) {
            this.listeManga = JSON.parse(localStorage['manga']);
        }
        for (let i = 0; i < this.listeManga.length; i++) {
            this.listeManga[i] = new Manga(
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
            manga.id = this.listeManga[this.listeManga.length - 1].id + 1;
        else
            manga.id = 0;

        // Gérer l'URL de l'image
        if (manga.imageURL && typeof manga.imageURL !== 'string') {
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

    // Méthode filtrerMangas
    filtrerMangas(termeRecherche) {
            if (!this.listeManga) return;

            const terme = termeRecherche.toLowerCase();
            const mangasFiltres = this.listeManga.filter(manga =>
                manga.nom.toLowerCase().includes(terme) ||
                manga.auteur.toLowerCase().includes(terme) ||
                manga.type.toLowerCase().includes(terme)
            );

            afficherMangas(mangasFiltres);
        }
    }

// Fonction pour afficher les mangas
function afficherMangas(mangasFiltres) {
    const listeMangas = document.getElementById('liste-mangas');

    if (!listeMangas) {
        console.error("❌ ERREUR : Élément 'liste-mangas' introuvable !");
        return;
    }

    listeMangas.innerHTML = ''; // Vider la liste avant de la mettre à jour

    if (mangasFiltres.length === 0) {
        listeMangas.innerHTML = '<li>Aucun manga trouvé.</li>';
    } else {
        mangasFiltres.forEach(manga => {
            const li = document.createElement('li');
            li.textContent = `${manga.nom} - ${manga.auteur} - ${manga.type}`;

            // 🔥 Ajouter un événement click à chaque manga
            li.addEventListener("click", function() {
                window.location.hash = `#details-manga-${manga.id}`;
            });

            listeMangas.appendChild(li);
        });
    }
}



// Ajouter l'écouteur d'événement sur la barre de recherche
document.addEventListener('DOMContentLoaded', function () {
    let timeout;
    const rechercheElement = document.getElementById('barre-de-recherche');
    if (rechercheElement) {
        rechercheElement.addEventListener('input', function () {
            clearTimeout(timeout); // Annuler le précédent délai
            timeout = setTimeout(() => {
                const mangaDAO = new MangaDAO(); // Créer une instance de MangaDAO
                mangaDAO.filtrerMangas(this.value); // Appeler la fonction filtrerMangas
            }, 300); // Attendre 300 ms avant de filtrer pour optimiser
        });
    }
});
