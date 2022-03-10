<?php

// Constante contenant le titre de mon site
define("TITLE", 'Mon Blog');

// Constante contenant la phrase d'accroche de mon site
define("CATCH_INTRO", 'Bienvenue sur mon blog');

// Contante contenant la DB_HOST
define("DB_HOST", 'localhost');

// Contante contenant la DB
define("DB_NAME", 'sergetouvoli_reseau');

// Contante contenant le nom d'utilisateur de la BDD
define("DB_USER", 'root');

// Contante contenant le mot de passe de la BDD
define("DB_PASS", '');


/**
 * @var FILE_EXT_IMG  extensions acceptées pour les images
 */
const FILE_EXT_IMG = ['jpg','jpeg','gif','png'];

/**
 * @var BASE_DIR Répertoire de base du blog sur le disque du serveur
 */
define('BASE_DIR', realpath(dirname(__FILE__) . "/../"));

/**
 * @var UPLOADS_DIR Répertoire ou seront uploadés les fichiers
 */
const UPLOADS_DIR = BASE_DIR.'/uploads/';