<?php

    /** Notre fichier "functions.php" contient toutes nos fonctions dites "génériques"
     * Ce sont donc des fonctions qui nous seront utiles partout dans notre site.
     * Elles pouront être appellée depuis n'importe quel fichier .php dès l'instant 
     * où ce dernier require notre fichier.
    */
    
    
    /** Fonction qui vérifie si l'utilisateur est connecté et s'il est admin
     * @param - void
     * 
     * @return - void
     */ 
    function verifAdmin() {
        if($_SESSION['user']['role'] != "admin") {
            echo "<script>alert('Vous devez être connecté pour accéder à cette page')</script>";
            
            header("Location: ../index.php");
            exit();
        }
    }
    
    function verifConnect() {
        if(!isset($_SESSION['user']['id'])) {
            
            header("Location: ../index.php");
            exit();
        }
    }


    /** Fonction qui retourne un objet de type PDO
     * @param void
     *
     * @return PDO objet de connexion PDO
     */
    function dbConnexion() {
        // Ma connexion à la bdd
        $dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME. ';charset=utf8', DB_USER, DB_PASS);
        return $dbh;
    }
    
    
    
    /** Fonction qui retourne la date actuelle au format précisé en paramètre
     * @param string $format - Le format de la date (ex: 'd-m-Y')
     * 
     * @return string - La date du jour au format désiré
     */ 
    function getCurrentDate($format = 'd-m-Y') {
        return date($format);
    }
    
    
    /** Fonction qui retourne l'heure au format précisé en paramètre
     * @param string $format - Le format de l'heure (ex: 'H:i:s')
     * @param string $fuseau - Le $fuseau horaire (ex: "Europe/Paris")
     * 
     * @return string - L'heure au format désiré
     */ 
    function getCurrentHour($format = 'H:i:s', $fuseau="Europe/Paris") {
        date_default_timezone_set($fuseau);
        return date($format);
    }
    
        /** Fonction qui retourne l'incrémentation d'une valeur
     * @param int $x - Le nombre auquel on veut ajouter 1
     * 
     * @return int - La valeur obtenue
     */ 
    function increment($x) {
        return $x++;
    }

    /** Déplace un fichier transmis dans un répertoire du serveur
     * @param $file contenu du tableau $_FILES à l'index du fichier à uploader
     * @param $errors la variable devant contenir les erreurs. Passage par référence ;)
     * @param $folder chemin absolue ou relatif où le fichier sera déplacé. Par default UPLOADS_DIR
     * @param $fileExtensions par defaut vaut FILE_EXT_IMG. un tableau d'extensions valident
     * @return array un tableau contenant les erreurs ou vide
     */
    function uploadFile(array $file, array &$errors, string $folder = UPLOADS_DIR, array $fileExtensions = FILE_EXT_IMG)
    {
        $filename = '';
    
        if ($file["error"] === UPLOAD_ERR_OK) {
            $tmpName = $file["tmp_name"];
    
            // On récupère l'extension du fichier pour vérifier si elle est dans  $fileExtensions
            $tmpNameArray = explode(".", $file["name"]);
            $tmpExt = end($tmpNameArray);
            if(in_array($tmpExt,$fileExtensions))
            {
                // basename() peut empêcher les attaques de système de fichiers en supprimant les éventuels répertoire dans le nom
                // la validation/assainissement supplémentaire du nom de fichier peut être appropriée
                // On donne un nouveau nom au fichier
                $filename = uniqid().'-'.basename($file["name"]);
                if(!move_uploaded_file($tmpName, $folder.$filename))
                {
                    $errors[] = 'Le fichier n\'a pas été enregistré correctement';
                }
            }
            else
                $errors[] = 'Ce type de fichier n\'est pas autorisé !';
        }
        else if($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
            //fichier trop volumineux
            $errors[] = 'Le fichier est trop volumineux';
        }
        else {
            $errors[] = 'Une erreur a eu lieu au moment de l\'upload';
        }
    
        return $filename;
    }

        /** Execute une requête SQL permettant de compter le nombre d'éléments dans une table
     * @param PDO $dbh un objet PDO de connexion
     * @param string $table le nom de la table
     * 
     * @return array tableau contenant la chaine de caractères correspondant au nombre d'entrées dans la table
     */
     function countEntry(PDO $dbh, string $table) : array {
         $sth = $dbh -> prepare ('SELECT COUNT(*) FROM ' . $table);
         $sth -> execute();
         return $sth->fetch (PDO::FETCH_ASSOC);
     }
     
     
     /** Execute une requête SQL et retourne un jeu d'enregistrement complet
     * @param PDO $dbh un objet PDO de connexion
     * @param string $sql la requête a executé
     * @param array $params tableau contenant les éléments à binder dans la requête
     *
     * @return array jeu d'enregistrement
     */
    function dbSelectAll(PDO $dbh , string $sql, array $params = []) : array
    {
        /* 1. Preparer une requête */
        $sth = $dbh->prepare($sql);
    
        /* 2. Executer la requête */
        $sth->execute($params);
    
        /* 3. On récupère le jeu d'enregistrement */
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    

    /** Execute une requête SQL et retourne une ligne du jeu d'enregistrement
     * @param PDO $dbh un objet PDO de connexion
     * @param string $sql la requête a executé
     * @param array $params tableau contenant les éléments à binder dans la requête
     *
     * @return array jeu d'enregistrement
     */
    function dbSelectOne(PDO $dbh , string $sql, array $params = [])
    {
        /* 1. Preparer une requête */
        $sth = $dbh->prepare($sql);
        
        /* 2. Executer la requête */
        
        $sth->execute($params);
        
        /* 3. On récupère le jeu d'enregistrement */
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    
    /** Vérifie un input
     * @param string $data contient la valeur de l'input
     * @param 
     * @param 
     *
     * @return 
     */
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    
    
    
      /** Fonction qui vérifie si l'utilisateur est connecté et s'il est admin
     * @param - void
     * 
     * @return - void
     */ 
    function selectArticlesLimit() {
        
        $dbh = dbConnexion();
        
        $sql = "SELECT posts.*, users.user_firstname, category.category_name
        FROM posts
        JOIN users
            ON users.user_id = posts.post_author
        JOIN category
            ON category.category_id = posts.post_category
        ORDER BY post_date LIMIT 2";
        
        $sql = $dbh->prepare($sql);
        
        $sql->execute();
        
        $articles = $sql->fetchAll();
        
        return $articles;

    }
    

        



    
    /** Fonction qui retourne la liste des posts en fonction de la categorie choisi
     * @param - void
     * 
     * @return - void
     */ 

    function dbSelectPostc() {
        if(!isset($_GET['id'])) {
        header("Location: index.php");
        exit();
        }
        
        $idCategory = $_GET['id'];
        
                
        $dbh = dbConnexion();
        
        $sth = $dbh->prepare("SELECT posts.*, users.user_firstname, category.category_name
         FROM posts
         JOIN users 
            ON users.user_id = posts.post_author
        JOIN category 
            ON category.category_id = posts.post_category
             WHERE post_category = :id"); 
                
        $sth->bindValue('id', $idCategory, PDO::PARAM_STR);
        $sth->execute();
        $posts = $sth->fetchAll(); 
        
        return $posts;
        
    }
    


    /** Fonction qui retourne le nombre d'article posté 
     * @param string 
     * 
     * @return string 
     */ 
    function dbCountPosts() {

        // On se connecte à là base de données
        $dbh = dbConnexion();

        // On détermine le nombre total d'articles
        $sql = 'SELECT COUNT(*) AS  nb_posts FROM `posts`;';

        // On prépare la requête
        $query = $dbh->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère le nombre d'articles 
        $result = $query->fetch();

        $nbArticles = (int) $result['nb_posts'];

        return $nbArticles;
    }
    






    /** Fonction qui retourne toutes les infos concernant les articles en faisant des jointures sur les catégories correspondantes et les auteures
     * @param string 
     * 
     * @return string 
     */ 

    function dbSelectInfosPosts($nbArticles,$currentPage) {
        // On détermine le nombre d'articles par page

        $parPage = 2;

        // On calcule le nombre de pages total
        $pages = ceil($nbArticles / $parPage);

        // Calcul du 1er article de la page
        $premier = ($currentPage * $parPage) - $parPage;

        $sql = "SELECT posts.*, users.user_firstname, category.category_name
        FROM posts
        JOIN users
            ON users.user_id = posts.post_author
        JOIN category
            ON category.category_id = posts.post_category
        ORDER BY post_date DESC LIMIT :premier, :parpage";

        // On prépare la requête
        $query = $dbh->prepare($sql);

        $query->bindValue(':premier', $premier, PDO::PARAM_INT);
        $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

        // On exécute
        $query->execute();

        // On récupère les valeurs 
        $posts = $query->fetchAll(PDO::FETCH_ASSOC);

        return $posts;


    }
    
    

    
    
