<?php
require_once("model/Animal.php");
require_once("model/AnimalBuilder.php");
require_once("model/AnimalStorage.php");

class Controller {
    private $view;
    private $storage;

    public function __construct($view, AnimalStorage $storage) {
        $this->view = $view;
        $this->storage = $storage;
    }

    public function showInformation($id) {
        $animal = $this->storage->read($id);
        if ($animal !== null) {
            $this->view->prepareAnimalPage($animal);
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function showHomePage() {
        $this->view->prepareHomePage();
    }

    public function showList() {
        $this->view->prepareListPage($this->storage->readAll());
    }

    public function createNewAnimal() {
        $this->view->prepareAnimalCreationPage(new AnimalBuilder($_POST));
    }

    private function handleImageUpload(): ?string {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $tmpName = $_FILES['image']['tmp_name'];
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                return $filePath;
            }
        }
        return null;
    }

    public function saveNewAnimal(array $data) {
        $animalBuilder = new AnimalBuilder($data);
        if ($animalBuilder->pasErreur()) {
            $animal = $animalBuilder->createAnimal();

            $imagePath = $this->handleImageUpload();

            if ($imagePath) {
                $animal->setChemin($imagePath);
            }

            $id = $this->storage->create($animal);
            if($id){
                $this->view->displayAnimalCreationSuccess($id);
            }else{

                $this->view->prepareUnexpectedErrorPage();
            }
        
        } else {
            $this->view->prepareAnimalCreationPage($animalBuilder);
        }
    }

    public function updateAnimal($id) {
        $animal = $this->storage->read($id);

        if ($animal === null) {
            $this->view->prepareUnknownAnimalPage();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $animalBuilder = new AnimalBuilder($_POST);

            if ($animalBuilder->pasErreur()) {

                $imagePath = $this->handleImageUpload();

                $newAnimalData = $animalBuilder->createAnimal();
                if ($imagePath) {
                    $newAnimalData->setChemin($imagePath);
                }
                if($this->storage->update($id, $newAnimalData)){
                    $this->view->displayAnimalUpdateSuccess($id);
                }

            } else {
                $this->view->prepareAnimalUpdatePage($animalBuilder);
            }

        } else {
            $this->view->prepareAnimalUpdatePage(new AnimalBuilder($animal->toArray()));
        }
    }

    public function deleteAnimal($id) {
        if ($this->storage->delete($id)) {
            $_SESSION['feedback'] = "Animal supprimé avec succès.";
            $this->view->prepareHomePage();

        } else {
            $this->view->prepareUnexpectedErrorPage();
        }
    }
}
?>
