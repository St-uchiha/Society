<?php

session_start();


require('../lib/functions.php');
require('../config/config.php');

const LAYOUT = "viewMessage";

$dbh = dbConnexion();


//$article récupère toutes les infos sur le post choisi en fonction de l'id
$sql = "SELECT contact.contact_id, contact.contact_date, contact.contact_content, contact.contact_object , users.user_firstname
FROM contact
INNER JOIN users
ON contact.contact_author = users.user_id 
WHERE contact_id = :id"; 
$message = dbSelectOne($dbh,$sql, ['id' => $_GET['id'] ]);

// var_dump($message);






include('../views/'. LAYOUT . '.phtml');

