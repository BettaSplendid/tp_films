<?php
require_once("config.php");


//CONNEXION BDD
$domaine = "http://localhost";
$username = "root";
$password = "";
$host = "localhost"; //localhost 
$dbn = "accounts_movies_tp";

$option = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$dsn = "mysql:host=$host;dbname=$dbn;charset=utf8";

try {
    $dtbs = new PDO($dsn, $username, $password, $option);
} catch (PDOException $error) {
    $message = $error->getMessage();
    var_dump($message);
    die("Erreur lors de ma connexion PDO");
}
echo "<br>Connected successfully with variables method<br>";


