<?php
$titre = "Succès";
require 'header.php';
require_once 'acceseur/HistoriqueDAO.php';
require_once 'envoieMail.php';  // Assurez-vous que cette classe existe et est bien incluse


// Correspondance des noms de paramètres avec ceux de l'URL de redirection
$nom_produit = isset($_GET['nom_article']) ? $_GET['nom_article'] : null;
$prix_produit = isset($_GET['prix_produit']) ? $_GET['prix_produit'] : null;
$id_intention_paiement = isset($_GET['id_intention_pai']) ? $_GET['id_intention_pai'] : null;
$prenom = isset($_GET['prenom']) ? $_GET['prenom'] : '';
$nom = isset($_GET['nom']) ? $_GET['nom'] : '';
$telephone = isset($_GET['telephone']) ? $_GET['telephone'] : null; // Ajout du téléphone
$courriel = isset($_GET['courriel']) ? $_GET['courriel'] : null;

// Vérification de la présence de toutes les informations nécessaires
if ($nom_produit && $id_intention_paiement && $prix_produit && $prenom && $nom && $telephone && $courriel) {
    // Création de l'ID payeur
    $id_payeur = trim($prenom . ' ' . $nom);

    // Données de la facture
    $nouvelleFacture = [
        'nom_produit' => $nom_produit,
        'numero_produit' => $id_intention_paiement,
        'montant' => $prix_produit,
        'id_payeur' => $id_payeur
    ];

    // Insertion dans la base de données via HistoriqueDAO
    $idFacture = HistoriqueDAO::requeteAjouterFacture($nouvelleFacture);

    if ($idFacture) {
        
        //envoieMail::envoyer($nouvelleFacture);
        $message = "La facture a été enregistrée et envoyée par email.";
    } else {
        $message = "Erreur lors de l'enregistrement de la facture.";
    }
} else {
    // Si certains paramètres sont manquants, afficher précisément lesquels
    $message = "Erreur : certains paramètres requis sont manquants.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci pour votre commande !</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Merci pour votre commande !</h1>

<p><?= $message ?></p> <!-- Affiche le message d'erreur ou de succès -->

<table>
    <tr>
        <th>Détails de la commande</th>
        <th>Informations client</th>
    </tr>
    <tr>
        <td>
            <strong>Produit :</strong> <?= htmlspecialchars($nom_produit) ?><br>
            <strong>ID de la facture :</strong> <?= htmlspecialchars($id_intention_paiement) ?><br>
            <strong>Montant :</strong> <?= htmlspecialchars($prix_produit) ?> $
        </td>
        <td>
            <strong>Prénom :</strong> <?= htmlspecialchars($prenom) ?><br>
            <strong>Nom :</strong> <?= htmlspecialchars($nom) ?><br>
            <strong>Numéro de téléphone :</strong> <?= htmlspecialchars($telephone) ?><br>
            <strong>Email :</strong> <?= htmlspecialchars($courriel) ?>
        </td>
    </tr>
</table>

<a href="historique-paiement.php">Historique des paiements</a>

</body>
</html>
