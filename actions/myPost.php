<?php
session_start();


require('../lib/functions.php');
require('../config/config.php');

verifConnect();


const LAYOUT = "myPost";

$dbh = dbConnexion();


// var_dump($_SESSION['user']['id']);

$user = $_SESSION['user']['id'];

// var_dump($user);


$sql = "SELECT posts.*, users.user_lastname, category.category_name
FROM posts
JOIN users
    ON users.user_id = posts.post_author
JOIN category
ON category.category_id = posts.post_category
WHERE post_author = $user";

// Le lancement en php de ma requête
$sth = $dbh->query($sql);
  
// Je l'execute  
$sth->execute();

// Je met le résultat dans une variable
$Posts = $sth->fetchAll();





// appel de la fonction qui sert à récupérer toutes les catégories
$sql = "SELECT * FROM category";
$categories = dbSelectAll($dbh,$sql);


$nbUsers = countEntry($dbh, "users");
$nbPosts  = countEntry($dbh, "posts");



                    
include('../views/'. LAYOUT . '.phtml');




?>
