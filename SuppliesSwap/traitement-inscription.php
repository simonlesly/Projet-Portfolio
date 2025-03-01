<?php
session_start();
require "./acceseur/MembreDAO.php";
require 'envoieMail.php';

$_SESSION['erreur2'] = NULL;
if (isset($_POST['inscription-information']) && !empty($_POST['inscription-information'])) {

    $filterMembre = array(
        'prenom' => FILTER_SANITIZE_SPECIAL_CHARS,
        'nom' => FILTER_SANITIZE_SPECIAL_CHARS,
        'courriel' => FILTER_SANITIZE_SPECIAL_CHARS,
    );

    $nouveauMembre = filter_input_array(INPUT_POST, $filterMembre);
    //print_r($nouveauMembre);
    //die();

    
    if (empty($_POST['motdepasse']) || $_POST['motdepasse'] != $_POST['motdepasseverification']) {
        $_SESSION['erreur2'] = "Les mots de passe doivent être  identiques";
        header('location: inscription.php');
    }

    //if (empty($_POST['nom']) || !preg_match('/^[A-Za-z0-9]+([A-Za-z0-9]*|[._-]?[A-Za-z0-9]+)*$/', $_POST['nom'])) {

    if (empty($nouveauMembre['nom']) || !preg_match('/^[A-Za-z0-9]+([A-Za-z0-9]*|[._-]?[A-Za-z0-9]+)*$/', $nouveauMembre['nom'])) {
        $_SESSION['erreur2'] = "Le nom d'utilisateur est incorrect";
        header('location: inscription.php');
    }else {
        $membre = MembreDAO::lireMembreParNom($nouveauMembre['nom']);
    
        if ($membre) {
            $_SESSION['erreur2'] = "Ce nom d'utilisateur est déjà utilisé";
            header('location: inscription.php');
        }
    }

    if (empty($_SESSION['erreur2'])) {
        
        $nouveauMembre['motdepasse'] = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

        $reussiteInscription = MembreDAO::enregistrerMembre($nouveauMembre);
        
        

        if ($reussiteInscription) {           
            envoieMail::envoyer($nouveauMembre);
            header('location: authentification.php');
                       
        } else {
            $_SESSION['erreur2'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            header('location: inscription.php');
        }
    }

}
