<?php


require_once "./acceseur/BaseDeDonnees.php";
require_once "./modele/Produit.php";

class ProduitsDAO
{

    public static function listerProduits()
    {
        $MESSAGE_SQL_LISTE_PRODUITS = "SELECT * FROM `produits`";
        $requeteListeProduits = BaseDeDonnees::obtenirConnexion()->prepare($MESSAGE_SQL_LISTE_PRODUITS);
        $requeteListeProduits->execute();
        $listeProduitsSQL = $requeteListeProduits->fetchAll();

        $listeProduits = [];
        foreach ($listeProduitsSQL as $produit) {
            array_push($listeProduits, new Produit($produit));
        }

        return $listeProduits;
        /*
        $listeProduits = [];
        foreach ($listeProduitsSQL as $produit) {
            array_push($listeProduits, new Produit($produit['id'], $produit['nom'], $produit['categorie'], $produit['description'], $produit['etat'], $produit['prix'], $produit['image']));
        }
        return $listeProduits;
        */
    }

    public static function lireProduit($idProduit)
    {
        $MESSAGE_SQL_DETAILS_PRODUIT = "SELECT * FROM `produits` WHERE id = :idProduit";
        $requeteListeProduit = BaseDeDonnees::obtenirConnexion()->prepare($MESSAGE_SQL_DETAILS_PRODUIT);
        $requeteListeProduit->bindValue('idProduit', $idProduit, PDO::PARAM_INT);
        $requeteListeProduit->execute();
        $produitSQL = $requeteListeProduit->fetch();
        $produit = new Produit($produitSQL);
        //$produit = new Produit($produitSQL['id'], $produitSQL['nom'], $produitSQL['categorie'], $produitSQL['description'], $produitSQL['etat'], $produitSQL['prix'], $produitSQL['image']);
        return $produit;
    }

    public static function ajouterProduit($produit){
        $nom = $produit->nom;
        $categorie = $produit->categorie;
        $description = $produit->description;
        $etat = $produit->etat;
        $prix = $produit->prix;
        $image = $produit->image;

        $MESSAGE_SQL_AJOUTER_PRODUIT = "INSERT INTO `produits`(`id`, `nom`, `categorie`, `description`, `etat`, `prix`, `image`) VALUES (null, :nom,:categorie,:description,:etat,:prix,:image)";
        $requeteAjouterProduit = BaseDeDonnees::obtenirConnexion()->prepare($MESSAGE_SQL_AJOUTER_PRODUIT);
        $requeteAjouterProduit->bindValue(':nom', $nom, PDO::PARAM_STR);
        $requeteAjouterProduit->bindValue(':categorie', $categorie, PDO::PARAM_STR);
        $requeteAjouterProduit->bindValue(':description', $description, PDO::PARAM_STR);
        $requeteAjouterProduit->bindValue(':etat', $etat, PDO::PARAM_STR);
        $requeteAjouterProduit->bindValue(':prix', $prix, PDO::PARAM_STR);
        $requeteAjouterProduit->bindValue(':image', $image, PDO::PARAM_STR);
        $requeteAjouterProduit->execute();
    }

    public static function ModifierProduit($produit){

        $id = $produit->id;
        $nom = $produit->nom;
        $categorie = $produit->categorie;
        $description = $produit->description;
        $etat = $produit->etat;
        $prix = $produit->prix;
        $image = $produit->image;
        $MESSAGE_SQL_MODIFIER_PRODUIT = "UPDATE `produits` SET `nom`=:nom,`categorie`=:categorie,`description`=:description,`etat`=:etat,`prix`=:prix,`image`=:image WHERE id = :id";
        $requeteModifierProduit = BaseDeDonnees::obtenirConnexion()->prepare($MESSAGE_SQL_MODIFIER_PRODUIT);
        $requeteModifierProduit->bindValue(':id', $id, PDO::PARAM_INT);
        $requeteModifierProduit->bindValue(':nom', $nom, PDO::PARAM_STR);
        $requeteModifierProduit->bindValue(':categorie', $categorie, PDO::PARAM_STR);
        $requeteModifierProduit->bindValue(':description', $description, PDO::PARAM_STR);
        $requeteModifierProduit->bindValue(':etat', $etat, PDO::PARAM_STR);
        $requeteModifierProduit->bindValue(':prix', $prix, PDO::PARAM_STR);
        $requeteModifierProduit->bindValue(':image', $image, PDO::PARAM_STR);
        $requeteModifierProduit->execute();
    }

    public static function supprimerProduit($idProduit){
        $MESSAGE_SQL_SUPPRIMER_PRODUIT = "DELETE FROM `produits` WHERE id = :idProduit";
        $requeteSupprimerProduit = BaseDeDonnees::obtenirConnexion()->prepare($MESSAGE_SQL_SUPPRIMER_PRODUIT);
        $requeteSupprimerProduit->bindValue('idProduit', $idProduit, PDO::PARAM_INT);
        $requeteSupprimerProduit->execute();
    }

    public static function ajouterNote($produitId, $notation){

        $MESSAGE_SQL_AJOUTER_NOTE = "INSERT INTO `notations`(`produit_id`, `notation`) VALUES (:produit_id, :notation)";
        
        $requeteAjouterNote = BaseDeDonnees::obtenirConnexion()->prepare($MESSAGE_SQL_AJOUTER_NOTE);
        
        $requeteAjouterNote->bindValue(':produit_id', $produitId, PDO::PARAM_INT);
        $requeteAjouterNote->bindValue(':notation', $notation, PDO::PARAM_INT);
        
        return $requeteAjouterNote->execute();
        }
}