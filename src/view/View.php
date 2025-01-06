<?php

class View {
    private $title;
    private $content;
    private $router;  
    private $menu;  
    private $feedback;

    public function __construct($router, $feedback) {
        $this->router = $router;
        $this->menu = array(
            "Accueil" => $this->router->homePage(),
            "Liste d'animaux" => $this->router->getAnimalListeURL(),
            "Créer un animal" => $this->router->getAnimalCreationURL(),
        );
        $this->feedback = $feedback;
    }

    public function getMenu() {
        return $this->menu;
    }
  
    public function prepareAnimalCreationPage(AnimalBuilder $builder) {
        $data = $builder->getData();
        $error = $builder->getError();

        $nom = isset($data[AnimalBuilder::NAME_REF]) ? htmlspecialchars($data[AnimalBuilder::NAME_REF]) : '';
        $espece = isset($data[AnimalBuilder::SPECIES_REF]) ? htmlspecialchars($data[AnimalBuilder::SPECIES_REF]) : '';
        $age = isset($data[AnimalBuilder::AGE_REF]) ? htmlspecialchars($data[AnimalBuilder::AGE_REF]) : '';
    
        $this->title = "Ajouter un Animal";
    
        $s = '<form action="' . $this->router->getAnimalSaveURL() . '" method="POST" enctype="multipart/form-data">' . "\n";
        $s .= "
            <label>Nom:</label>
            <input type='text' placeholder='nom' name='nom' value='" . $nom . "' required />
            
            <label>Espèce :</label>
            <input type='text' placeholder='espèce' name='espece' value='" . $espece . "' required />
            
            <label>Âge :</label>
            <input type='number' placeholder='âge' name='age' value='" . $age . "' required />
            
            <label>Image :</label>
            <input type='file' name='image' accept='image/*' />
            
            <button type='submit' class='btn'>Créer</button>
        </form>
        <p style='color:red;'>".$error."</p>";
    
        $this->content = $s;
    }

    public function prepareAnimalUpdatePage(AnimalBuilder $builder) {

        $data = $builder->getData();
        $error = $builder->getError();
    
        $nom = isset($data[AnimalBuilder::NAME_REF]) ? htmlspecialchars($data[AnimalBuilder::NAME_REF]) : '';
        $espece = isset($data[AnimalBuilder::SPECIES_REF]) ? htmlspecialchars($data[AnimalBuilder::SPECIES_REF]) : '';
        $age = isset($data[AnimalBuilder::AGE_REF]) ? htmlspecialchars($data[AnimalBuilder::AGE_REF]) : '';
        $id = isset($data[AnimalBuilder::ID_REF]) ? htmlspecialchars($data[AnimalBuilder::ID_REF]) : '';
    
        $this->title = "Modifier un Animal";
    
        $s = '<form action="' . $this->router->getAnimalUpdateURL($id) . '" method="POST" enctype="multipart/form-data">' . "\n";
        $s .= "
            <input type='hidden' name='id' value='" . $id . "' />
            
            <label>Nom:</label>
            <input type='text' placeholder='nom' name='nom' value='" . $nom . "' required />
            
            <label>Espèce :</label>
            <input type='text' placeholder='espèce' name='espece' value='" . $espece . "' required />
            
            <label>Âge :</label>
            <input type='number' placeholder='âge' name='age' value='" . $age . "' required />
            
            <label>Image :</label>
            <input type='file' name='image' accept='image/*' />
            
            <button type='submit' class='btn'>Modifier</button>
        </form>
        <p style='color:red;'>".$error."</p>";
    
        $this->content = $s;
    }

    public function displayAnimalUpdateSuccess($id) {
        $this->router->POSTredirect($this->router->getAnimalURL($id), 'Animal modifié avec succès !');
    }

    public function displayAnimalCreationSuccess($id) {
        $this->router->POSTredirect($this->router->getAnimalURL($id), 'Animal créé avec succès !');
    }
    
    public function prepareHomePage() {
        $this->title = "Page d'accueil";
        $this->content = "<p>Bienvenue dans notre gestionnaire d'animaux !</p>";
    }

    public function prepareAnimalPage(Animal $animal) {
        $this->title = "Page sur " . $animal->getNom();
        $imagePath = $animal->getChemin();

        if (!$imagePath || !file_exists($imagePath) || $imagePath === null) {
            $imagePath = 'uploads/default.png';
        }

        $this->content = "<p>" . $animal->getNom() . " est un " . $animal->getEspece() . " de " . $animal->getAge() . " ans.</p>";
        $this->content .= '<img src="' . htmlspecialchars($imagePath) . '" alt="Image de ' . $animal->getNom() . '" style="max-width: 400px;">';
        $this->content .= '<div class="animal-actions">
            <button onclick="location.href=\'' . $this->router->getAnimalUpdateURL($animal->getId()) . '\'">Modifier</button>
            <button onclick="location.href=\'' . $this->router->getAnimalDeleteURL($animal->getId()) . '\'">Supprimer</button>
        </div>';
    }

    public function prepareUnknownAnimalPage() {
        $this->title = "Animal inconnu";
        $this->content = "Désolé, cet animal est inconnu.";
    }

    public function prepareListPage(array $animals) {
        $this->title = "Liste des Animaux";
        $this->content = "<ul class='animal-list'>";
        foreach ($animals as $id => $animal) {
            $url = $this->router->getAnimalURL($id);
            $this->content .= "
                <li class='animal-item'>
                    <div>
                        <span>" . htmlspecialchars($animal->getNom()) . "</span>
                        <a href=\"$url\">Voir</a>
                    </div>
                    <a href=\"" . $this->router->getAnimalDeleteURL($id) . "\" class='delete-btn'>
                        <img src='uploads/trash.png' alt='Supprimer'>
                    </a>
                </li>";
        }
        $this->content .= "</ul>";
    }

    public function prepareUnexpectedErrorPage(Exception $e = null) {
        $this->title = "Erreur";
        $this->content = "Une erreur inattendue s'est produite." . $e;
    }

    public function render() {
        if ($this->title === null || $this->content === null) {
            $this->prepareUnexpectedErrorPage();
        }
        
        ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $this->title; ?></title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="skin/screen.css" />
</head>
<body>
    <nav class="menu">
        <ul>
<?php
foreach ($this->getMenu() as $text => $link) {
    echo "<li><a href=\"$link\">$text</a></li>";
}
?>
        </ul>
    </nav>
    <main>
        <h1><?php echo $this->title; ?></h1>
        <p style="color:green"><?php echo $this->feedback; ?></p>
<?php
echo $this->content;
?>
    </main>
</body>
</html>
<?php 
    }
}
?>
