<?php

//connexion a la base de donnees
try {
    $mysqlClient = new PDO('mysql:host=localhost;dbname=contacts;port=3306;charset=utf8',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION],
    );
} catch(Exception $e) {
    die("Erreur : ".$e);
}

//recuperation des données POST du formulaire

$postData = $_POST;

//on verifie si user_id existe et n'est pas vide dans les données récupérées du formulaire
if(isset($postData['user_id'])&& !empty($postData['user_id'])) {
    $user_id = $postData['user_id']; //initialisation de la variable user_id
    //mise à jour des modifications dans la table users de la BDD
    $requeteUpdate = 'DELETE FROM users WHERE user_id = :user_id';
    $updateContact = $mysqlClient->prepare($requeteUpdate);
    $updateContact->execute([
    "user_id" => $user_id
]);

header('Location: array_contacts.php?msg=suppr');
}

?>
