<?php
$titre = "Ajouter";

require 'header.php';
?>
<link rel="stylesheet" href="administration/css/ajouter.css">

<h2>Ajouter un produit</h2>

<form method="post"  action="traitement-ajouter.php" enctype="multipart/form-data">

    <fieldset>
        <div class="cadre-image" id="cadreImage">
            <img id="preview" src="" alt="Prévisualisation" />
            <p id="placeholder">Cliquez ici pour téléverser une image</p>
        </div>
        <input name="image" type="file" id="televerserImage" accept="image/*" required>
        <label for="nom">Nom du produit:</label><br>
        <input type="text" id="nom" name="nom" required><br>
        <label for="etat">État du produit:</label><br>
        <select id="etat" name="etat">
            <option value="Comme neuf">Comme neuf</option>
            <option value="Très bon">Très bon</option>
            <option value="Bon">Bon</option>
            <option value="Acceptable">Acceptable</option>
        </select>
        <label for="categorie">Catégorie:</label><br>
        <input type="text" id="categorie" name="categorie" required><br>
        <label for="prix">Prix:</label><br>
        <input type="number" id="prix"  step="0.01" name="prix" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        
        
        <input type="submit" value="Ajouter">
    </fieldset>
</form>

<script src="scripts/ajouter.js"></script>

<?php require 
'footer.php'; ?>