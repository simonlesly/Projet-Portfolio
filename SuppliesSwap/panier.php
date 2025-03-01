<?php
session_start();

error_log("ID Produit reçu : " . ($_POST['idProduit'] ?? 'Non défini'));


require 'header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['membre']['id'])) {
    echo "<p>Vous devez être connecté pour accéder à votre panier.</p>";
    exit();
}

$idMembre = $_SESSION['membre']['id'];

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'suppliesswap', 'suppliesswap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les produits du panier
    $stmt = $pdo->prepare('SELECT id, nom, prix, quantite, (prix * quantite) AS total FROM panier WHERE idMembre = :idMembre');
    $stmt->execute(['idMembre' => $idMembre]);
    $panierProduits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Erreur de connexion à la base de données.</p>";
    exit();
}

// Calcul du total du panier
$totalPrix = 0;
$totalQuantite = 0;
foreach ($panierProduits as $produit) {
    $totalPrix += $produit['total'];
    $totalQuantite += $produit['quantite'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="css/panier.css">
</head>
<body>
    <h1>Mon Panier</h1>

    <?php if (empty($panierProduits)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix Unitaire (€)</th>
                    <th>Quantité</th>
                    <th>Total (€)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($panierProduits as $produit): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['nom']) ?></td>
                        <td><?= number_format($produit['prix'], 2) ?></td>
                        <td><?= $produit['quantite'] ?></td>
                        <td><?= number_format($produit['total'], 2) ?></td>
                        <td><button class="remove-from-cart" data-id="<?= $produit['id'] ?>">Retirer</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total :</strong> <?= number_format($totalPrix, 2) ?> €</p>
        <p><strong>Nombre total d'articles :</strong> <?= $totalQuantite ?></p>
    <?php endif; ?>


</body>
</html>
