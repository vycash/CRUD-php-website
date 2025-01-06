<?php 
header('Access-Control-Allow-Origin: https://ensweb.unicaen.fr');
header('Access-Control-Allow-Headers: Authorization');
$currentUser = posix_getpwuid(posix_getuid())['name']; // pour récupérer l'utilisateur courant
require_once('/users/'.$currentUser.'/private/mysql_config.php'); // recupérer le fichier mysql_config qui définit les constantes de connexion à mysql
set_include_path("./src");
require_once("model/AnimalStorageMySQL.php");
require_once("ApiRouter.php");

$connexion = null;
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

// Connexion à la base de données
try {
    $dsn = MYSQL_HOST . MYSQL_PORT . MYSQL_DB;
    //echo "<script>alert('connexion a la bd établie')</script>";
    $connexion = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD, $options);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception("Connexion à MySQL impossible : ".$e->getMessage());
}


$storage = new AnimalStorageMySQL($connexion); // Connexion à la base de données
$router = new ApiRouter();
$router->main($storage);
?>
