<?php
require_once("view/View.php");
require_once("control/Controller.php");

class Router {
    public function main(AnimalStorage $storage) {
        $feedback="";
        if (isset($_SESSION['feedback'])) {
            $feedback = $_SESSION['feedback'];
            $_SESSION['feedback'] = "";
        }

        $view = new View($this,$feedback);
        $controller = new Controller($view, $storage);
    
        if (!empty($_GET)) {
            switch ($_GET['action'] ?? '') {
                case 'liste':
                    $controller->showList();
                    break;
                case 'nouveau':
                    $controller->createNewAnimal();
                    break;
                case 'sauverNouveau':
                    $controller->saveNewAnimal($_POST);
                    break;
                case 'update':
                    if(isset($_GET['id'])) {
                        $controller->updateAnimal($_GET['id']);
                    }else{
                        $controller->showHomePage();
                    }
                    break;
                case 'delete':
                    if(isset($_GET['id'])) {
                        $controller->deleteAnimal($_GET['id']);
                    }else{
                        $controller->showHomePage();
                    }
                    break;
                default:
                    if (isset($_GET['id'])) {
                        $controller->showInformation($_GET['id']);
                    } else {
                        $controller->showInformation('Inconnu');
                    }
            }
        } else {
            $controller->showHomePage();
        }
        $view->render();
    }

    public function POSTredirect($url, $feedback){
        $_SESSION['feedback'] = $feedback;
        header("Location: " . $url, true, 303);
    }
    public function getAnimalCreationURL(){
        return "site.php?action=nouveau";
    } 
    
    public function getAnimalSaveURL(){
       return "site.php?action=sauverNouveau";
    }


    public function homePage() {
      return "site.php";
    }

  
   public function getAnimalListeURL() {
    return "site.php?action=liste";
   }

    public function getAnimalURL($id) {
        return "site.php?id=" . urlencode($id);
    }

    public function getAnimalUpdateURL($id) {
        return "site.php?action=update&id=" . urlencode($id);
    }

    public function getAnimalDeleteURL($id) {
        return "site.php?action=delete&id=" . urlencode($id);
    }
}

