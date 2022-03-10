<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');


const LAYOUT = "addCategory";

verifAdmin();

$errors = []; // Nous permettra de stocker la liste des erreurs commises dans le remplissage du formulaire
$valids = []; // Nous permettra de stocker le ou les messages de validation


$dbh = dbConnexion();

$errorTitle = "";

        $addCat = [
                        'addTitle'                => '',
                        'addAuthor'                 => $_SESSION['user']['id'] ,
                    ];
   
    try{
        
        if (array_key_exists('category_name', $_POST)) {
            
            $addCat = [
                            'addTitle'                => test_input(ucfirst($_POST['category_name'])),
                            'addAuthor'                 => $_SESSION['user']['id'] ,
                        ];
            // var_dump($addCat);
                
            if($addCat['addTitle'] == ''){
                $errors[] = "Votre article n'a aucun contenu !";
                $errorContent = "Votre article n'a aucun contenu !";
                
            }
            $numberMaxOfCaracters = 30;
            $numberMinOfCaracters = 3;
            if (strlen($addCat['addTitle']) < $numberMinOfCaracters ) {
                $errors[] = "Votre Nom de categorie doit contenir Minimum $numberMinOfCaracters caractères !";
                $errorContent = "Votre Nom de categorie doit contenir  doit contenir minimum $numberMinOfCaracters caractères !";
            }
            if (strlen($addCat['addTitle']) > $numberMaxOfCaracters ) {
                $errors[] = "Votre Nom de categorie ne peut contenir plus de  $numberMaxOfCaracters caractères !";
                $errorContent = "Votre Nom de categorie ne peut contenir plus de  $numberMaxOfCaracters caractères!";
                
            }
    
            if(count($errors) == 0) {
                
                $dbh = dbConnexion();
                
                $sth = $dbh->prepare('SELECT * FROM category WHERE category_name= :title'); 
                $sth->bindValue('title', $addCat['addTitle'], PDO::PARAM_STR);
                $sth->execute();
                $post_title = $sth->fetch(PDO::FETCH_ASSOC);
                
                if(!empty($post_title)){
                    $errors[] = 'Une catégorie posséde déja ce titre'; 
                    $errorTitle = 'Une catégorie posséde déja ce titre'; 
                }
                
                if(count($errors) == 0) {
                    
                    $sth = $dbh->prepare("INSERT INTO category (category_name, category_author) VALUES (:title, :author)"); 
                                                    
                                                    
                    $sth->bindValue('title', $addCat['addTitle'], PDO::PARAM_STR);
                    $sth->bindValue('author', $_SESSION['user']['id'], PDO::PARAM_STR);
    
                    $sth->execute();
                    
                    $valids[] = "Votre Catégorie a bien été ajouté.";
                    
                    $addCat = [
                                'addTitle'                => '',
                                'addAuthor'                 => $_SESSION['user']['id'] ,
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




        




