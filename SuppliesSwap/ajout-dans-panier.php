<?php
session_start();
header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['membre']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour ajouter un produit au panier.']);
    exit();
}

// Vérifier si les données POST existent
if (!isset($_POST['produit']) || !isset($_POST['prix']) || !isset($_POST['nom'])) {
    echo json_encode(['success' => false, 'message' => 'Paramètres manquants.']);
    exit();
}

// Récupérer les valeurs envoyées
$idMembre = $_SESSION['membre']['id'];
$idProduit = $_POST['produit'];
$prix = $_POST['prix'];
$nom = $_POST['nom'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'suppliesswap', 'suppliesswap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si le produit est déjà dans le panier
    $stmt = $pdo->prepare('SELECT * FROM panier WHERE idMembre = :idMembre AND idProduit = :idProduit');
    $stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produit) {
        // Si le produit est déjà dans le panier, augmenter la quantité
        $stmt = $pdo->prepare('UPDATE panier SET quantite = quantite + 1 WHERE idMembre = :idMembre AND idProduit = :idProduit');
        $stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit]);
        echo json_encode(['success' => true, 'message' => 'Produit déjà ajouté au panier. Quantité mise à jour.']);
    } else {
        // Sinon, ajouter le produit dans le panier
        $stmt = $pdo->prepare('INSERT INTO panier (idMembre, idProduit, nom, prix, quantite) VALUES (:idMembre, :idProduit, :nom, :prix, 1)');
        $stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit, 'nom' => $nom, 'prix' => $prix]);
        echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
?>
