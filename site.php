<?php


/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
require_once('mysql_config.php');
set_include_path("./src");
require_once("model/AnimalStorageMySQL.php");
session_start();
require_once("Router.php");
require_once("PathInfoRouter.php");



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


/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */
$storage = new AnimalStorageMySQL($connexion);
$router = new Router();
$router->main($storage);
?>
