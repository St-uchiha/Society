<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');


const LAYOUT = "errorPage";

$dbh = dbConnexion();

$login = [
            'logEmail'      => '',
            'logPassword'   => '',
            'conditionsGenerales' => 0
        ];

// appel de la fonction qui retourne le nombre d'utilisateurs inscrits
$nbUsers  = countEntry($dbh, "users");

//  sert à récupérer le dernier utilisateur
$sql ="SELECT * FROM users ORDER BY user_id DESC LIMIT 1";
$last_user = dbSelectOne($dbh,$sql);

//  sert à récupérer toutes les catégories
$sql = "SELECT * FROM category";
$categories = dbSelectAll($dbh,$sql);





include('../views/'. LAYOUT . '.phtml');




        




