<?php
$titre = "Laissez un commentaire ";

require 'header.php';


$SQL_AFFICHER_COMMENTAIRE = new PDO('mysql:host=localhost;dbname=suppliesswap', 'root', '');


$affichercommentaire = $SQL_AFFICHER_COMMENTAIRE->prepare('SELECT * FROM commentaires WHERE nom_id = :nom_id ORDER BY id DESC');
$affichercommentaire->execute([':nom_id' => 1]); 
$commentaires = $affichercommentaire->fetchAll();
?>
 <link rel="stylesheet" href="style/commentaire.css"> 
<div id="nom-detail">
    <h1>Laissez un commentaire ! </h1>

    
    <form id="commentaireForme" onsubmit="return envoyerCommentaire();">
        <textarea id="commentaireTexte" placeholder="Écrivez votre commentaire ici..."></textarea>
        <button type="submit">Envoyer</button>
        <input type="hidden" id="nomId" value="1"> 
    </form>
    <div id="errorMessage" style="color: red; display: none;"></div>

    <!-- Liste des commentaires récupérés depuis la base de données -->
    <div id="liste_commentaire">
        <?php
        foreach ($commentaires as $commentaire) {
            echo '<div class="commentaire">';
            echo '<p>' . htmlspecialchars($commentaire['commentaire']) . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<script>
function envoyerCommentaire() {
    const commentaire = document.getElementById('commentaireTexte').value.trim();
    const listeCommentaire = document.getElementById('liste_commentaire');
    const errorMessage = document.getElementById('errorMessage');
    const nomId = document.getElementById('nomId').value; 

    if (commentaire === "") {
        errorMessage.style.display = "block";
        errorMessage.innerText = "Le commentaire ne peut pas être vide.";
        return false;
    }

    errorMessage.style.display = "none";

    // Vérifie si le commentaire existe déjà
    const commentairesExistants = listeCommentaire.getElementsByClassName('commentaire');
    for (let i = 0; i < commentairesExistants.length; i++) {
        if (commentairesExistants[i].innerText.trim() === commentaire) {
            errorMessage.style.display = "block";
            errorMessage.innerText = "Ce commentaire a déjà été ajouté.";
            return false;
        }
    }

    const params = new URLSearchParams();
    params.append('nom_id', nomId); 
    params.append('commentaire', commentaire);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajout-commentaire.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            listeCommentaire.insertAdjacentHTML('afterbegin', xhr.responseText);
            document.getElementById('commentaireTexte').value = "";
        } else {
            console.error("Erreur serveur :", xhr.status, xhr.statusText);
            alert("Une erreur serveur est survenue. Veuillez réessayer.");
        }
    };

    xhr.onerror = function () {
        alert("Impossible de contacter le serveur.");
    };

    xhr.send(params.toString());
    return false;
}
</script>

<?php 
include 'footer.php'; 
?>
