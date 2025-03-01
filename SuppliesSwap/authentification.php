<?php
$titre = _("Ouverture de session");

require 'header.php';

if (isset($_SESSION['erreur'])) {

}
?>

<form action="traitement-authentification.php" id="formulaire-authentification" method="post" class="flex row">
    <h2 id="titre"><?php echo _("Se connecter"); ?></h2>

    <label id="groupe-entree-nom-utilisateur" class="entree-style-texte">
        <span><?php echo _("Nom d'utilisateur"); ?></span>
        <input type="text" id="nom" name="nom" />
    </label>

    <label id="groupe-entree-mot-de-passe" class="entree-style-texte">
        <span><?php echo _("Mot de passe"); ?></span>
        <input type="password" id="mot-de-passe" name="motdepasse" />
    </label>

    <input id="a" type="submit" name="membre-authentification" value="S'authentifier">
    <p id="erreur"></p>
    <a id="inscription" href="./inscription.php"><?php echo _("Créer un compte"); ?></a>
</form>

<?php include 'footer.php'; ?>