<?php
session_start();
?>

<?php
/*
$lang = 'fr_FR';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['fr_FR', 'en_CA'])) {
    $lang = $_GET['lang'];
    
    setcookie('lang', $lang, time() + 3600 * 24 * 30); 
} elseif (isset($_COOKIE['lang'])) {
    
    $lang = $_COOKIE['lang'];
}

$domain = 'main';
bindtextdomain($domain, realpath('./') . DIRECTORY_SEPARATOR . 'locale');
textdomain($domain);

if (!setlocale(LC_ALL, $lang, $lang . '.UTF-8')) {
    throw new Exception('Locale non supportée : ' . $lang);
}
*/
?>
<!DOCTYPE html>
<html">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Supplies Swap">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico" type="./image/x-icon">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/note.css">
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/produit.css">
    <link rel="stylesheet" href="css/paie.css">
    <link rel="stylesheet" href="css/historique.css">
    <link rel="stylesheet" href="css/administration.css">
    <link rel="stylesheet" href="css/a-propos.css">
    <link rel="stylesheet" href="css/recherche.css">
    <link rel="stylesheet" href="css/formulaire-authentification.css">
    <link rel="stylesheet" href="css/formulaire-inscription.css">
    <link rel="stylesheet" href="css/modifier-profil.css">
    <link rel="stylesheet" href="css/panier.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Mono&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Supplies Swap <?=$titre?></title>
</head>
<body>
<header>
    <div id="en-tete">
    <?php
        
        if (isset($_SESSION['membre']['nom'])) {
            echo '<a class="bouton-nom"> ' . htmlspecialchars($_SESSION['membre']['nom']) .  '</a>';
            echo '<a class="bouton-modifier" href="./modifier-membre.php?id='. $_SESSION['membre']['id']. '"> '. _("Modifier"). '</a>';
            echo '<a class="bouton-deconnexion" href="./deconnexion.php"> '. _("Deconnexion"). '</a>';
            
            
        } else {
            echo '<a class="bouton-connexion" href="./authentification.php">' . _("MON COMPTE") . '</a>';
        }
        ?>
        
        <form method="get" action="">
            <select id="bouton-langue" name="lang" onchange="this.form.submit()">
                <option value="fr_FR" <?php echo $lang === 'fr_FR' ? 'selected' : ''; ?>>Français</option>
                <option value="en_CA" <?php echo $lang === 'en_CA' ? 'selected' : ''; ?>>English (Canada)</option>
            </select>
        </form>

        <div class="menu-hamburger">
                <img src="images/menu-hamburger.png">
        </div>
    </div>
    <nav id="menu">
        <ul>
            <li><a href="index.php" class="bouton-acceuil"><img id="logo-menu" src="./images/logo.ico"></a></li>
            <li><a href="produits.php"><?php echo _("Produits"); ?></a></li>
            <li><a href="a-propos.php"><?php echo _("À propos"); ?></a></li>
            <li>
                <form action="recherche.php" method="GET" class="form-recherche">
                    <input type="text" name="q" placeholder= <?php echo _("Rechercher un produit"); ?> class="barre-recherche">
                    <button type="submit" class="bouton-recherche"><img src="./images/loupe.png"></button>
                </form>
            </li>
            <?php if ($titre == _("Administration") || $titre == _("Ajouter") || $titre == _("Modifier")){?>
            <li><a href="ajouter.php" class="bouton-ajouter"><img src="images/ajouter.png"/></a></li>
            <?php
            } else {?>

            <li><a href="panier.php" class="bouton-panier"><img src="images/panier.png"/></a></li>
            <li><a href="wishlist.php" class="bouton-wishlist"><img src="images/souhait.png"/></a></li>
            <?php } ?>
        </ul>
    </nav>
</header>

<div class="espace-vide"></div>