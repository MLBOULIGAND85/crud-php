<?php
function selectUtilisateurs($age = '') {
    global $mysqlClient;
  
    $requete = 'SELECT * FROM users ';
    if ( $age != '') {
        $requete .= 'WHERE age < '.$age;
    }
    $requete .= ' ORDER BY nom ASC, prenom ASC';
    $usersSQL = $mysqlClient->prepare($requete);
    $usersSQL->execute();
    $users = $usersSQL->fetchAll();

    return $users;
}

function deleteContact() {

}

function remplirFormulaire() {
    //recuperation des elements de la requete sur la table users pour l'id envoyé par url
$requeteSqlId = 'SELECT * FROM users WHERE user_id = :id';
$usersIdStatement = $mysqlClient->prepare($requeteSqlId);
$usersIdStatement->bindParam(':id', $id, PDO::PARAM_INT); //permet de comparer l'ID avec ceux de la table
$usersIdStatement ->execute();
$usersId = $usersIdStatement->fetch(PDO::FETCH_ASSOC); // crée un tableau associatif simple 

return $usersId;
}

function recupererIdUrl() {
    //verification que l'id existe et a une valeur
    if(isset($_GET['id']) && !empty($_GET['id']))
    {
        //recuperation de l'id transmis par l'url
        return $_GET['id']; 
        //$id = $_GET['id'];
    }
    return null;
}

?>