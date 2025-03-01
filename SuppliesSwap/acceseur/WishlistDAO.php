<?php
require_once "./acceseur/BaseDeDonnees.php";

class WishlistDAO {

    // Ajouter un produit à la wishlist
    public static function ajouterProduit($idMembre, $idProduit) {
        // Vérifier si le produit est déjà dans la wishlist
        if (self::verifierProduitDansWishlist($idMembre, $idProduit)) {
            return false;  // Le produit est déjà dans la wishlist
        }
        
        // Préparer et exécuter la requête d'ajout
        $sql = "INSERT INTO wishlist (idMembreWish, idProduitWish) VALUES (?, ?)";
        $requete = BaseDeDonnees::obtenirConnexion()->prepare($sql);
        return $requete->execute([$idMembre, $idProduit]);
    }

    // Vérifier si un produit est déjà dans la wishlist
    public static function verifierProduitDansWishlist($idMembre, $idProduit) {
        $sql = "SELECT COUNT(*) FROM wishlist WHERE idMembreWish = ? AND idProduitWish = ?";
        $requete = BaseDeDonnees::obtenirConnexion()->prepare($sql);
        $requete->execute([$idMembre, $idProduit]);
        return $requete->fetchColumn() > 0;
    }
}
?>
