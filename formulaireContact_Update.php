<?php

//verification que l'id existe et a une valeur
if(isset($_GET['id']) && !empty($_GET['id']))
{
    //recuperation de l'id transmis par l'url
    $id = $_GET['id'];
}

// connexion à la base de donnees SQL
try {
    $mysqlClient = new PDO('mysql:host=localhost;dbname=contacts;port=3306;charset=utf8',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
);
} catch(Exception $e) {
    die("Erreur : ".$e);
}

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
        <meta charset="utf-8">
        <!-- Compatibilite navigateur -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- affichage responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- lien vers bootstrap css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Site - Modification de contact</title>
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
                    <form class="" action="Submit_formulaireContact_Update.php" method="POST">
                        <legend>Formulaire de contact - Modification</legend>
                        <!-- enregistrement de l'id récuperé dans l'url -->
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($id); ?>">
                        <div class="mb-3">
                            <label for="nom" class="">Nom : <br></label>
                            <input type="text" class="" id="nom" name="nom" placeholder="ex: DUPONT" value="<?php echo $nom; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="">Prénom : <br></label>
                            <input type="text" class="" id="prenom" name="prenom" value="<?php echo $prenom; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="">Email : <br></label>
                            <input type="email" class="" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="">Age : <br></label>
                            <input type="number" class="" id="age" name="age" min="0" value="<?php echo $age; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>
            </section>
            <section>
            </section>
        </main>
        <aside>
        </aside>
        <footer>
        </footer>
    </body>
</html>