<?php
$titre = "Modifier-membre";
$idMembre = $_GET['id'];
require "./acceseur/MembreDAO.php";
$membre = MembreDAO::chercherMembreParId($idMembre);

require 'header.php';

?>

<form method="post"  action="traitement-modifier-membre.php" id="formulaire-modification" class="flex column">

    <h2 id="titre">Modifier profil </h2>

    <fieldset>
 
        <label class="entree-style-texte">
            <span>Votre nom</span>
            <input type="text" id="nom" name="nom" value="<?=$membre->nom ?>"/>
        </label>


        <label class="entree-style-texte">
            <span>Votre prénom</span>
            <input type="text" id="prenom" name="prenom" value="<?=$membre->prenom?>"/>
        </label>

        <label class="entree-style-texte">
            <span>Courriel</span>
            <input type="email" id="entree-courriel" name="courriel" value="<?=$membre->courriel?>"/>
        </label>

        <label class="entree-style-texte">
            <span>Mot de passe Actuel</span>
            <input type="password" name="ancienMdp" id="ancienMdp">
        </label>

        <label class="entree-style-texte">
            <span>Mot de passe</span>
            <input type="password" id="mot-de-passe" name="motdepasse"/>
        </label>

        <label class="entree-style-texte">
            <span>Confirmez votre mot de passe</span>
            <input type="password" id="mot-de-passe-verification" name="motdepasseverification" required />
        </label>

        <input type="hidden" name="id" value="<?=$membre->id?>" hidden>

        <input type="submit"  name="modification-membre" value="Modifier">
    </fieldset>
</form>     

<script src="scripts/ajouter.js"></script>

<?php include 'footer.php'; ?>