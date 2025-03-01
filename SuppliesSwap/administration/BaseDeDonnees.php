<?php

class BaseDeDonnees{
    public static function obtenirConnexion(){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $utilisateur = 'suppliesswap';
    $motdepasse = 'suppliesswap';
    $hote = 'localhost';
    $base = 'suppliesswap';

    $dsn = 'mysql:dbname=' . $base . ';host=' . $hote;

    try {
        $basededonnees = new PDO($dsn, $utilisateur, $motdepasse);
        $basededonnees->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $basededonnees->exec('SET CHARACTER SET UTF8');
    }
            
    catch(PDOException $e)
    {
    echo ('Échec de la connexion : ' . $e->getMessage());
    }

    return $basededonnees;
    }
}
?>