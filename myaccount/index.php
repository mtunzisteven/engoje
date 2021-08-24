<?php

// session expire reset: 180 sec
session_cache_expire();

    //This is the main controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';

    // active tab array
    $_SESSION['active_tab'] = [
        'account'=>'',
        'users'=>'',
        'products'=>'',
        'images'=>'',

    ];

    //var_dump($_SESSION['active_tab']); exit;

    // Get the side navs library
    require_once '../library/sidenav.php';
    // Get the main model for use as needed
    require_once '../model/main-model.php';

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){
        case 'account':

            // logged in
            if(isset($_SESSION['loggedin'])){

                // addmin level
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