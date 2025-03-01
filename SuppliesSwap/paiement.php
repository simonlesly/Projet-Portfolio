<?php
require_once 'vendor/autoload.php'; // Chargez Stripe via Composer

// Clé API Stripe
\Stripe\Stripe::setApiKey('sk_test_51QFLOUHhRMLyDVoUX1x46tcqxgn4KHNfHf1pPbjCR2Jfkp8J8QhIAurpzCkxGdoatr7jjXQoTHc3NLV0qgQWGuVz00nU2IxA7n');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    try {
        // Récupération des données envoyées par le formulaire
        $donneesClient = json_decode(file_get_contents('php://input'), true);
        $prix = $donneesClient['prix'];
        $nomProduit = $donneesClient['nomProduit'];
        $prenom = $donneesClient['prenom'];
        $nom = $donneesClient['nom'];
        $telephone = $donneesClient['telephone'];
        $courriel = $donneesClient['courriel'];

        if (empty($prix) || empty($nomProduit) || empty($prenom) || empty($nom) || empty($telephone) || empty($courriel)) {
            throw new Exception("Les informations du client ou du produit sont incomplètes.");
        }

        // Création de l'intention de paiement
        $intentionPaiement = \Stripe\PaymentIntent::create([
            'amount' => $prix * 100, 
            'currency' => 'cad',
            'payment_method_types' => ['card'],
            'description' => 'Achat de ' . $nomProduit,
            'metadata' => [
                'prenom' => $prenom,
                'nom' => $nom,
                'telephone' => $telephone,
                'courriel' => $courriel,
                'nom_produit' => $nomProduit,
                'prix_produit' => $prix,
            ],
        ]);

        echo json_encode([
            'clientSecret' => $intentionPaiement->client_secret,
        ]);

    } catch (\Stripe\Exception\ApiErrorException $e) {
        http_response_code(500);
        echo json_encode(['erreur' => 'Erreur Stripe: ' . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['erreur' => 'Erreur interne: ' . $e->getMessage()]);
    }
}
?>
