<?php
print_r($_GET);
print_r($_POST);
$titre = 'Preuve de paiement';
require 'header.php';
require "acceseur/HistoriqueDAO.php";
// Vérifier si les paramètres sont présents dans l'URL
if (isset($_GET['item_name']) && isset($_GET['item_number']) && isset($_GET['amount']) && isset($_GET['PayerID'])) {
    // Récupérer les données des paramètres
    $itemName = htmlspecialchars($_GET['item_name']);
    $itemNumber = htmlspecialchars($_GET['item_number']);
    $amount = htmlspecialchars($_GET['amount']);
    $payerId = htmlspecialchars($_GET['PayerID']);

    // Afficher les informations
    echo "<h1>Détails de la transaction</h1>";
    echo "<p><strong>Nom de l'article :</strong> $itemName</p>";
    echo "<p><strong>Numéro de l'article :</strong> $itemNumber</p>";
    echo "<p><strong>Montant :</strong> $amount</p>";
    echo "<p><strong>ID du Payer :</strong> $payerId</p>";
} else {
    // Message si les paramètres ne sont pas fournis
    echo "<p>Aucune donnée reçue.</p>";
}

$facture = HistoriqueDAO::enregistrerPaiement($_GET['item_number'], $_GET['item_name'], $_GET['amount'], $_GET['PayerID'], $statut_paiement);


if($_POST){

    if ($paiementReussi) {
        HistoriqueDAO::enregistrerPaiement($idProduit, $produit->nom, $produit->prix, $utilisateurId, 'success');
        echo "insersion reussi .";
}
}
?>
