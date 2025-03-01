<?php

require_once "./acceseur/BaseDeDonnees.php";
require_once "./modele/Membre.php";

class MembreDAO
{
    public static function enregistrerMembre($nouveauMembre)
    {
        $SQL_AJOUTER_MEMBRE = " INSERT INTO `membre`(`prenom`, `nom`, `courriel`, `motdepasse`) VALUES (:prenom,:nom,:courriel,:motdepasse)";
        $requeteAjouterMembre = BaseDeDonnees::obtenirConnexion()->prepare($SQL_AJOUTER_MEMBRE);
        $requeteAjouterMembre->bindParam(':prenom', $nouveauMembre['prenom'], PDO::PARAM_STR);
        $requeteAjouterMembre->bindParam(':nom', $nouveauMembre['nom'], PDO::PARAM_STR);
        $requeteAjouterMembre->bindParam(':courriel', $nouveauMembre['courriel'], PDO::PARAM_STR);
        $requeteAjouterMembre->bindParam(':motdepasse', $nouveauMembre['motdepasse'], PDO::PARAM_STR);
        //$requeteAjouterMembre->bindParam(':motdepasseverification', $nouveauMembre['motdepasseverification'], PDO::PARAM_STR);
        $requeteAjouterMembre = $requeteAjouterMembre->execute();

        //print_r($nouveauMembre);
        //die();
        return $requeteAjouterMembre;
        
        
    }

    public static function trouverMembre($membre): mixed
    {
        $SQL_AUTHENTIFICATION = "SELECT * FROM membre WHERE nom = :nom";
        $requeteAuthentification = BaseDeDonnees::obtenirConnexion()->prepare($SQL_AUTHENTIFICATION);
        $requeteAuthentification->bindParam(':nom', $membre['nom'], PDO::PARAM_STR);
        $requeteAuthentification->execute();
        $membreTrouve = $requeteAuthentification->fetch();

        //print_r($membre);
        //die();

        return $membreTrouve;

    }

    public static function chercherMembreParId($idMembre): mixed
    {
        $id = $idMembre;   
        $SQL_AUTHENTIFICATION = "SELECT * FROM membre WHERE id = :idMembre";
        $requeteAuthentification = BaseDeDonnees::obtenirConnexion()->prepare($SQL_AUTHENTIFICATION);
        $requeteAuthentification->bindParam(':idMembre', $id, PDO::PARAM_INT);
        $requeteAuthentification->execute();
        $membreTrouve = $requeteAuthentification->fetch();
        $membre = new Membre($membreTrouve);
        return $membre;

    }


    public static function lireMembreParNom($nom)
    {
        $SQL_LIRE_MEMBRE = "SELECT * FROM membre WHERE nom = :nom";
        $requeteAuthentification = BaseDeDonnees::obtenirConnexion()->prepare($SQL_LIRE_MEMBRE);
        $requeteAuthentification->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requeteAuthentification->execute();
        $membre = $requeteAuthentification->fetch();

        return $membre;

    }

    public static function modifierMembre($modification)
    {
        $SQL_MODIFIER_MEMBRE = "UPDATE `membre` SET `prenom`=:prenom,`nom`=:nom,`courriel`=:courriel,`motdepasse`=:motdepasse WHERE `id`= :id";
        $requeteModifierMembre = BaseDeDonnees::obtenirConnexion()->prepare($SQL_MODIFIER_MEMBRE);
        $requeteModifierMembre->bindParam(':id', $modification['id'], PDO::PARAM_INT);
        $requeteModifierMembre->bindParam(':prenom', $modification['prenom'], PDO::PARAM_STR);
        $requeteModifierMembre->bindParam(':nom', $modification['nom'], PDO::PARAM_STR); 
        $requeteModifierMembre->bindParam(':courriel', $modification['courriel'], PDO::PARAM_STR);
        $requeteModifierMembre->bindParam(':motdepasse', $modification['motdepasse'], PDO::PARAM_STR);
        
        return $requeteModifierMembre->execute();
        
    }

    


}