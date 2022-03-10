<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

verifConnect();

if(!isset($_GET['id'])) {
    header("Location: allUsers.php");
    exit();
}



if (isset($_GET['id'])) {
    $idUser = $_GET['id'];
        
    $dbh = dbConnexion();

    $sth = $dbh->prepare("DELETE FROM users WHERE user_id = :id");


    $sth->bindValue('id', $idUser, PDO::PARAM_STR);

    $sth->execute();
    echo "<script>alert('Suppression effectué')</script>";
    
} 
header("Location: allUsers.php");


