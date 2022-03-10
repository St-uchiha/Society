<?php 

session_start();


require('../lib/functions.php');
require('../config/config.php');


$errors = []; // Nous permettra de stocker la liste des erreurs commises dans le remplissage du formulaire
$valids = []; // Nous permettra de stocker le ou les messages de validation



$dbh = dbConnexion();


verifConnect();

const LAYOUT = "editPost";



if(isset ($_POST['post-update']) ){
         $addPost = [
                            'addTitle'                => '',
                            'addImage'                  =>'',
                            'addId'                 => '',
                            'addContent'                => '',
                            'addCategorie'             => '',
                        ];
                        
    try{
        
        if(array_key_exists('post_title', $_POST)){
            
            $addPost = [
                            'addTitle'                => trim(strtoupper($_POST['post_title'])),
                            'addImage'              => uploadFile($_FILES['post_image'], $errors, UPLOADS_DIR.'img_articles/'),
                            'addId'                 => $_POST['post_id'],
                            'addContent'           => htmlentities($_POST['post_content']),
                            'addCategorie'             => ($_POST['post_category']),
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
            
            /*if($addPost['addImage'] == ''){
                $addPost['addImage'] == $_POST['post_image'];
            }*/
                
                
            if($addPost['addContent'] == ''){
                $errors[] = "Votre article n'a aucun contenu !";
                $errorContent = "Votre article n'a aucun contenu !";
                
    
            }
            $numberMaxOfCaracters = 1000;
            $numberMinOfCaracters = 50;
            if (strlen($addPost['addContent']) < $numberMinOfCaracters ) {
                $errors[] = "-> Minimum $numberMinOfCaracters caractères !";
                $errorContent = "->Votre post doit contenir minimum $numberMinOfCaracters caractères !";
            }
            if (strlen($addPost['addContent']) > $numberMaxOfCaracters ) {
                $errors[] = "-> Maximum $numberMaxOfCaracters caractères !";
                $errorContent = "-> Votre post doit contenir maximum $numberMaxOfCaracters caractères !";
                
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
                                        UPDATE posts 
                                        set post_title = :title ,
                                            post_image = :image,
                                            post_content = :content,
                                            post_category = :category,
                                             WHERE post_id = :id"); 
                                                    
                    $sth->bindValue('title', $addPost['addTitle'], PDO::PARAM_STR);
                    $sth->bindValue('image', $addPost['addImage'], PDO::PARAM_STR);
                    $sth->bindValue('content', $addPost['addContent'], PDO::PARAM_STR);
                    
                    $sth->bindValue('category', $addPost['addCategorie'], PDO::PARAM_STR);
                    $sth->bindValue('id', $addPost['addId'], PDO::PARAM_INT);
                    
                    $sth->execute();
                    header("Location : myPost.php");
                    
                    $valids[] = "Votre article a bien été modifié.";
                    
                    
                    
                    
                    $addPost = [
                    'addTitle'                => '',
                    'addImage'                  =>'',
                    'addId'                 => '',
                    'addContent'                => '',
                    'addCategorie'             => '',
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
}


include('../views/'. LAYOUT . '.phtml');