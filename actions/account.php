<?php
session_start();


require('../lib/functions.php');
require('../config/config.php');

const LAYOUT = "account";

$dbh = dbConnexion();

verifConnect();





if (isset($_GET['id'])) {
    // Le cas ou l'utilisateur connecté souhaite voir le profil d'un autre utilisateur

$idUser = $_GET['id'];


// $user_b contient toutes les infos de l'utilisateur en fonction de l'id
$sql_b = "SELECT * FROM users WHERE user_id = :id";

$user_b = dbSelectAll($dbh,$sql_b, ['id' => $_GET['id'] ] );


// $post_b contient tout les posts de l'utilisateur en fonction de son id
$sql_b = "SELECT * FROM posts where post_author = :id";

$post_b = dbSelectAll($dbh,$sql_b, ['id' => $_GET['id'] ] );

    
} elseif (isset($_GET['user_id'])) {
    // Le cas ou l'utilisateur souhaite voir son profil

// $user contient toutes les infos sur l'utilisateur connecté
$sql = "SELECT * FROM users WHERE user_id = :id";

$user = dbSelectAll($dbh,$sql, ['id' => $_SESSION['user']['id'] ] );



// $post contient tout les posts de l'utilisateur connecté
$sql2 = "SELECT * FROM posts where post_author = :id";

$post = dbSelectAll($dbh,$sql2, ['id' => $_SESSION['user']['id'] ] );
    
}






include('../views/'. LAYOUT . '.phtml');

