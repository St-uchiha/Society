<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

const LAYOUT = "singlePost";

$dbh = dbConnexion();

$errorContent= "";

$nbUsers  = countEntry($dbh, "users");

$login = [
            'logEmail'      => '',
            'logPassword'   => '',
            'conditionsGenerales' => 0
        ];

//$article récupère toutes les infos sur le post choisi en fonction de l'id
$sql = "SELECT posts.*, users.user_firstname, category.category_name
 FROM posts 
 JOIN users 
    ON users.user_id = posts.post_author
 JOIN category 
 ON category.category_id = posts.post_category
  WHERE post_id = :id"; 
$article = dbSelectOne($dbh,$sql, ['id' => $_GET['id'] ]);


// $categories contient toutes les catégories
$sql = "SELECT * FROM category";
$categories = dbSelectAll($dbh,$sql);


// $comment contient tous les commentaires associé au post actuel 
$sql = "SELECT comment.*, users.user_firstname
 FROM comment
 JOIN users 
    ON users.user_id = comment.comment_author
  WHERE comment_post = :id ORDER BY comment_date DESC"; 
$comment = dbSelectAll($dbh,$sql,['id' => $_GET['id'] ]);



//  sert à récupérer le dernier utilisateur
$sql ="SELECT * FROM users ORDER BY user_id DESC LIMIT 1";
$last_user = dbSelectOne($dbh,$sql);




include('../views/'. LAYOUT . '.phtml');

