<?php
//This is the main controller for the site

set_error_handler("warning_handler", E_WARNING);

// Get the database connection file
require_once 'library/connections.php';
// Get the database connection file
require_once 'library/functions.php';
// Get the side navs library
require_once 'library/sidenav.php';
// Get the engoje model for use as needed
require_once 'model/main-model.php';
// Get the engoje model for use as needed
require_once 'model/warningLog-model.php';

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 

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

restore_error_handler();

function warning_handler($errno, $errstr) { 

    $warningNumber = $errno;

    $warning = $errstr;

    $warningLocation = 'Main Index';

    addWarning($warningNumber, $warning, $warningLocation);

    header('Location: /engoje/error/500.php');

}