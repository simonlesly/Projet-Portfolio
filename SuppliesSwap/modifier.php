<?php
$titre = "Modifier";

$idProduit = $_GET['produit'];
require "./acceseur/ProduitsDAO.php";
$produit = ProduitsDAO::lireProduit($idProduit);
require 'header.php';
?>
<link rel="stylesheet" href="administration/css/ajouter.css">

<h2>Modifier un produit</h2>

<form method="post"  action="traitement-modifier.php" enctype="multipart/form-data">

    <fieldset>
        <div class="cadre-image" id="cadreImage">
            <img id="preview" src="./images/<?=$produit->image?>" alt="Prévisualisation" style="display: block;" />
        </div>
        <input name="image" type="file" id="televerserImage" accept="image/*">
        <label for="nom">Nom du produit:</label><br>
        <input type="text" id="nom" name="nom" value="<?=$produit->nom?>" required><br>
        <label for="etat">État du produit:</label><br>
        <select id="etat" name="etat">
            <option value="Comme neuf" <?php if($produit->etat == 'Comme neuf') echo "selected";?>>Comme neuf</option>
            <option value="Très bon" <?php if($produit->etat == 'Très bon') echo "selected";?>>Très bon</option>
            <option value="Bon" <?php if($produit->etat == 'Bon') echo "selected";?>>Bon</option>
            <option value="Acceptable" <?php if($produit->etat == 'Acceptable') echo "selected";?>>Acceptable</option>
        </select>
        <label for="categorie">Cours:</label><br>
        <input type="text" id="cours" name="categorie" value="<?=$produit->categorie?>" required><br>
        <label for="prix">Prix: </label><br>
        <input type="number" id="prix" name="prix" step="0.01" value="<?=$produit->prix?>" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?=$produit->description?></textarea><br>
        <input type="number" name="id" value="<?=$produit->id?>" hidden>


        <input type="submit" value="Modifier">
    </fieldset>
</form>

<script src="scripts/ajouter.js"></script>

<?php require 
'footer.php'; ?>