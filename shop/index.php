<?php

//This is the shop controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';
    // Get the za listing main model for use as needed
    require_once '../model/main-model.php';
    // Get the shop model for use as needed
    require_once '../model/shop-model.php';

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
         include '../view/shop.php';
    }