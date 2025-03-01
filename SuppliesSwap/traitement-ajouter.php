<?php

require_once "modele/Produit.php";
require_once "acceseur/ProduitsDAO.php";

$nom = $_POST["nom"];
$categorie = $_POST["categorie"];
$description = $_POST["description"];
$etat = $_POST["etat"];
$prix = $_POST["prix"];
$image = $_FILES["image"]["name"];

$produitArray = array(
    "nom" => $nom,
    "categorie" => $categorie,
    "description" => $description,
    "etat" => $etat,
    "prix" => $prix,
    "image" => $image,
);

$produit = new Produit($produitArray);
ProduitsDAO::ajouterProduit($produit);

$dossier_cible = "images/";
$fichier_cible = $dossier_cible . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageTypeFichier = strtolower(pathinfo($fichier_cible, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

if(file_exists($fichier_cible)){
    $uploadOk = 0;
}

if ($_FILES["image"]["size"] > 500000) {
    echo "L'image est trop lourde!";
    $uploadOk = 0;
}

if ($imageTypeFichier != "jpg" && $imageTypeFichier != "png" && $imageTypeFichier != "jpeg") {
    echo "Le format de l'image doit etre un jpg, png ou jpeg!";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Une erreur est survenue lors de l'upload";
} else{
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $fichier_cible)) {
        echo "Le fichier ". basename( $_FILES["image"]["name"]). " a ete upload avec succes";
    } else {
        echo "Une erreur est survenue lors de l'upload";
    }
}

header("Location: administration.php");