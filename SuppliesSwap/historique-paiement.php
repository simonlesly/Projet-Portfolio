<?php
$titre = "Historique des paiements";
require 'header.php';
require_once "acceseur/HistoriqueDAO.php";
require_once "acceseur/BaseDeDonnees.php";

$base = BaseDeDonnees::obtenirConnexion();

$id_payeur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_payeur'])) {
    $id_payeur = trim($_POST['id_payeur']);
    
    $requete = "SELECT * FROM historique WHERE id_payeur = :id_payeur ORDER BY date_transaction DESC";
    $facture = $base->prepare($requete);
    $facture->bindValue(':id_payeur', $id_payeur, PDO::PARAM_STR); 
    $facture->execute();

    $historique = $facture->fetchAll(PDO::FETCH_OBJ);
} else {
    $historique = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?></title>
    <link rel="stylesheet" href="style.css">
   
</head>
<body>

<h1>Historique des paiements</h1>

<form method="POST">
    <label for="id_payeur">ID du payeur:</label>
    <input type="text" name="id_payeur" id="id_payeur" value="<?= htmlspecialchars($id_payeur) ?>" required>
    <button type="submit">Rechercher</button>
</form>

<?php if ($historique): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom de l'article</th>
            <th>Numéro de l'article</th>
            <th>Montant</th>
            <th>ID du payeur</th>
            <th>Date de la transaction</th>
        </tr>

        <?php foreach ($historique as $transaction) : ?>
    <tr>
        <td><?= htmlspecialchars($transaction->id ?? '') ?></td>
        <td><?= htmlspecialchars($transaction->nom_article ?? '') ?></td>
        <td><?= htmlspecialchars($transaction->numero_article ?? '') ?></td>
        <td><?= htmlspecialchars($transaction->montant ?? '') ?> $</td>
        <td><?= htmlspecialchars($transaction->id_payeur ?? '') ?></td>
        <td><?= htmlspecialchars($transaction->date_transaction ?? '') ?></td>
    </tr>
<?php endforeach; ?>
</table>
<?php else: ?>
    
<?php endif; ?>

<?php
require 'footer.php';
?>

