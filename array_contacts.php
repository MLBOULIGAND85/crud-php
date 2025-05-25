<?php

//connexion à la base de donnée
require_once(__DIR__.'/config/configPDO.php');

//appel aux fonctions
require_once('fonctions.php');

//declaration message de confirmation
$message='';

//Requetes sur la table SQL de la BDD

//requete pour affichage tous les utilisateurs
$users = selectUtilisateurs(''); 

//requete pour affichage des utilisateurs mineurs
$usersMineurs = selectUtilisateurs(18); 

//validation message de confirmation
if(isset($_GET['msg']) && $_GET['msg']=='suppr')
{
    $message="Le contact a bien été supprimé";
}
?>

<!-- fin php - debut html -->

<!DOCTYPE html>
    <html lang="fr">
        <head>
            <?php require_once(__DIR__.'/headHTML.php'); ?>
            <title>CONTACTS</title>
        </head>

        <body>
            <header>
                <nav>
                    <a href="formulaireContact.php"class="btn btn-primary">Création nouveau contact</a>
                </nav>
            </header>

            <main>
            <!-- affichage de tous les utilisateurs -->
                <div class="container">

                    <!-- message de confirmation de delete -->
                    <?php if ($message!='') : ?>
                        <div class="alert alert-success"><?= $message ?></div>
                    <?php endif; ?>

                    <h3>
                        <strong>LISTE DES CONTACTS</strong>
                    </h3>

                    <ol>
                        <?php foreach($users as $user) : ?>
                            <li>
                                <?php echo $user['nom'].' '.$user['prenom'].' '.$user['email'].' ('.$user['age'].' ans)'; ?><br>
                                
                                <!-- lien vers formulaireContact pour update  -->
                                <a class="btn btn-primary" href="formulaireContact.php?id=<?php echo $user['user_id']; ?>">Modifier</a>
                                
                                <!-- lien vers formulaireContact pour delete -->
                                <a class="btn btn-danger" href="suppressionContact.php?id=<?php echo $user['user_id']; ?>">Supprimer</a>
                            </li>
                            <br>   
                        <?php endforeach; ?>
                    </ol>
                </div>

                <!-- affichage des utilisateurs mineurs -->
                <div class="container">
                    <p><strong>Les personnes mineurs ne sont pas autorisées à accéder à la vente en ligne</strong></p>
                    <h5>
                        Liste des contacts mineurs
                    </h5>
                    <ul>
                        <?php foreach($usersMineurs as $userMineur) : ?>
                            <li>
                                <i><?php echo $userMineur['nom'].' '.$userMineur['prenom'].' '; ?></i>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </main>
        </body>
        <?php require_once(__DIR__.'/footerHTML.php') ?>
    </html>