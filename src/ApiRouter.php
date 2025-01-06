<?php
require_once("control/Controller.php");
require_once("view/JsonView.php");

class ApiRouter {
    public function main($storage) {
        $view = new JsonView();
        $controller = new Controller($view, $storage);


        $collection = isset($_GET['collection']) ? $_GET['collection'] : null;
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        // Routage
        if ($collection === 'animaux') {
            if ($id === null) {
                // Renvoie la liste des animaux
                $controller->showList();
            } else {
                // Renvoie les détails d'un animal spécifique
                $controller->showInformation($id);
            }
        } else {
            // Si l'URL ne correspond pas à une route définie
            $view->renderError("Collection non reconnue ou paramètres manquants.");
        }
    }
}
?>
