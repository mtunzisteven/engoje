<?php
    //This is the main controller for the site
    session_start();

    // Get the database connection file
    require_once 'library/connections.php';
    // Get the database connection file
    require_once 'library/functions.php';
    // Get the PHP Motors model for use as needed
    require_once 'model/main-model.php';

    // Check if the firstname cookie exists, get its value
    if(isset($_COOKIE['firstname'])){
        $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
    }

    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){
        case 'something':
         
         break;
        
        default:
         include 'view/home.php';
       }