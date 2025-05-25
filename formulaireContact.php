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

//initialisation des variables : remplissage des champs du formulaire si modif contact existant
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
                    <form class="" action="Submit_formulaireContact.php" method="POST">

                        <legend>Formulaire de contact</legend>

                        <!-- si modif utilisateur existant : input caché pour enregistrement de l'id récuperé dans l'url -->
                         <?php if($id) : ?>
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($id); ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="nom" class="">Nom : <br></label>
                            <input type="text" class="" id="nom" name="nom" placeholder="ex: DUPONT" value="<?= htmlspecialchars($nom); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="">Prénom : <br></label>
                            <input type="text" class="" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="">Email : <br></label>
                            <input type="email" class="" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="age" class="">Age : <br></label>
                            <input type="number" class="" id="age" name="age" min="0" max="110" value="<?= htmlspecialchars($age); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Valider</button>

                    </form>
                </div>
            </section>
        </main>
        <aside>
        </aside>
        <?php require_once(__DIR__.'/footerHTML.php'); ?>
    </body>
</html>