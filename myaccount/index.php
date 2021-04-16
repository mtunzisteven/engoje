<?php
    //This is the main controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';
    // Get the PHP Motors model for use as needed
    require_once '../model/main-model.php';

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){
        case 'account':

            if(isset($_SESSION['loggedin'])){

                if($_SESSION['userData']['userLevel']<2){

                include ('../view/account.php');

                }else{
                    include ('../view/admin.php');
                }

            }
         
         break;
        
        default:
         include '../view/home.php';
       }