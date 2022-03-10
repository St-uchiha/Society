<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

verifConnect();

if(!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}


if (isset($_GET['id'])){
    
    $idArticle = $_GET['id'];
    
    $dbh = dbConnexion();

    // Je supprime les commentaires associé à l'article
    $sth1 = $dbh->prepare("DELETE FROM comment WHERE comment_post = :id");
    $sth1->bindValue('id', $idArticle, PDO::PARAM_INT);
    
    $sth1->execute();
    
    // Je supprime l'image associé à l'article
    $image = dbSelectOne($dbh, "SELECT post_image FROM posts WHERE post_id= :id", ['id' => $idArticle]);
    if($image['post_image'] != "silhouette.png") {
        unlink(UPLOADS_DIR. 'img_articles/' .$image['post_image']);
    }
    
    //Je supprime l'article en question
    $sth = $dbh->prepare("DELETE  FROM posts WHERE post_id = :id"); 
    
    $sth->bindValue('id', $idArticle, PDO::PARAM_INT);
    
    $sth->execute();

}






header("Location: dashboard.php");










