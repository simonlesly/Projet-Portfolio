<?php
require_once "acceseur/ProduitsDAO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produitId = $_POST['produit_id'];
    $notation = $_POST['notation'];
    
    if (is_numeric($produitId) && is_numeric($notation) && $notation >= 1 && $notation <= 5) {
     
        $success = ProduitsDAO::ajouterNote($produitId, $notation);
        
        if ($success) {
            echo "Merci pour votre note !";
        } else {
            echo "Échec de l'enregistrement de la note.";
        }
    } else {
        echo "Note invalide.";
    }
}
?>
