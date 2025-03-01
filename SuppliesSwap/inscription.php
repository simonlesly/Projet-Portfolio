<?php
$titre = _("Inscription");
session_start();

require 'header.php';


//echo($_SESSION);
$message = "";


?>

<form action="traitement-inscription.php" id="formulaire-inscription" class="flex column" method="post">

    <h2 id="titre"><?php echo _("Créer un compte"); ?></h2>

    <label class="entree-style-texte">
        <span><?php echo _("Votre nom"); ?></span>
        <input type="text" id="nom-utilisateur" name="nom" placeholder="<?php echo _("Nom de famille"); ?>" required />
    </label>

    <label class="entree-style-texte">
        <span><?php echo _("Votre prenom"); ?></span>
        <input type="text" id="prenom" name="prenom" placeholder="<?php echo _("Prénom"); ?>" required />
    </label>

    <label class="entree-style-texte">
        <span><?php echo _("Courriel"); ?></span>
        <input type="email" id="entree-courriel" name="courriel" required />
    </label>

    <label class="entree-style-texte">
        <span><?php echo _("Mot de passe"); ?></span>
        <input type="password" id="mot-de-passe" name="motdepasse" placeholder="<?php echo _('Au moins 6 caractères'); ?>" required />
    </label>

    <label class="entree-style-texte">
        <span><?php echo _("Confirmez votre mot de passe"); ?></span>
        <input type="password" id="mot-de-passe-verification" name="motdepasseverification" required />
    </label>

    <input type="submit" name ="inscription-information"  value="<?php echo _('Créer un compte'); ?>" />
    <p id="erreur"><?php if (isset($_SESSION['erreur2'])) {
    
    $message = $_SESSION['erreur2'];
    //echo($message);
} ?></p>

    <a id="connection" href="./authentification.php">Se connecter</a>
</form>     

<?php include 'footer.php'; ?>