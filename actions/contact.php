<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

const LAYOUT = "contact";

$errors = []; // Nous permettra de stocker la liste des erreurs commises dans le remplissage du formulaire
$valids = []; // Nous permettra de stocker le ou les messages de validation


$errorObject = "";
$errorContent = "";
$errorAuthor = "";  


// Définir le nouveau fuseau horaire
date_default_timezone_set('Europe/Paris');
$time = time();
$dateTime = strftime('%Y-%m-%d %H:%M:%S', $time);
            
$addContact = [
                'addDate'                => '',
                'addObject'             => '',
                'addContent'              => '',
                'addAuthor'           => '',
            ];      
try{
    
    if(array_key_exists('user_lastname', $_POST)){
        
        $addContact = [
            
            'addDate'                => $dateTime,
            'addObject'             => test_input($_POST['contact_object']),
            'addContent'              => test_input($_POST['contact_content']),
            'addAuthor'           => $_SESSION['user']['id'],
            
            ];
    
            
        if($addContact['addAuthor'] == '') {
            $errors[] = "Veuillez remplir le champ 'Prénom(s)' !";
            $errorObject = "Veuillez remplir le champ 'Prénom(s)' !";
        }
        
        if($addContact['addObject'] == '') {
            $errors[] = "Veuillez remplir le champ 'Objet' !";
            $errorObject = "Veuillez remplir le champ 'Objet' !";
        }
        
        if($addContact['addContent'] == ''){
            $errors[] = "Veuillez remplir le champ 'Message' !";
            $errorContent = "Veuillez remplir le champ 'Message' !";
        }
            
        $numberMax = 100;
        $numberMin = 3;
        if (strlen($addContact['addObject']) < $numberMin ) {
            $errors[] = " L'objet doit contenir Minimum $numberMin caractères !";
            $errorObject = "L'objet de votre message doit contenir minimum $numberMin caractères !";
        }
        if (strlen($addContact['addObject']) > $numberMax ) {
            $errors[] = "L'objet de votre message doit conteir Maximum $numberMax caractères !";
            $errorObject = "L'objet de votre message doit contenir maximum $numberMax caractères !";
            
        }
            
        $numberMaxOfCaracters = 600;
        $numberMinOfCaracters = 5;
        if (strlen($addContact['addContent']) < $numberMinOfCaracters ) {
            $errors[] = "Le contenue de votre message doit contenir Minimum $numberMinOfCaracters caractères !";
            $errorContent = "Le contenue de votre message doit contenir minimum $numberMinOfCaracters caractères !";
        }
        if (strlen($addContact['addContent']) > $numberMaxOfCaracters ) {
            $errors[] = "Le contenue de votre message doti contenir Maximum $numberMaxOfCaracters caractères !";
            $errorContent = " Le contenue de votre message doit contenir maximum $numberMaxOfCaracters caractères !";
            
        }
        
        if(count($errors) == 0) {
            $dbh = dbConnexion();
            
            $sth = $dbh->prepare("INSERT INTO contact (contact_date, 
                                                    contact_object,
                                                    contact_content,
                                                    contact_author)
                                                    
                                    VALUES (:date, 
                                            :object, 
                                            :content, 
                                            :author)"); 
            
            $sth->bindValue('date', $addContact['addDate'], PDO::PARAM_STR);
            $sth->bindValue('object', $addContact['addObject'], PDO::PARAM_STR);
            $sth->bindValue('content', $addContact['addContent'], PDO::PARAM_STR);
            $sth->bindValue('author', $_SESSION['user']['id'], PDO::PARAM_INT);
            
            $sth->execute();
            
            $valids[] = "Votre message a bien été envoyé , Merci de nous avoir contacté !";
            
            
            $addContact = [
                'addDate'                => '',
                'addObject'             => '',
                'addContent'              => '',
                'addAuthor'           => $_SESSION['user']['id'],
            ];      
            
            
        }
    }
}


catch(PDOException $e)
{
    $view = 'error';
    $errors[] = 'Une erreur de connexion a eu lieu :'.$e->getMessage();
}


include('../views/'. LAYOUT . '.phtml');

