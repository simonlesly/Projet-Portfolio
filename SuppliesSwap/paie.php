<?php
if (isset($_GET['produit']) && isset($_GET['prix']) && isset($_GET['nom'])) {
    $id_produit = $_GET['produit'];
    $prix_produit = $_GET['prix'];
    $nom_produit = $_GET['nom'];
} else {
    echo "Informations sur le produit manquantes!";
    exit;
}
$titre = "Page de paiements";
require 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement avec Stripe</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<h2>Achat de: <?= htmlspecialchars($nom_produit) ?></h2>
<h2>Prix: <?= htmlspecialchars($prix_produit) ?> CAD</h2>

<div class="form-container">
<form id="formulaire-paiement">
    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" required>

    <label for="nom">Nom</label>
    <input type="text" id="nom" required>

    <label for="courriel">Email</label>
    <input type="email" id="courriel" required>

    <label for="telephone">Téléphone</label>
    <input type="tel" id="telephone" required>

    <div id="element-carte"></div>
    <button id="soumettre">Payer <?= htmlspecialchars($prix_produit) ?> CAD</button>

    <div id="erreurs-carte" role="alert"></div>
</form>
</div>

<script>
    const stripe = Stripe('pk_test_51QFLOUHhRMLyDVoUeP2D6FynzIJI5PBBEhwrGQiBXPmQt7JzFWp1r0ClKxIRAqj0q1w34Tqpq8HUC6ceB8wcja7l006nBZKRtE');
    const elements = stripe.elements();
    const carteElement = elements.create('card');
    carteElement.mount('#element-carte');

    document.getElementById('formulaire-paiement').addEventListener('submit', async (event) => {
        event.preventDefault();

        const donneesFormulaire = {
            prenom: document.getElementById('prenom').value,
            nom: document.getElementById('nom').value,
            telephone: document.getElementById('telephone').value,
            courriel: document.getElementById('courriel').value,
            prix: <?= json_encode($prix_produit) ?>,
            nomProduit: <?= json_encode($nom_produit) ?>
        };

        try {
            const reponse = await fetch('paiement.php', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(donneesFormulaire),
            });

            const resultat = await reponse.json();

            if (resultat.clientSecret) {
                const resultatPaiement = await stripe.confirmCardPayment(resultat.clientSecret, {
                    payment_method: {
                        card: carteElement,
                    },
                });

                if (resultatPaiement.error) {
    document.getElementById('erreurs-carte').innerText = resultatPaiement.error.message;
} else {
    // S'assurer que toutes les valeurs sont disponibles
    const { paymentIntent } = resultatPaiement;
    const { id: numero_article } = paymentIntent;
    const montant = donneesFormulaire.prix;
    const { nomProduit, prenom, nom, telephone } = donneesFormulaire;

    // Rediriger vers success.php
    window.location.href = `success.php?nom_article=${encodeURIComponent(donneesFormulaire.nomProduit)}&prix_produit=${encodeURIComponent(donneesFormulaire.prix)}&id_intention_pai=${resultatPaiement.paymentIntent.id}&prenom=${encodeURIComponent(donneesFormulaire.prenom)}&nom=${encodeURIComponent(donneesFormulaire.nom)}&telephone=${encodeURIComponent(donneesFormulaire.telephone)}&courriel=${encodeURIComponent(donneesFormulaire.courriel)}`;

}
            } else {
                document.getElementById('erreurs-carte').innerText = 'Erreur lors de la création de l\'intention de paiement.';
            }
        } catch (error) {
            document.getElementById('erreurs-carte').innerText = 'Erreur interne du serveur. Veuillez réessayer.';
        }
    });
</script>

</body>
</html>
