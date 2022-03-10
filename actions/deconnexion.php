<?php
session_start();

// Supprimer la session

session_destroy();

// Redirection vers index.php

header('Location: ../index.php');
exit;

