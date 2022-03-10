<?php

session_start();

require('lib/bdd.php');
require('lib/functions.php');
require('config/config.php');


const LAYOUT = "home";


$dbh = dbConnexion();

$login = [
            'logEmail'      => '',
            'logPassword'   => '',
            'conditionsGenerales' => 0
        ];

// appel de la fonction qui retourne le nombre d'utilisateurs inscrits
$nbUsers  = countEntry($dbh, "users");


// appel de la fonction qui sert à récupérer le nombre d'articles
$nbArticles = dbCountPosts();



//  sert à récupérer toutes les catégories
$sql = "SELECT * FROM category";
$categories = dbSelectAll($dbh,$sql);


//  sert à récupérer le dernier utilisateur
$sql ="SELECT * FROM users ORDER BY user_id DESC LIMIT 1";
$last_user = dbSelectOne($dbh,$sql);

// Je gère l'affichage des articles + toutes les infos les concernant avec ma pagination

// On détermine sur quelle page on se trouve
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

// On détermine le nombre d'articles par page
$parPage = 2;

// On calcule le nombre de pages total
$pages = ceil($nbArticles / $parPage);

// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;

$sql = "SELECT posts.*, users.user_firstname, category.category_name
FROM posts
JOIN users
    ON users.user_id = posts.post_author
JOIN category
    ON category.category_id = posts.post_category
ORDER BY post_date DESC LIMIT :premier, :parpage";

// On prépare la requête
$query = $dbh->prepare($sql);

$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

// On exécute
$query->execute();

// On récupère les valeurs 
$articles = $query->fetchAll(PDO::FETCH_ASSOC);




include('views/'. LAYOUT . '.phtml');




        




