<?php
session_start();


require('../lib/functions.php');
require('../config/config.php');

const LAYOUT = "connexion"; // Référence à une vue dans laquelle il y a notre formulaire de connexion ( mail + PDP )

$errors = [];

$login = [
            'logEmail'      => '',
            'logPassword'   => '',
            'conditionsGenerales' => 0,
        ];
        
try{
    if(array_key_exists('user_mail', $_POST)){
        
        $login = [
                    'logEmail'      => test_input(strtolower($_POST['user_mail'])),
                    'logPassword'   => $_POST['user_password'],
                    'conditionsGenerales' => (isset($_POST['conditionsGenerales']))?1:0
                ];
        
        // Vérifier le remplissage du formulaire
        if($login['logEmail'] == '') 
            $errors[] = "Veuillez remplir le champ 'Email' !";
            
        if(empty($login['logPassword']))
            $errors[] = "Veuillez renseigner votre mot de passe !";
        
        if(!filter_var($login['logEmail'], FILTER_VALIDATE_EMAIL))
            $errors[] =  'Veuillez renseigner un email valide SVP !';  
            
        if($login['conditionsGenerales'] == 0)
            $errors[] = 'Vous devez valider les conditions générales.';    
            
        if(!empty($login['logPassword'])) {
            $numberMinimalOfCaracters = 8;
            $uppercase = preg_match('@[A-Z]@', $login['logPassword']);
            $lowercase = preg_match('@[a-z]@', $login['logPassword']);
            $number    = preg_match('@[0-9]@', $login['logPassword']);
            $specialChars = preg_match('@[^\w]@', $login['logPassword']);
        
            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($login['logPassword']) < $numberMinimalOfCaracters) {
                $errors[] = "Veuillez remplir le champ : « Mot de passe correctement » SVP !";
                $errors[] = "→ Minimum $numberMinimalOfCaracters caractères !";
                $errors[] = "→ Le mot de passe doit inclure au moins une lettre majuscule !";
                $errors[] = "→ Le mot de passe doit inclure au moins une lettre minuscule !";
                $errors[] = "→ Le mot de passe doit inclure au moins un chiffre !";
                $errors[] = "→ Le mot de passe doit inclure au moins un caractère spécial !";
            }
        }    
    
        if(count($errors) == 0) {
            
            // Vérifier si un utilisateur existe par rapport à l'email
            $dbh = dbConnexion();
            $sth = $dbh->prepare('SELECT * FROM users WHERE user_mail = :mail'); 
            $sth->bindValue('mail', $login['logEmail'], PDO::PARAM_STR);
            $sth->execute();
            $user_mail = $sth->fetch(PDO::FETCH_ASSOC);
            
            if(empty($user_mail)){
                $errors[] = "Auncun compte n'est lié à cette adresse mail"; 
            }
            
            if(count($errors) == 0) {
                
                // Vérifier le mot de passe par rapport à celui de BDD
                if (password_verify($login['logPassword'], $user_mail['user_password'])) {
                    
                    if($user_mail['user_valid'] == 0) {
                        $errors[] = 'Votre compte n\'a pas encore été validé par l\'administrateur du site.';
                    }else if($user_mail['user_valid'] == 2){
                        $errors[] = "Désolé, à force de faire l'idiot, tu as été suspendu !";
                    }else {
                        
                        $_SESSION['connected'] = true;
                        $_SESSION['user'] = [
                                                'firstName' => $user_mail['user_firstname'],
                                                'lastName'  => $user_mail['user_lastname'],
                                                'email'     => $user_mail['user_mail'],
                                                'avatar'    => $user_mail['user_avatar'],
                                                'role'      => $user_mail['user_role'],
                                                'valid'     => $user_mail['user_valid'],
                                                'id'        => $user_mail['user_id']
                                            ];
                        header('Location: dashboard.php');
                        if($_SESSION['user']['role'] !== "admin"){
                            header('Location: ../index.php');
                        }
                        exit;
                    }
                }else {
                    $errors[] = 'Merci de vérifier vos identifiants !';
                }
            }
        }
    }
}
catch(PDOException $e)
{
    $wiew = 'error';
}

include('../views/'. LAYOUT . '.phtml');
    