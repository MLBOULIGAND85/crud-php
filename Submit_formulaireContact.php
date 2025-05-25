<?php

//connexion a la base de donnees
require_once(__DIR__.'/config/configPDO.php');

//recuperation des données POST du formulaire
$postData = $_POST;

//verification des données saisies par l'utilisateur

//verification de l'existence inutile car utilisation de required dans la balise form

//nettoyage et enregistrement des données dans des variables
$nom = trim(strip_tags($postData['nom']));
$prenom = trim(strip_tags($postData['prenom']));
$email = trim(strip_tags($postData['email']));
$age = $postData['age'];

//on verifie si user_id existe et n'est pas vide dans les données récupérées du formulaire
if(isset($postData['user_id'])&& !empty($postData['user_id'])) 
{
    $user_id = $postData['user_id']; //initialisation de la variable user_id

    //mise à jour des modifications dans la table users de la BDD
    $requeteUpdate = 'UPDATE users SET nom = :nom, prenom = :prenom, email = :email, age = :age WHERE user_id = :user_id';
    $updateContact = $mysqlClient->prepare($requeteUpdate);
    $updateContact->execute(
        [
            "nom"=> $nom,
            "prenom"=> $prenom,
            "email"=> $email,
            "age"=>$age,
            "user_id" => $user_id
        ]
    );

    $message="Contact modifié avec succès";
    $alertClass="alert-success";

} else {
    //sinon : verification si un contact avec meme nom prenom et email existe déjà dans la table users de la BDD
    $requeteVerifContact = 'SELECT COUNT(*) FROM users WHERE nom= :nom AND prenom= :prenom AND email= :email';
    $verifContact = $mysqlClient->prepare($requeteVerifContact);
    $verifContact->execute(
        [
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email

        ]
    );
    $contactExist = $verifContact->fetchcolumn();

    //si contact existe déjà message d'erreur
    if($contactExist > 0) {
        $message = "Création impossible : un contact avec les mêmes nom, prenom, et adresse email existe déjà" ;
        $alertClass="alert-warning";
        $erreur = true;
    } else {

    //sinon : insertion des donnees dans la table users de la BDD
    $requeteInsert = 'INSERT INTO users(nom,prenom,email,age)VALUES(:nom,:prenom,:email,:age)';
    $insertContact = $mysqlClient->prepare($requeteInsert);
    $insertContact->execute(
        [
            "nom"=> $nom,
            "prenom"=> $prenom,
            "email"=> $email,
            "age"=>$age,
        ]
);

$message="Nouveau contact créé avec succès";
$alertClass="alert-success";
$erreur=false;
    }
}

?>

<!-- fin php - début html -->

<!DOCTYPE html>
<html>
    <head>
        <?php require_once(__DIR__.'/headHTML.php'); ?>
        <title>Site - Information enregistrée</title>
    </head>
    <body>
        <header>
            <a href="array_contacts.php" class="btn btn-primary">Retour LISTE</a>
        </header>
            <div class="alert <?= $alertClass ; ?>" role="alert">
            <?= $message ; ?>
        </div>
        <div class="container">
            Nom : <?= $postData['nom']; ?><br>
            Prénom : <?= $postData['prenom']; ?><br>
            Email : <?= $postData['email']; ?><br>
            Age : <?= $postData['age']." ans"; ?><br>
        </div>
    </body>
    <?php require_once(__DIR__.'/footerHTML.php'); ?>
</html>
