<?php
require_once("AnimalStorage.php");
require_once("Animal.php");

class AnimalStorageStub implements AnimalStorage {
    private $animals;

    public function __construct() {
        $this->animals = array(
            'medor' => new Animal("Médor", "chien", 5),
            'felix' => new Animal("Félix", "chat", 3),
            'denver' => new Animal("Denver", "dinosaure", 150)
        );
    }

    public function read($id) {
        foreach ($this->animals as $key => $animal) {
            if ($key === $id) {
                return $animal;
            }
        }
        return null;
    }

    public function readAll() {
        return $this->animals;
    }

    public function create(Animal $a) {
        throw new Exception("La méthode 'create' n'est pas implémentée dans AnimalStorageStub.");
    }

    public function delete($id) {
        throw new Exception("La méthode 'delete' n'est pas implémentée dans AnimalStorageStub.");
    }

    public function update($id, Animal $a) {
        throw new Exception("La méthode 'update' n'est pas implémentée dans AnimalStorageStub.");
    }
}

