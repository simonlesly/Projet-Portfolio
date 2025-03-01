<?php
$titre = "Administration";

require './header.php';
require "./acceseur/ProduitsDAO.php";
$listeProduits = ProduitsDAO::listerProduits();
?>

<h2>Administration</h2>


<div class="articles-container">
<?php
foreach ($listeProduits as $produit){?>
    <div class="article">
        <img src="images/<?=$produit->image?>" alt="<?=$produit->image?>" class="article-photo">
        <div class="article-info">
            <span class="article-title"><?=$produit->nom?></span>
            <div class="article-details">
                <span class="article-etat">État : <?=$produit->etat?></span>
                <span class="article-prix">Prix : <?=$produit->prix?>$</span>
            </div>
            <div class="article-buttons">
                <a href="modifier.php?produit=<?=$produit->id?>" class="article-button modifier">
                    <img src="administration/images/modifier.png" alt="Modifier">
                </a>
                <a href="supprimer.php?produit=<?=$produit->id?>" class="article-button supprimer">
                    <img src="administration/images/supprimer.png" alt="Supprimer">
                </a>
            </div>
        </div>
    </div>
    <?php
}
?>
</div>
<?php require 
'footer.php'; ?>