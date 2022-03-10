<?php
session_start();


require('../lib/functions.php');
require('../config/config.php');

verifAdmin();


const LAYOUT = "dashboardAdmin";

$dbh = dbConnexion();





// appel de la fonction qui sert à récupérer toutes les catégories
$sql = "SELECT * FROM category";
$categories = dbSelectAll($dbh,$sql);


$nbUsers = countEntry($dbh, "users");
$nbPosts  = countEntry($dbh, "posts");





$sql = "SELECT posts.*, users.user_lastname, category.category_name
FROM posts
JOIN users
    ON users.user_id = posts.post_author
JOIN category
ON category.category_id = posts.post_category
ORDER BY post_id ASC";


// Le lancement en php de ma requête
$sth = $dbh->query($sql);
  
// Je l'execute  
$sth->execute();

// Je met le résultat dans une variable
$articles = $sth->fetchAll();




                    
include('../views/'. LAYOUT . '.phtml');




?>
