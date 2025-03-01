<?php

$idProduit = $_GET["produit"];
require "./acceseur/ProduitsDAO.php";
$produit = ProduitsDAO::lireProduit($idProduit);
$nomProduit = $produit->nom;
ProduitsDAO::supprimerProduit($idProduit);



header("Location: administration.php");

?>