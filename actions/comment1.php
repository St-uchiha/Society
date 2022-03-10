<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

$dbh = dbConnexion();

verifConnect();

date_default_timezone_set('Europe/Paris');
$time = time();
$dateTime = strftime('%Y-%m-%d %H:%M:%S', $time);

$addComment = [
        'addDate'               => $dateTime,
        'addPostId'             => $_POST['comment_post'],
        'addAuthor'                 => $_SESSION['user']['id'] ,
        'addContent'                => trim($_POST['comment_content']),
    ];


    

$post = $_POST['comment_post'];
    
if($addComment['addContent'] == ''){
    $errors[] = "Votre commentaire n'a aucun contenu !";
    $errorContent = "Votre commentaire n'a aucun contenu !";
    
}
$numberMaxOfCaracters = 500;
$numberMinOfCaracters = 20;
if (strlen($addComment['addContent']) < $numberMinOfCaracters ) {
    $errors[] = "-> Minimum $numberMinOfCaracters caractères !";
    $errorContent = "->Votre commentaire doit contenir minimum $numberMinOfCaracters caractères !";
}
if (strlen($addComment['addContent']) > $numberMaxOfCaracters ) {
    $errors[] = "-> Maximum $numberMaxOfCaracters caractères !";
    $errorContent = "-> Votre commentaire doit contenir maximum $numberMaxOfCaracters caractères !";
    
}


    
$sth = $dbh->prepare("
                    INSERT INTO comment ( 
                                        comment_date,
                                        comment_author,
                                        comment_post,
                                        comment_content)
                                        
                        VALUES (:date, 
                                :author, 
                                :postId,
                                :content)"); 
                                
$sth->bindValue('date', $addComment['addDate']);

$sth->bindValue('author', $_SESSION['user']['id'], PDO::PARAM_INT);
$sth->bindValue('postId', $addComment['addPostId'], PDO::PARAM_INT);

$sth->bindValue('content', $addComment['addContent'], PDO::PARAM_STR);

$sth->execute();
    
header("Location: singlePost.php?id=$post ");


