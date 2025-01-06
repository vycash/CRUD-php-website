<?php
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");

class AnimalStorageMySQL implements AnimalStorage {
    private PDO $connexion;

    public function __construct(PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function read($id): ?Animal {
        $requete = "SELECT * FROM animals WHERE id = :id";
        $stmt = $this->connexion->prepare($requete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $tab = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tab) {
            return new Animal($tab['id'] , $tab['name'], $tab['species'], $tab['age'], $tab['chemin'] );
        }
        return null;
    }

    public function readAll(): array {
        $requete = "SELECT * FROM animals";
        $result = $this->connexion->query($requete);
        $tableaux = $result->fetchAll(PDO::FETCH_ASSOC);
        $return = [];
        foreach ($tableaux as $tab) {
            $return[$tab['id']] = new Animal($tab['id'] , $tab['name'], $tab['species'], $tab['age'], $tab['chemin']);
        }
        return $return;
    }

    public function create(Animal $a) {
        try {
            $requete = "INSERT INTO animals VALUES (:id , :name, :species, :age, :imagePath)";
            $result = $this->connexion->prepare($requete);

            $result->bindValue(':id', $a->getId(), PDO::PARAM_STR);
            $result->bindValue(':name', $a->getNom(), PDO::PARAM_STR);
            $result->bindValue(':species', $a->getEspece(), PDO::PARAM_STR);
            $result->bindValue(':age', $a->getAge(), PDO::PARAM_INT);
            $result->bindValue(':imagePath', $a->getChemin(), PDO::PARAM_STR);

            $result->execute();

            return $this->connexion->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            error_log("Erreur d'enregistrement: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $requete = "DELETE FROM animals WHERE id = :id";
            $stmt = $this->connexion->prepare($requete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $animal = $this->read($id);
            if ($animal && file_exists($animal->getChemin())) {
                unlink($animal->getChemin());
            }

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Erreur de suppression: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, Animal $a) {
        try {
            $requete = "UPDATE animals SET name = :name, species = :species, age = :age, chemin = :imagePath WHERE id = :id";
            $result = $this->connexion->prepare($requete);

            $result->bindValue(':name', $a->getNom(), PDO::PARAM_STR);
            $result->bindValue(':species', $a->getEspece(), PDO::PARAM_STR);
            $result->bindValue(':age', $a->getAge(), PDO::PARAM_INT);
            $result->bindValue(':imagePath', $a->getChemin(), PDO::PARAM_STR);
            $result->bindValue(':id', $id, PDO::PARAM_INT);

            $result->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Erreur de modification: " . $e->getMessage());
            echo $e->getMessage();
            return false;
        }
    }
}
