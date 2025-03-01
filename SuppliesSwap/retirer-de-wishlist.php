<?php
session_start();
header('Content-Type: application/json');

// Vérifier si les paramètres sont envoyés
if (!isset($_POST['idProduit']) || !isset($_POST['idMembre'])) {
    echo json_encode(['success' => false, 'message' => 'Les paramètres sont manquants.']);
    exit();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['membre']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour retirer un produit de la wishlist.']);
    exit();
}

$idMembre = $_SESSION['membre']['id'];
$idProduit = $_POST['idProduit'];

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'suppliesswap', 'suppliesswap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si le produit existe dans la wishlist
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM wishlist WHERE idMembre = :idMembre AND idProduit = :idProduit');
    $stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit]);
    $exists = $stmt->fetchColumn();

    if ($exists == 0) {
        echo json_encode(['success' => false, 'message' => 'Ce produit n\'est pas dans votre wishlist.']);
        exit();
    }

    // Retirer le produit de la wishlist
    $stmt = $pdo->prepare('DELETE FROM wishlist WHERE idMembre = :idMembre AND idProduit = :idProduit');
    $stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit]);

    echo json_encode(['success' => true, 'message' => 'Produit retiré de la wishlist avec succès.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du produit: ' . $e->getMessage()]);
}
