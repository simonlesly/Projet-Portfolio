<?php
session_start();

if (!isset($_SESSION['membre']['id'])) {
    echo "Erreur : utilisateur non connecté.";
    exit();
}

$idMembre = $_SESSION['membre']['id'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'suppliesswap', 'suppliesswap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Supprimer tous les produits du panier de l'utilisateur
    $stmt = $pdo->prepare("DELETE FROM panier WHERE idMembre = :idMembre");
    $stmt->execute(['idMembre' => $idMembre]);

    echo "Panier vidé avec succès.";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données.";
}
?>
