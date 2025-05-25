<?php
//connexion à la base de donnée PHPMyadmin via PDO
try {
    $mysqlClient = new PDO (
        'mysql:host=localhost;dbname=contacts;port=3306;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
    );
} catch(Exception $e) {
    die("Erreur : ". $e);
}

?>