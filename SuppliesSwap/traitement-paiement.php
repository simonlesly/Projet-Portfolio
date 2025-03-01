<?php
require "acceseur/HistoriqueDAO.php";

if ($_POST) {
    
    $idProduit = $_POST['item_number']; 
    $utilisateurId = 1; 
    $produit = ProduitsDAO::lireProduit($idProduit);

    // Vérifie si le paiement a été réussi
    $paiementReussi = ($_POST['payment_status'] == 'Completed');

    // Enregistre le paiement
    if ($paiementReussi) {
        HistoriqueDAO::enregistrerPaiement($idProduit, $produit->nom, $produit->prix, $utilisateurId, 'success');
        echo "Votre paiement a été réussi.";
    } else {
        HistoriqueDAO::enregistrerPaiement($idProduit, $produit->nom, $produit->prix, $utilisateurId, 'failed');
        echo "Votre paiement a échoué. Veuillez réessayer.";
    }
} else {
    echo "Aucune donnée de paiement reçue.";
}
?>
