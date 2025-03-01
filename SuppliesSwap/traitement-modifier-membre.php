<?php
session_start();
require "./acceseur/MembreDAO.php";

$idMembre = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$courriel = $_POST['courriel'];
$ancienMdp = $_POST['ancienMdp'];
$motdepasse = $_POST['motdepasse'];
$motdepasseVerification = $_POST['motdepasseverification'];


/*if ($motdepasse !== $motdepasseVerification) {
    echo "Erreur : les mots de passe ne correspondent pas.";
    exit;
}

print_r($membre);
Die();
$membre = MembreDAO::chercherMembreParId($idMembre);
if ($membre->motdepasse !== $ancienMdp) {
    echo "Erreur : le mot de passe actuel est incorrect.";
    exit;
}*/


$membre = MembreDAO::chercherMembreParId($idMembre);
//$_SESSION['membre']['motdepasse'] = $membre['motdepasse'];
print_r($membre->motdepasse);
print_r($motdepasse); 
print_r("  "); // Vérifier le mot de passe récupéré
print_r($ancienMdp);   

//if (!password_verify($ancienMdp, $membre->motdepasse))

if (!password_verify($ancienMdp, $membre->motdepasse)) {
    echo "Erreur : le mot de passe actuel est incorrect.";
    exit;
}

if ($motdepasse !== $motdepasseVerification) {
    echo "Erreur : les mots de passe ne correspondent pas.";
    exit;
}

$motdepasseHash = password_hash($motdepasse, PASSWORD_DEFAULT);


$modification = [
    'id' => $idMembre,
    'nom' => $nom,
    'prenom' => $prenom,
    'courriel' => $courriel,
    'motdepasse' => $motdepasseHash
    //'motdepasseverification' => $motdepasseverification
];

$resultat = MembreDAO::modifierMembre($modification);
if ($resultat) {
    session_destroy();
    header('location: authentification.php');
    exit;
} else {
    echo "Erreur : la mise à jour du profil a échoué.";
}
?>
