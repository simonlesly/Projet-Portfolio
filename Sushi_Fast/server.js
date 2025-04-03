const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();
const port = 8080;
const cors = require('cors');
app.use(cors());


// Middleware pour parser les données JSON
app.use(express.json());

// Chemin vers le fichier JSON contenant les données
const dataPath = path.join(__dirname, 'data', 'data.json');

// Route pour la racine
app.get('/', (req, res) => {
  res.send('API backend en cours d\'exécution');
});

// Endpoint pour récupérer le boxes
app.get('/api/boxes', (req, res) => {
    console.log('Request received for /api/boxes');  // Log l'appel à l'API
    fs.readFile(dataPath, 'utf8', (err, data) => {
      if (err) {
        console.error('Erreur lors de la lecture du fichier', err);  // Log l'erreur
        res.status(500).json({ message: 'Erreur lors de la lecture des données' });
        return;
      }
      const jsonData = JSON.parse(data);
      res.json(jsonData.boxes);
    });
  });
  

// Endpoint pour récupérer le panier
app.get('/api/cart', (req, res) => {
  fs.readFile(dataPath, 'utf8', (err, data) => {
    if (err) {
      res.status(500).json({ message: 'Erreur lors de la lecture des données' });
      return;
    }
    const jsonData = JSON.parse(data);
    res.json(jsonData.cart);
  });
});

// Endpoint pour ajouter un item au panier
app.post('/api/cart', (req, res) => {
  const newItem = req.body;
  fs.readFile(dataPath, 'utf8', (err, data) => {
    if (err) {
      res.status(500).json({ message: 'Erreur lors de la lecture des données' });
      return;
    }
    const jsonData = JSON.parse(data);
    jsonData.cart.push(newItem);
    fs.writeFile(dataPath, JSON.stringify(jsonData, null, 2), (err) => {
      if (err) {
        res.status(500).json({ message: 'Erreur lors de l\'enregistrement du panier' });
        return;
      }
      res.status(201).json(newItem);
    });
  });
});

// Endpoint pour supprimer un item du panier
app.delete('/api/cart/:itemId', (req, res) => {
  const itemId = parseInt(req.params.itemId);
  fs.readFile(dataPath, 'utf8', (err, data) => {
    if (err) {
      res.status(500).json({ message: 'Erreur lors de la lecture des données' });
      return;
    }
    const jsonData = JSON.parse(data);
    jsonData.cart = jsonData.cart.filter(item => item.id !== itemId);
    fs.writeFile(dataPath, JSON.stringify(jsonData, null, 2), (err) => {
      if (err) {
        res.status(500).json({ message: 'Erreur lors de l\'enregistrement du panier' });
        return;
      }
      res.status(204).end();
    });
  });
});

// Démarrer le serveur
app.listen(port, () => {
  console.log(`Server is running at http://localhost:${port}`);
});
