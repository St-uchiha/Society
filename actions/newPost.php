<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

if(isset($_SESSION['user_id']))
{
	header("Location:index.php");
}

const LAYOUT = "newPost";

$dbh = dbConnexion();

// appel de la fonction qui sert à récupérer toutes les catégories
$sql = "SELECT * FROM category";
$categories = dbSelectAll($dbh,$sql);

// appel de la fonction qui retourne le nombre d'utilisateurs inscrits
$nbUsers  = countEntry($dbh, "users");

$errors = []; // Nous permettra de stocker la liste des erreurs commises dans le remplissage du formulaire
$valids = []; // Nous permettra de stocker le ou les messages de validation


$errorTitle = "";
$errorCategorie = "";
$errorImage = "";  
$errorContent= "";


// Définir le nouveau fuseau horaire
date_default_timezone_set('Europe/Paris');
$time = time();
$dateTime = strftime('%Y-%m-%d %H:%M:%S', $time);


$addPost = [
                'addDate'               => '',
                'addTitle'                => '',
                'addCategorie'             => '',
                'addImage'                  =>'',
                'addContent'                => '',
                'addCategorie'           => '',
                'addAuthor'                 => $_SESSION['user']['id'] ,

            ];
            
try{
    
    if(array_key_exists('post_title', $_POST)){
        
        $addPost = [
                        'addDate'               => $dateTime,
                        'addTitle'                => trim(strtoupper($_POST['post_title'])),
                        'addImage'              => uploadFile($_FILES['post_image'], $errors, UPLOADS_DIR.'img_articles/'),
                        'addContent'           => htmlentities($_POST['post_content']),
                        'addCategorie'             => ($_POST['post_category']),
                        'addAuthor'                 => $_SESSION['user']['id'] ,
                    ];
        
        // var_dump($addPost);
        if($addPost['addTitle'] == '') {
            $errors[] = "Veuillez remplir le champ 'Titre' !";
            $errorTitle = "Veuillez remplir le champ 'Titre' !";
        }
        
        if($addPost['addCategorie'] == ''){
            $errors[] = "Veuillez remplir le champ 'Catégorie' !";
            $errorCategorie = "Veuillez remplir le champ 'Catégorie' !";
        }
        
        if($addPost['addImage'] == ''){
            $errors[] = "Veuillez choisir une image pour votre article !";
            $errorImage = "Veuillez choisir une image pour votre article !";
        }
            
            
        if($addPost['addContent'] == ''){
            $errors[] = "Votre article n'a aucun contenu !";
            $errorContent = "Votre article n'a aucun contenu !";
            

        }
        $numberMaxOfCaracters = 1000;
        $numberMinOfCaracters = 50;
        if (strlen($addPost['addContent']) < $numberMinOfCaracters ) {
            $errors[] = "Votre article ne peut contenir moins de $numberMinOfCaracters caractères !";
            $errorContent = "Votre article doit contenir minimum $numberMinOfCaracters caractères !";
        }
        if (strlen($addPost['addContent']) > $numberMaxOfCaracters ) {
            $errors[] = "-> Votre article ne peut contenir plus de $numberMaxOfCaracters caractères !";
            $errorContent = "Votre article doit contenir maximum $numberMaxOfCaracters caractères !";
            
        }

            
  
        
        if(count($errors) == 0) {
            
            $dbh = dbConnexion();
            
            $sth = $dbh->prepare('SELECT * FROM posts WHERE post_title = :title'); 
            $sth->bindValue('title', $addPost['addTitle'], PDO::PARAM_STR);
            $sth->execute();
            $post_title = $sth->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($post_title)){
                $errors[] = 'Un article possède déja ce titre'; 
                $errorTitle = 'Un article possède déja ce titre'; 
            }
            
            if(count($errors) == 0) {
                
                $sth = $dbh->prepare("
                                    INSERT INTO posts (post_date, 
                                                        post_title,
                                                        post_image,
                                                        post_content,
                                                        post_author,
                                                        post_category) 
                                        VALUES (:date, 
                                                :title, 
                                                :image, 
                                                :content, 
                                                :author,
                                                :category)"); 
                                                
                $sth->bindValue('date', $addPost['addDate'], PDO::PARAM_STR);
                
                                                
                $sth->bindValue('title', $addPost['addTitle'], PDO::PARAM_STR);
                $sth->bindValue('image', $addPost['addImage'], PDO::PARAM_STR);
                $sth->bindValue('content', $addPost['addContent'], PDO::PARAM_STR);
                $sth->bindValue('author', $_SESSION['user']['id'], PDO::PARAM_STR);
                $sth->bindValue('category', $addPost['addCategorie'], PDO::PARAM_STR);
                
                $sth->execute();
                
                $valids[] = "Votre article a bien été enregistré.";
                
                $addPost = 
                [
                    'addDate'               => '',
                    'addTitle'                => '',
                    'addCategorie'             => '',
                    'addImage'                  =>'',
                    'addContent'                => '',
                    'addCategorie'           => '',
                    'addAuthor'                 => '' ,
                ];
                
            }
        }
    }
}

catch(PDOException $e)
{
    $view = 'error';
    $errors[] = 'Une erreur de connexion a eu lieu :'.$e->getMessage();
}


include('../views/'. LAYOUT . '.phtml');


