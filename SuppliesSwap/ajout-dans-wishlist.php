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
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour ajouter un produit à la wishlist.']);
    exit();
}

$idMembre = $_SESSION['membre']['id'];
$idProduit = $_POST['idProduit'];

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'suppliesswap', 'suppliesswap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    exit();
}

// Vérifier si le produit est déjà dans la wishlist
$stmt = $pdo->prepare('SELECT COUNT(*) FROM wishlist WHERE idMembre = :idMembre AND idProduit = :idProduit');
$stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit]);
$exists = $stmt->fetchColumn();

if ($exists > 0) {
    echo json_encode(['success' => false, 'message' => 'Ce produit est déjà dans votre wishlist.']);
    exit();
}

// Ajouter le produit à la wishlist
$stmt = $pdo->prepare('INSERT INTO wishlist (idMembre, idProduit) VALUES (:idMembre, :idProduit)');
$stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit]);

echo json_encode(['success' => true, 'message' => 'Produit ajouté à la wishlist avec succès.']);
