<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

verifAdmin();

$dbh = dbConnexion();

if(isset($_GET['id'])) {
    
    $idUser = $_GET['id'];
    
    $sth = $dbh->prepare("Update users SET user_role = 'admin' WHERE user_id = :id"); 
    
    $sth->bindValue('id', $idUser, PDO::PARAM_INT);
    
    $sth->execute();
    
    
        
    
    
}else (isset($_GET['mail'])); {
    
    
    $mailUser = $_GET['mail'];

    
    $sth = $dbh->prepare("Update users SET user_role = 'user' WHERE user_mail = :mail"); 
    
    $sth->bindValue('mail', $mailUser, PDO::PARAM_STR);
    
    $sth->execute();
    
    
}




header("Location: allUsers.php");






    




