<?php
// retirer-de-panier.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['membre']['id']) || !isset($_POST['idProduit'])) {
    echo json_encode(['success' => false, 'message' => 'Paramètres manquants.']);
    exit();
}

$idMembre = $_SESSION['membre']['id'];
$idProduit = $_POST['idProduit'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'suppliesswap', 'suppliesswap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare('DELETE FROM panier WHERE idMembre = :idMembre AND idProduit = :idProduit');
    $stmt->execute(['idMembre' => $idMembre, 'idProduit' => $idProduit]);
    
    echo json_encode(['success' => true, 'message' => 'Produit retiré du panier.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
?>