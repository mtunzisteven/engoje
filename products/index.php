<?php

//This is the products controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';
    // Get the zalisting main model for use as needed
    require_once '../model/main-model.php';
    // Get the accounts model for use as needed
    require_once '../model/accounts-model.php';
    // Get the products admin model for use as needed
    require_once '../model/products-model.php';

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();


    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){
        case 'something':
         
         break;
        
        default:
         include '../view/admin.php';
    }