## Ce projet est un site web simple réalisé en PHP permettant de gérer une base de données d'animaux. Il a été développé dans le cadre d'un projet universitaire en respectant l'architecture **MVCR** (Modèle, Vue, Contrôleur, Routeur) pour garantir modularité, maintenance et évolutivité.

Ce projet a été construit en utilisant l'architecture MVCR (Modèle, Vue, Contrôleur, Routeur) pour assurer la modularité et faciliter la maintenance et la mise à jour.
- Vous devrez modifier le fichier `mysql_config.php` avec les informations nécessaires (détails de connexion, nom d'utilisateur, mot de passe, nom d'hôte, etc.).
- Vous pouvez créer une table compatible dans votre base de données en utilisant le fichier SQL fourni.
- Ensuite, vous pouvez héberger le code sur la plateforme de votre choix et tout devrait être prêt.
- Après avoir complété les étapes ci-dessus, l'API devrait également être fonctionnelle.

#### Les appels API doivent être effectués avec les variables suivantes :
- `api.php?collection=animaux` : pour obtenir la liste complète des animaux (seulement le nom et l'ID).
- `api.php?collection=animaux&id=1` : pour obtenir les informations complètes sur un animal avec l'ID 1.

## Fonctionnalités
- Ajouter, modifier et supprimer des animaux.
- Enregistrer et afficher les informations d’un animal (nom, âge, espèce, et chemin de l'image).
- Upload sécurisé d’images pour chaque animal.
- Validation des fichiers uploadés (extensions acceptées : PNG, JPEG, etc.).
- Protection contre les scripts malveillants (injections, CSRF, etc.).
- Gestion de la base de données MySQL pour stocker les données.

## Prérequis
Avant de commencer, assurez-vous d'avoir :
- Un serveur web fonctionnel (par exemple : Apache ou Nginx).
- PHP version 7.4 ou plus récente.
- MySQL pour la base de données.

## Installation
1. **Clonez ce dépôt** sur votre machine locale :
```bash
git clone https://github.com/vycash/CRUD-php-website.git
```

2. **Accédez au répertoire du projet** :
```bash
cd CRUD-php-website
```

3. **Configurez les informations de connexion MySQL** :
   - Ouvrez le fichier `mysql_config.php` et remplacez les valeurs par vos informations :
```php
     <?php
     define('MYSQL_HOST', 'mysql:host=your_mysql_host;'); 
     define('MYSQL_PORT', 'port=your_port;'); 
     define('MYSQL_DB', 'dbname=your_db'); 
     define('MYSQL_USER', 'your_username');  
     define('MYSQL_PASSWORD', 'your_password'); 
     ?>
```

4. **Créez une table dans votre base de données** :
   - Avant de lancer le projet, créez une table compatible dans votre base de données en utilisant le fichier sql présent dans le projet.
   - dans votre base donnez utiliser cette commande 
``` > source animals.sql 
```
   - Voici la structure SQL de la table utilisée :
```sql
     CREATE TABLE animaux (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         species VARCHAR(255) NOT NULL,
         age INT NOT NULL,
         imagePath VARCHAR(255) NOT NULL
     );
```

5. **Lancez le projet** :
   - Déployez le projet sur votre serveur local ou une plateforme d’hébergement (ex. : XAMPP, WAMP).

## Sécurité
Le projet inclut des mesures pour garantir une sécurité optimale :
- Validation des extensions et tailles des fichiers uploadés.
- Filtrage des données d'entrée pour prévenir les injections SQL et XSS.
- Protection CSRF.

## Notes
- Pour modifier les routes ou configurer d'autres paramètres, reportez-vous au fichier `router.php`.
- Toute modification du modèle doit être synchronisée avec la base de données et le fichier `Model`.



## This project is a simple website made in PHP to manage an animal database. It was developed as part of a university project following the **MVCR** architecture (Model, View, Controller, Router) to ensure modularity, maintenance, and scalability.
This project was built using the MVCR architecture (Model, View, Controller, Router) to ensure modularity and make it easier to maintain and update.
- You will need to modify the `mysql_config.php` file with the necessary information (connection details, username, password, hostname, etc.).
- You can create a compatible table in your database using the provided SQL file.
- Next, you can host the code on a platform of your choice and it should be all set.
- After completing the steps above, the API should also be functional.

#### API calls must be made with the following variables:
- `api.php?collection=animaux` : to get the full list of animals (only name and ID).
- `api.php?collection=animaux&id=1` : to get the full info about one animal with ID 1.

## Features
- Add, modify, and delete animals.
- Record and display information about an animal (name, age, species, and image path).
- Secure image upload for each animal.
- Validation of uploaded files (accepted extensions: PNG, JPEG, etc.).
- Protection against malicious scripts (injections, CSRF, etc.).
- MySQL database management to store data.

## Prerequisites
Before starting, make sure you have:
- A functional web server (e.g., Apache or Nginx).
- PHP version 7.4 or newer.
- MySQL for the database.

## Installation
1. **Clone this repository** to your local machine:
```bash
   git clone https://github.com/vycash/CRUD-php-website.git
```
2. **Navigate to the project directory**:
```bash
	cd CRUD-php-website
```
3. **Configure MySQL connection information:**
	Open the mysql_config.php file and replace the values with your information:
```php
     <?php
     define('MYSQL_HOST', 'mysql:host=your_mysql_host;'); 
     define('MYSQL_PORT', 'port=your_port;'); 
     define('MYSQL_DB', 'dbname=your_db'); 
     define('MYSQL_USER', 'your_username');  
     define('MYSQL_PASSWORD', 'your_password'); 
     ?>
```
4. **Create a table in your database** :
- Before running the project, create a compatible table in your database using the SQL file provided in the project.
- in your database, use this command: > source animals.sql
- Here is the SQL structure of the table used :
```sql
     CREATE TABLE animaux (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         species VARCHAR(255) NOT NULL,
         age INT NOT NULL,
         imagePath VARCHAR(255) NOT NULL
     );
```

5. **Run the project:**
  Deploy the project on your local server or a hosting platform (e.g., XAMPP, WAMP).
  
## Security
The project includes measures to ensure optimal security:

- Validation of file extensions and sizes for uploads.
- Filtering input data to prevent SQL injections and XSS.
- CSRF protection.

## Notes

- To modify routes or configure other settings, refer to the router.php file.
- Any changes to the model must be synchronized with the database and the Model files.


