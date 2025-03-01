<?php
$titre = "";

require 'header.php';

require "./acceseur/ProduitsDAO.php";



$listeProduits = ProduitsDAO::listerProduits();

if (isset($_GET['max'])) {
    $maxPrix = (float)$_GET['max'];

    $MESSAGE_SQL_FILTRER_PRODUITS = "SELECT * FROM `produits` WHERE prix <= :max";
    $requeteFiltrerProduits = BaseDeDonnees::obtenirConnexion()->prepare($MESSAGE_SQL_FILTRER_PRODUITS);
    $requeteFiltrerProduits->bindValue(':max', $maxPrix, PDO::PARAM_STR);
    $requeteFiltrerProduits->execute();

    $produits = $requeteFiltrerProduits->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($produits);
    exit;
}
?>

<link rel="stylesheet" href="css/prix.css">
<div class="prix-slider-container">
    <label for="prix-slider">Filtrer par prix :</label>
    <input type="range" id="prix-slider" min="0" max="500" value="250" step="10" oninput="updatePrix(this.value)">
    <span id="prix-affiche">250€</span>
</div>


<div id="resultats" class="articles-container"></div>

<div id="liste-complete" class="articles-container">
    <?php foreach ($listeProduits as $produit) { ?>
        <div class="article">
            <a href="produit.php?produit=<?= $produit->id ?>"><img src="images/<?= $produit->image ?>" alt="<?= $produit->image ?>" class="article-photo"></a>
            <div class="article-info">
                <span class="article-title"><?= $produit->nom ?></span>
                <div class="article-details">
                    <span class="article-etat"><?= $produit->etat ?></span>
                    <span class="article-prix"><?= $produit->prix ?>€</span>
                    
                </div>
            </div>
                <?php if (isset($_SESSION['membre']['nom'])) { ?>
                    <form action="ajout-dans-panier.php" method="POST">
                        <input type="hidden" name="produit" value="<?= $produit->id ?>">
                        <input type="hidden" name="prix" value="<?= $produit->prix ?>">
                        <input type="hidden" name="nom" value="<?= htmlspecialchars($produit->nom, ENT_QUOTES, 'UTF-8') ?>">
                        <button class="add-to-cart" data-id="<?= $produit->id ?>" data-nom="<?= htmlspecialchars($produit->nom, ENT_QUOTES, 'UTF-8') ?>" data-prix="<?= $produit->prix ?>">Ajouter au Panier</button>
                        <div id="cart-message" style="display: none;"></div>
                    </form>
                <?php } ?>
        </div>
       
    <?php } ?>  
    
</div>

<script>
document.querySelector('.add-to-cart').addEventListener('click', function() {
    // Récupérer les valeurs des données
    const idProduit = this.getAttribute('data-id');
    const nomProduit = this.getAttribute('data-nom');
    const prixProduit = this.getAttribute('data-prix');
    const idMembre = <?= json_encode($_SESSION['membre']['id']); ?>; // ID de l'utilisateur connecté

    // Créer l'objet XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Configurer la requête AJAX
    xhr.open('POST', 'ajout-dans-panier.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Ajouter les paramètres à l'URLSearchParams
    const params = new URLSearchParams();
    params.append('idProduit', idProduit);
    params.append('idMembre', idMembre);
    params.append('nomProduit', nomProduit);
    params.append('prixProduit', prixProduit);

    // Afficher les paramètres pour le débogage
    console.log(params.toString()); // Affiche les paramètres envoyés avec la requête

    // Envoi de la requête avec les paramètres
    xhr.send(params.toString());

    // Gestion de la réponse du serveur
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log("Réponse du serveur : ", xhr.responseText);  // Affiche la réponse pour le debug
            try {
                const response = JSON.parse(xhr.responseText);  // Parse la réponse JSON

                // Vérifier si la réponse est valide et afficher le message
                const messageContainer = document.getElementById('cart-message');
                messageContainer.style.display = 'block';  // Afficher le conteneur du message

                if (response.success) {
                    messageContainer.textContent = response.message;  // Message de succès
                    messageContainer.style.backgroundColor = '#28a745';  // Vert pour le succès
                } else {
                    messageContainer.textContent = response.message;  // Message d'erreur
                    messageContainer.style.backgroundColor = '#dc3545';  // Rouge pour l'erreur
                }

                // Cacher le message après 3 secondes
                setTimeout(() => { messageContainer.style.display = 'none'; }, 3000);
            } catch (e) {
                console.error("Erreur lors du parsing JSON : ", e);
            }
        } else {
            console.error("Erreur serveur : " + xhr.status);  // En cas d'erreur côté serveur
        }
    };

    xhr.onerror = function() {
        console.error("Erreur lors de la requête AJAX.");
    };
});

</script>


<?php
require "footer.php";
?>