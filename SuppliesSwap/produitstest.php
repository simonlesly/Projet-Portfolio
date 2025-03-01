<?php

require "./acceseur/ProduitsDAO.php";
$listeProduits = ProduitsDAO::listerProduits();
print_r($listeProduits);