<?php



    //This is the main controller for the site

// no session started var set yet = no session created yet 
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['started'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_regenerate_id(true);

    // set new session started var
    $_SESSION['STARTED'] = time();

}

// start session with same id in this file
session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';
    // Get the main model for use as needed
    require_once '../model/main-model.php';



    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){
        case 'account':

            // sey the active tab on the admin side nav
            $_SESSION['active_tab']['account'] = "active";

            // Get the side navs library
            include '../library/sidenav.php'; 

            // Build Admin Side Navs
            $adminSideNav = buildAdminSideNav();

            // customer level
            if($_SESSION['userData']['userLevel'] < 2){
               
                include ('../view/account.php');

            }else{// admin level
                include ('../view/admin.php');
            }
         
         break;
        
        default:
         include '../view/home.php';
       }