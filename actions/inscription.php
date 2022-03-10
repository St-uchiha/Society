<?php

session_start();

require('../lib/functions.php');
require('../config/config.php');

const LAYOUT = "inscription";

$errors = []; // Nous permettra de stocker la liste des erreurs commises dans le remplissage du formulaire
$valids = []; // Nous permettra de stocker le ou les messages de validation


$errorLastname = "";
$errorFirstname = "";
$errorEmail = "";  
$errorPassword = "";
$errorPasswordConfirm = "";
$errorsCG = ''; 
            
$addUser = [
                'addNom'                => '',
                'addPrenom'             => '',
                'addEmail'              => '',
                'addPassword'           => '',
                'addPassword_confirme'  => '',
                'addPicture'            => '',
                'conditionsGenerales'   => 0
            ];      
try{
    
    if(array_key_exists('user_mail', $_POST)){
        
        $addUser = [
                        'addNom'                => trim(strtoupper($_POST['user_lastname'])),
                        'addPrenom'             => trim(ucfirst($_POST['user_firstname'])),
                        'addEmail'              => trim(strtolower($_POST['user_mail'])),
                        'addPassword'           => trim($_POST['user_password']),
                        'addPassword_confirme'  => trim($_POST['user_password_confirm']),
                        'addPicture'            => 'silhouette.png',
                        'conditionsGenerales'   => (isset($_POST['conditionsGenerales']))?1:0
                    ];
            
        
        if($addUser['addNom'] == '') {
            $errors[] = "Veuillez remplir le champ 'Nom' !";
            $errorLastname = "Veuillez remplir le champ 'Nom' !";
        }
        
        if($addUser['addPrenom'] == ''){
            $errors[] = "Veuillez remplir le champ 'Prénom' !";
            $errorFirstname = "Veuillez remplir le champ 'Prénom' !";
        }
            
        if(!filter_var($addUser['addEmail'], FILTER_VALIDATE_EMAIL)){
            $errors[] =  'Veuillez renseigner un email valide SVP !'; 
            $errorEmail = "Veuillez renseigner un email valide SVP !"; 
        }
            
        if(empty($addUser['addPassword'])){
            $errors[] = "Veuillez renseigner votre mot de passe !";
            $errorPassword = "Veuillez renseigner votre mot de passe !";
        }
            
        if($addUser['addPassword'] != $addUser['addPassword_confirme']){
            $errors[] = "Vous n'avez pas confirmé correctement votre mot de passe !";
            $errorPasswordConfirm = "Vous n'avez pas confirmé correctement votre mot de passe !";
        }
            
        if($addUser['conditionsGenerales'] == 0){
            $errors[] = 'Vous devez valider les conditions générales.'; 
            $errorsCG = 'Vous devez valider les conditions générales.'; 
        }
            
        if(!empty($addUser['addPassword']) && $addUser['addPassword'] === $addUser['addPassword_confirme']) {
            $numberMinimalOfCaracters = 8;
            $uppercase = preg_match('@[A-Z]@', $addUser['addPassword']);
            $lowercase = preg_match('@[a-z]@', $addUser['addPassword']);
            $number    = preg_match('@[0-9]@', $addUser['addPassword']);
            $specialChars = preg_match('@[^\w]@', $addUser['addPassword']);
        
            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($addUser['addPassword']) < $numberMinimalOfCaracters) {
                $errorPassword = "Veuillez remplir le champ : « Mot de passe correctement » SVP !";
                $errorPassword = "→ Minimum $numberMinimalOfCaracters caractères !";
                $errorPassword = "→ Le mot de passe doit inclure au moins une lettre majuscule !";
                $errorPassword= "→ Le mot de passe doit inclure au moins une lettre minuscule !";
                $errorPassword = "→ Le mot de passe doit inclure au moins un chiffre !";
                $errorPassword= "→ Le mot de passe doit inclure au moins un caractère spécial !";
            }
        }    
        
        if(count($errors) == 0) {
            
            $dbh = dbConnexion();
            
            $sth = $dbh->prepare('SELECT * FROM users WHERE user_mail = :mail'); 
            $sth->bindValue('mail', $addUser['addEmail'], PDO::PARAM_STR);
            $sth->execute();
            $user_mail = $sth->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($user_mail)){
                $errors[] = 'Cette adresse e-mail existe déjà !'; 
            }
            
            if(count($errors) == 0) {
                // Enregistrer les données
                
                // uploader l'image si l'utilisateur en a mis une ? et changer dans le tableau l'avatar
                
                if(isset($_FILES['user_avatar']) &&  $_FILES['user_avatar']['name'] !== '' ){
                    $addUser['addPicture'] = uploadFile($_FILES['user_avatar'], $errors, UPLOADS_DIR.'avatars/');
                }
                
                $sth = $dbh->prepare("INSERT INTO users (user_lastname, 
                                                        user_firstname,
                                                        user_mail,
                                                        user_avatar,
                                                        user_password) 
                                        VALUES (:lastname, 
                                                :firstname, 
                                                :mail, 
                                                :avatar, 
                                                :password)"); 
                
                $sth->bindValue('lastname', $addUser['addNom'], PDO::PARAM_STR);
                $sth->bindValue('firstname', $addUser['addPrenom'], PDO::PARAM_STR);
                $sth->bindValue('mail', $addUser['addEmail'], PDO::PARAM_STR);
                $sth->bindValue('avatar', $addUser['addPicture'], PDO::PARAM_STR);
                
                $password = password_hash($addUser['addPassword'], PASSWORD_DEFAULT);
                
                $sth->bindValue('password', $password, PDO::PARAM_STR);                              
                                                
                $sth->execute();
                
                
                header('Location: connexion.php'); 
                
                $addUser = [
                                'addNom'                => '',
                                'addPrenom'             => '',
                                'addEmail'              => '',
                                'addPassword'           => '',
                                'addPassword_confirme'  => '',
                                'addPicture'            => ''
                            ];
                    
                     
                exit;
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