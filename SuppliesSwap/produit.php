<?php
$titre = "";

$idProduit = $_GET['produit'];
require_once "acceseur/ProduitsDAO.php";
$produit = ProduitsDAO::lireProduit($idProduit);
require 'header.php';
?>
    
    <section class="contenu">
        <div class="image">
            <img src="./images/<?=$produit->image?>" alt="<?=$produit->nom?>">
        </div>
            <div class="text">
            <h2 class="nom"><?php echo _("Nom du produit : "); ?> <?=$produit->nom?></h2>
            <h3 class="etat"><?php echo _("État du produit : "); ?> <?=$produit->etat?></h3>
            <h3 class="categorie"><?php echo _("Cours : "); ?> <?=$produit->categorie?></h3>
            <h3 class="prix"><?php echo _("Prix : "); ?> <?=$produit->prix?>€</h3>
            <h3 class="description"><?php echo _("Description : "); ?> <?=$produit->description?></h3>
            <button class="add-to-wishlist" data-id="<?= $idProduit; ?>"><?php echo _("Ajouter à la wishlist"); ?></button>
            <div id="wishlist-message" style="display: none; padding: 10px; color: white; text-align: center;"></div>

        </div> 
        <div class="notation">
            <span data-value="5">★</span>
            <span data-value="4">★</span>
            <span data-value="3">★</span>
            <span data-value="2">★</span>
            <span data-value="1">★</span>
        </div>
        <div id="notation-resultat"></div>       

        
        


    </section>

<script>

document.querySelectorAll('.notation span').forEach(star => {
    star.addEventListener('click', function() {
        const notation = this.getAttribute('data-value');
        const produit_id = <?= json_encode($idProduit); ?>; 
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'note_produit.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('notation-resultat').innerText = xhr.responseText;
            } else {
                document.getElementById('notation-resultat').innerText = _("Erreur lors de l'envoi de la note");
            }
        };
        xhr.send(`produit_id=${produit_id}&notation=${notation}`);
    });
});

document.querySelector('.add-to-wishlist').addEventListener('click', function() {
    // Récupérer les valeurs des données
    const idProduit = this.getAttribute('data-id');
    const idMembre = <?= json_encode($_SESSION['membre']['id']); ?>; // ID de l'utilisateur connecté

    // Créer l'objet XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Configurer la requête AJAX
    xhr.open('POST', 'ajout-dans-wishlist.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Ajouter les paramètres à l'URLSearchParams
    const params = new URLSearchParams();
    params.append('idProduit', idProduit);
    params.append('idMembre', idMembre);

    // Envoi de la requête avec les paramètres
    xhr.send(params.toString());

    // Gestion de la réponse du serveur
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log("Réponse du serveur : ", xhr.responseText);  // Affiche la réponse pour le debug
            try {
                const response = JSON.parse(xhr.responseText);  // Parse la réponse JSON

                // Vérifier si la réponse est valide et afficher le message
                const messageContainer = document.getElementById('wishlist-message');
                messageContainer.style.display = 'block';  // Afficher le conteneur du message

                if (response.success) {
                    messageContainer.textContent = response.message;  // Message de succès
                    messageContainer.style.backgroundColor = '#28a745';  // Vert pour le succès
                } else {
                    messageContainer.textContent = response.message;  // Message d'erreur
                    messageContainer.style.backgroundColor = '#dc3545';  // Rouge pour l'erreur
                }

                // Cacher le message après 3 secondes
                setTimeout(() => { messageContainer.style.display = 'none'; }, 900);
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








    console.log(params.toString()); // Affiche les paramètres envoyés avec la requête
    console.log("idProduit:", idProduit);
console.log("idMembre:", idMembre);


</script>


    <?php 
    require "footer.php";
    ?>