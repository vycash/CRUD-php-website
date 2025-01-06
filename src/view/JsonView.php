<?php
class JsonView {

    public function prepareListPage($animals) {
        // Renvoie une représentation JSON de la liste des noms des animaux
        $result = [];
        foreach ($animals as $id => $animal) {
            $result[] = ['id' => $id, 'nom' => $animal->getNom()];
        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function prepareAnimalPage($animal) {
        // Renvoie une représentation JSON des détails d'un animal
        $result = [
            'nom' => $animal->getNom(),
            'espece' => $animal->getEspece(),
            'age' => $animal->getAge(),
        ];
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function renderError($message) {
        // Renvoie un message d'erreur en JSON
        $result = ['error' => $message];
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}
?>