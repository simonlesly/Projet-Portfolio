<?php

class Membre {
    public ?int $id;
    public ?String $nom;
    public ?String $prenom;
    public ?String $courriel;
    public ?String $motdepasse;

    public static $filtre = array(
        'id' => FILTER_VALIDATE_INT,
        'nom' => FILTER_SANITIZE_SPECIAL_CHARS,
        'prenom' => FILTER_SANITIZE_SPECIAL_CHARS,
        'courriel' => FILTER_SANITIZE_SPECIAL_CHARS,
        'motdepasse' => FILTER_SANITIZE_SPECIAL_CHARS,
        
    );

    function __construct(array $array) {
        $filtree = filter_var_array($array, self::$filtre);
        $this->id = $filtree['id'];
        $this->nom = $filtree['nom'];
        $this->prenom = $filtree['prenom'];
        $this->courriel = $filtree['courriel'];
        $this->motdepasse = $filtree['motdepasse'];
    }
}