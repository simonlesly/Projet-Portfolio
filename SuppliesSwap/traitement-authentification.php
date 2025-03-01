<?php
require "./acceseur/MembreDAO.php";
//print_r($_POST);
//die();
session_start();
//$nom = $_POST['nom'];
$_SESSION['erreur'] = NULL;

if (isset($_POST['membre-authentification'])) {
    $filtreMembre = array();
    $filtreMembre['nom'] = FILTER_SANITIZE_SPECIAL_CHARS;
    $filtreMembre['motdepasse'] = FILTER_SANITIZE_ENCODED;
    $membre = filter_input_array(INPUT_POST, $filtreMembre);

    $membreTrouve = MembreDAO::trouverMembre($membre);
    
    $verificationMDP = password_verify($membre['motdepasse'], $membreTrouve['motdepasse']);

    if ($verificationMDP) {
        print("connexion" );
        $_SESSION['membre'] = array();
        $_SESSION['membre']['id'] = $membreTrouve['id'];
        $_SESSION['membre']['prenom'] = $membreTrouve['prenom'];
        $_SESSION['membre']['nom'] = $membreTrouve['nom'];
        $_SESSION['membre']['courriel'] = $membreTrouve['courriel'];  
        header('location: produits.php');   

    } else {
        $_SESSION['erreur'] = "Votre pseudonyme ou votre mot de passe est invalide";
        header('location: authentification.php'); 
    }

    

   
}