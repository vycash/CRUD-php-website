<?php

class Animal {
  
  private $id;
  private $nom;
  private $espece;
  private $age;
  private $chemin;

  public function __construct($id ,  string $nom , string $espece , $age ,$chemin) {
    $this->id = $id;
    $this->nom = $nom;
    $this->espece = $espece;
    $this->age = $age;
    $this->chemin = $chemin === null ? '' : $chemin;
  }
  
  
  public function toArray(){
     return [
          'id'=> $this->id,
          'nom'=> $this->nom,
          'espece'=> $this->espece,
          'age'=> $this->age,
          'chemin'=> $this->chemin,
     ];
  }
  
  public function getNom(): string {
    return $this->nom;
  }

  public function getId() {
    return $this->id;
  }

  public function getChemin(): string {
    return $this->chemin ?: '';
  }

  public function setChemin(string $chemin): void {
     $this->chemin = $chemin;
  }

  public function getEspece(): string {
    return $this->espece;
  }
  public function getAge() {
    return $this->age;
}

}
