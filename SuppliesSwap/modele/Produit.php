<?php

class Produit {
    public ?int $id;
    public ?String $nom;
    public ?String $categorie;
    public ?String $description;
    public ?String $etat;
    public ?float $prix;
    public ?String $image;

    public static $filtre = array(
        'id' => FILTER_VALIDATE_INT,
        'nom' => FILTER_SANITIZE_SPECIAL_CHARS,
        'categorie' => FILTER_SANITIZE_SPECIAL_CHARS,
        'description' => FILTER_SANITIZE_SPECIAL_CHARS,
        'etat' => FILTER_SANITIZE_SPECIAL_CHARS,
        'prix' => FILTER_SANITIZE_NUMBER_FLOAT,
        'image' => FILTER_SANITIZE_SPECIAL_CHARS,
    );

    function __construct(array $array) {
        $filtree = filter_var_array($array, self::$filtre);
        $this->id = $filtree['id'];
        $this->nom = $filtree['nom'];
        $this->categorie = $filtree['categorie'];
        $this->description = $filtree['description'];
        $this->etat = $filtree['etat'];
        $this->prix = $filtree['prix'];
        $this->image = $filtree['image'];
    }
    /*
    public static $filtres = 
		array(
			'id' => FILTER_VALIDATE_INT,
			'nom' => FILTER_SANITIZE_STRING,
			'categorie' => FILTER_SANITIZE_STRING,
			'description' => FILTER_SANITIZE_STRING,
			'etat' => FILTER_SANITIZE_STRING,
			'prix' => FILTER_VALIDATE_FLOAT,
            'image' => FILTER_SANITIZE_STRING            
		);


        private static $tableauErreur = 
        array(
            'id' => "erreur dans l'id",
            'nom' => "erreur dans le nom",
            'categorie' => "erreur dans la categorie",
            'description' => "erreur dans la description",
            'etat' => "erreur dans l'etat",
            'prix' => "erreur dans le prix",
            'image' => "erreur dans l'image"            
        );

        public function __constructeur($tableau) {
            $this->erreurs = [];
            $tableauValide = filter_var_array($tableau,Produit::$filtres);
    
        
            if (empty($nom)){
                $this->erreurs['nom'] = Produit::$tableauErreur->nom;  
            }else $this->nom = $tableau['nom'];
    
            if (empty($categorie)){
                $this->erreurs['categorie'] = Produit::$tableauErreur->categorie;  
            }else $this->categorie = $tableau['categorie'];
    
            if (empty($categorie)){
                $this->erreurs['description'] = Produit::$tableauErreur->description;  
            }else $this->description = $tableau['description'];
            
            if (empty($etat)){
                $this->erreurs['etat'] = Produit::$tableauErreur->etat;  
            }else $this->etat = $tableau['etat'];
            
            if (empty($prix)){
                $this->erreurs['prix'] = Produit::$tableauErreur->prix;  
            }else $this->prix = $tableau['etat'];
    
            if (empty($image)){
                $this->erreurs['image'] = Produit::$tableauErreur->image;  
            }else $this->image = $tableau['image'];
    

    
        }
    */
}
