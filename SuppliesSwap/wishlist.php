<?php
session_start();
require 'header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['membre']['id'])) {
    echo "<p>Vous devez être connecté pour accéder à votre wishlist.</p>";
    exit();
}

$idMembre = $_SESSION['membre']['id'];

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=suppliesswap', 'suppliesswap', 'suppliesswap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les produits de la wishlist de l'utilisateur
    $stmt = $pdo->prepare(
        'SELECT p.id AS idProduit, p.nom, p.image, p.prix, p.description 
         FROM wishlist w 
         JOIN produits p ON w.idProduit = p.id 
         WHERE w.idMembre = :idMembre'
    );
    $stmt->execute(['idMembre' => $idMembre]);
    $wishlistProduits = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p>Erreur de connexion à la base de données.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Wishlist</title>
    <link rel="stylesheet" href="css/wishlist.css">
</head>
<body>
    <h1>Ma Wishlist</h1>

    <?php if (empty($wishlistProduits)): ?>
        <p>Votre wishlist est vide.</p>
    <?php else: ?>
        <div class="wishlist-container">
            <?php foreach ($wishlistProduits as $produit): ?>
                <div class="wishlist-item">
                    <img src="images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="produit-image">
                    <h2><?= htmlspecialchars($produit['nom']) ?></h2>
                    <p><?= htmlspecialchars($produit['description']) ?></p>
                    <p>Prix : <?= htmlspecialchars($produit['prix']) ?> €</p>
                    <button class="remove-from-wishlist" data-id="<?= $produit['idProduit'] ?>">Retirer</button>
                    <!-- Conteneur pour afficher les messages -->
<div id="wishlist-message" class="wishlist-message" style="display: none;"></div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <script>
        // Gestion de la suppression via AJAX
     // Gestion de la suppression via AJAX
// Gestion de la suppression via AJAX
document.querySelectorAll('.remove-from-wishlist').forEach(button => {
    button.addEventListener('click', function() {
        const idProduit = this.getAttribute('data-id');
        const idMembre = <?= json_encode($_SESSION['membre']['id']); ?>;

        const xhr = new XMLHttpRequest();

        // Configurer la requête AJAX pour retirer du produit de la wishlist
        xhr.open('POST', 'retirer-de-wishlist.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        const params = new URLSearchParams();
        params.append('idProduit', idProduit);
        params.append('idMembre', idMembre);

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText); // Parse la réponse JSON

                    // Créer un conteneur pour le message de confirmation
                    const messageContainer = document.createElement('div');
                    messageContainer.classList.add('wishlist-message');

                    if (response.success) {
                        // Retirer l'élément de la wishlist du DOM
                        button.parentElement.remove();

                        // Afficher un message de succès
                        messageContainer.textContent = response.message;
                        messageContainer.style.backgroundColor = '#28a745'; // Couleur verte pour le succès
                    } else {
                        // Afficher un message d'erreur
                        messageContainer.textContent = response.message;
                        messageContainer.style.backgroundColor = '#dc3545'; // Couleur rouge pour l'erreur
                    }

                    // Ajouter le message au DOM
                    document.body.appendChild(messageContainer);

                    // Afficher le message et le cacher après 3 secondes
                    messageContainer.style.display = 'block';
                    setTimeout(() => { messageContainer.style.display = 'none'; }, 400);

                } catch (e) {
                    console.error("Erreur lors du parsing JSON : ", e);
                }
            } else {
                alert("Erreur lors de la suppression du produit.");
            }
        };

        xhr.send(params.toString());
    });
});




    </script>
    
</body>
</html>

<?php require 
'footer.php'; ?>
