<?php
require_once "./acceseur/BaseDeDonnees.php";


class HistoriqueDAO {

    public static function requeteAjouterFacture($facture) {
              
        // Préparation de la requête d'insertion
        $SQL_AJOUTER_FACTURE = "INSERT INTO historique (nom_article, numero_article, montant, id_payeur, date_transaction) 
                  VALUES (:nom_article, :numero_article, :montant, :id_payeur, NOW())";
        
        $requeteajouterfacture = BaseDeDonnees::obtenirConnexion()->prepare($SQL_AJOUTER_FACTURE);
        $requeteajouterfacture->bindParam(':nom_article', $facture['nom_produit']);
        $requeteajouterfacture->bindParam(':numero_article', $facture['numero_produit']);
        $requeteajouterfacture->bindParam(':montant', $facture['montant']);
        $requeteajouterfacture->bindParam(':id_payeur', $facture['id_payeur']);
        $requeteajouterfacture->execute();
            // Récupération de l'ID de la facture insérée
            return $requeteajouterfacture->execute();
    }   
    
}
?>
