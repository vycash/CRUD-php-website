<?php

class AnimalBuilder {
    private $data;
    private $error;


    const NAME_REF = 'nom';
    const SPECIES_REF = 'espece';
    const AGE_REF = 'age';
    const ID_REF = 'id'; 
    const IMAGE_PATH_REF = 'imagePath'; 

    public function __construct($data) {
        $this->data = $data;
        $this->error = "";
    }

    public function getData() { return $this->data; }
    public function getError() { return $this->error; }
    public function pasErreur(){ 
        return $this->isValid();
    }
    
    public function isValid() {
        if (empty($this->data)) {
            $this->error = "Données vides";
            return false;
        }

        if (!isset($this->data[self::NAME_REF])) {
            $this->error = "Nom n'existe pas dans les données";
            return false;
        } elseif (!isset($this->data[self::SPECIES_REF])) {
            $this->error = "Espece n'existe pas dans les données";
            return false;
        } elseif (!isset($this->data[self::AGE_REF])) {
            $this->error = "Age n'existe pas dans les données";
            return false;
        }

        $nom = $this->data[self::NAME_REF];
        $espece = $this->data[self::SPECIES_REF];
        $age = $this->data[self::AGE_REF];

        if (empty($nom) || is_numeric($nom)) {
            $this->error = "Nom invalide";
            return false;
        } elseif (empty($espece) || is_numeric($espece)) {
            $this->error = "Espece invalide";
            return false;
        } elseif (!is_numeric($age) || $age < 0) {
            $this->error = "Age invalide";
            return false;
        }

        return true; 
    }

    public function createAnimal() {

        $id = null;
        if ( isset($this->data[self::ID_REF]) ){
            $id = $this->data[self::ID_REF] === null ? null : $this->data[self::ID_REF];
        }

        $nom = htmlspecialchars($this->data[self::NAME_REF]);
        $espece = htmlspecialchars($this->data[self::SPECIES_REF]);
        $age = htmlspecialchars($this->data[self::AGE_REF]);
        $imagePath = isset($this->data[self::IMAGE_PATH_REF]) ? $this->data[self::IMAGE_PATH_REF] : ''; 


        return new Animal($id, $nom, $espece, $age, $imagePath);
    }
}

?>
