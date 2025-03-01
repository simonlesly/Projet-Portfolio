<?php
$pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'root', '');
$nom_id = $_POST['nom_id']; 
$commentaire = trim($_POST['commentaire']);

// je verifie si le commentaire existe 
$affichercommentaire = $pdo->prepare('SELECT COUNT(*) FROM commentaires WHERE nom_id = :nom_id AND commentaire = :commentaire');
$affichercommentaire->execute([':nom_id' => $nom_id, ':commentaire' => $commentaire]);
$commentaireExiste = $affichercommentaire->fetchColumn();

if ($commentaireExiste > 0) {
    http_response_code(400);
    echo "Ce commentaire existe déjà.";
    exit();
}

$affichercommentaire = $pdo->prepare('INSERT INTO commentaires (nom_id, commentaire) VALUES (:nom_id, :commentaire)');
$affichercommentaire->execute([':nom_id' => $nom_id, ':commentaire' => $commentaire]);


echo '<div class="commentaire"><p>' . htmlspecialchars($commentaire) . '</p></div>';
?>
