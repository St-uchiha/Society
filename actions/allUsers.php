<?php
session_start();

require('../lib/functions.php');
require('../config/config.php');

verifAdmin();

const LAYOUT = "allUsers";

$dbh = dbConnexion();

// $nbUsers contient le nombre exact d'utilisateur inscrit
$nbUsers  = countEntry($dbh, "users");


// $all_users contient tout les utilisateurs trié par rôle 
$sql = "SELECT * FROM users ORDER BY user_role ASC";
$all_users = dbSelectAll($dbh,$sql);




include('../views/'. LAYOUT . '.phtml');


?>
