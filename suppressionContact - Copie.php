<?php
require_once(__DIR__.'/fonctions.php');

//verification que l'id transmis par url existe et a une valeur
$id = recupererIdUrl();

// connexion à la base de donnees SQL
require_once(__DIR__.'/config/configPDO.php');

//recuperation des elements de la requete sur la table users pour l'id envoyé par url
$requeteSqlId = 'SELECT * FROM users WHERE user_id = :id';
$usersIdStatement = $mysqlClient->prepare($requeteSqlId);
$usersIdStatement->bindParam(':id', $id, PDO::PARAM_INT); //permet de comparer l'ID avec ceux de la table
$usersIdStatement ->execute();
$usersId = $usersIdStatement->fetch(PDO::FETCH_ASSOC); // crée un tableau associatif simple 

if(!empty($usersId)) {
    echo "<i>Compte déjà existant</i>";
    $nom = $usersId['nom'] ?? '';
    $prenom = $usersId['prenom'] ?? '';
    $email = $usersId['email'] ?? '';
    $age = $usersId['age'] ?? '';
} else {
    $nom = '';
    $prenom = '';
    $email = '';
    $age = '';
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <?php require_once(__DIR__.'/headHTML.php'); ?>
        <title>Site - Formulaire Contact</title>
    </head>
    <body>
        <header>
            <nav>
                <a class="btn btn-primary" href="array_contacts.php">Retour LISTE</a>
            </nav>
        </header>
        <main>
            <section>
                <div class="container">
                    <form class="" action="Submit_suppressionContact.php" method="POST">
                        <legend><strong>Etes-vous sûr(e) de vouloir supprimer ce contact?</strong></legend>
                        <!-- si modif utilisateur existant : input caché pour enregistrement de l'id récuperé dans l'url -->
                         <?php if($id) : ?>
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($id); ?>">
                        <?php endif; ?>
                        <div class="mb-3">
                            <p>
                                Nom : <?= htmlspecialchars($nom); ?><br>
                                Prénom : <?= htmlspecialchars($prenom); ?><br>
                                Email : <?= htmlspecialchars($email); ?><br>
                                Age : <?= htmlspecialchars($age); ?><br>
                            </p>
                        </div>
                        <button type="submit" class="btn btn-danger">Valider</button>
                        <i>(! cette action sera IRREVERSIBLE !)</i>
                    </form>
                </div>
            </section>
        <?php require_once(__DIR__.'/footerHTML.php'); ?>
    </body>
</html>