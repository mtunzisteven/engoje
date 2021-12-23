<?php
    //This is the main controller for the site


// start session with same id in this file// start session with same id in this file
session_start();

// no session started var set yet = session just created
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['STARTED'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_destroy();

    // set new session started var
    $_SESSION['STARTED'] = time();

}

    // Get the database connection file
    require_once 'library/connections.php';
    // Get the database connection file
    require_once 'library/functions.php';
    // Get the side navs library
    require_once 'library/sidenav.php';
    // Get the engoje model for use as needed
    require_once 'model/main-model.php';

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    // Check if the firstname cookie exists, get its value
    if(isset($_COOKIE['firstname'])){
        $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
    }

    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){
        case 'fb':

            include "view/feedback.php";

            break;

        case 'fbr':

            $feedback = filter_input(INPUT_POST, 'feedback',FILTER_SANITIZE_STRING);

            $experience = filter_input(INPUT_POST, 'experince',FILTER_SANITIZE_STRING);

            $feedbackDate = date('Y-m-d H:i:s');

            if(!empty($feedback) && !empty($experience)){

                $result = addUserFeedback($_SESSION['userData']['userId'], $experience, $feedback, $feedbackDate);

                if($result){

                    $_SESSION['message'] = "<p class='notice detail-span-bold'>Feedback received. Thank you for your feedback ".$_SESSION['userData']['userFirstName']."!</p>";
                
                }else{

                    $_SESSION['message'] = "<p class='notice detail-span-bold'>We could not record your feedback. Please try again later ".$_SESSION['userData']['userFirstName']."!</p>";

                }
            }
            //var_dump($_SESSION['userData']['userFirstName']); exit;


            include "view/feedback.php";

            break;

        case "home":
        case null:

            include 'view/home.php';

            break;
        
        default:

            header('Location: /engoje/error/404.php');
       }