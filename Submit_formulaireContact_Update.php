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

//echo "hello World";

//recuperation des données POST du formulaire

$postData = $_POST;

//verification des données saisies par l'utilisateur

//verification de l'existence inutile car utilisation de required dans la balise form

//nettoyage et enregistrement des données dans des variables
$nom = trim(strip_tags($postData['nom']));
$prenom = trim(strip_tags($postData['prenom']));
$email = trim(strip_tags($postData['email']));
$age = $postData['age'];
$user_id = $postData['user_id'];

//insertion des modifications dans la table users de la BDD

$requeteUpdate = 'UPDATE users SET nom = :nom, prenom = :prenom, email = :email, age = :age WHERE user_id = :user_id';
$updateContact = $mysqlClient->prepare($requeteUpdate);
$updateContact->execute([
    "nom"=> $nom,
    "prenom"=> $prenom,
    "email"=> $email,
    "age"=>$age,
    "user_id" => $user_id
]);

//echo "enregistrement effectué avec succès";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- Compatibilite navigateur -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- affichage responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- lien vers bootstrap css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Site - contact modifié</title>
    </head>
    <body>
        <b class="">Modification effectuée avec succès!</b>
        <p>
            Nom : <?php echo $postData['nom']; ?><br>
            Prénom : <?php echo $postData['prenom']; ?><br>
            Email : <?php echo $postData['email']; ?><br>
            Age : <?php echo $postData['age']." ans"; ?><br>
        </p>
    </body>
    <footer>
        <a href="array_contacts.php" class="btn btn-primary">Retour LISTE</a>
    </footer>
</html>