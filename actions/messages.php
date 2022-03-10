<?php
session_start();


require('../lib/functions.php');
require('../config/config.php');

verifAdmin();


const LAYOUT = "messages";



$dbh = dbConnexion();


$sql = "SELECT contact.contact_id, contact.contact_date, contact.contact_content, contact.contact_object , users.user_firstname
FROM contact
INNER JOIN users
ON contact.contact_author = users.user_id 
ORDER BY contact_id DESC";
$all_msg = dbSelectAll($dbh,$sql);


// var_dump($all_msg);




                    
include('../views/'. LAYOUT . '.phtml');




?>
