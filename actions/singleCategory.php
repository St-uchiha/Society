<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

const LAYOUT = "singleCategory";

$dbh = dbConnexion();

$login = [
            'logEmail'      => '',
            'logPassword'   => '',
            'conditionsGenerales' => 0
        ];


// $categories contient toutes les catégories
$sql = "SELECT * FROM category";
$categories = dbSelectAll($dbh,$sql);



$posts = dbSelectPostc();




// appel de la fonction qui retourne le nombre d'utilisateurs inscrits
$nbUsers  = countEntry($dbh, "users");

//  sert à récupérer le dernier utilisateur
$sql ="SELECT * FROM users ORDER BY user_id DESC LIMIT 1";
$last_user = dbSelectOne($dbh,$sql);





include('../views/'. LAYOUT . '.phtml');

?>
