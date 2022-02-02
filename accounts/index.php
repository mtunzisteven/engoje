<?php

//This is the Accounts Controller for the site
set_error_handler("warning_handler", E_WARNING);


// Get the database connection file
require_once '../library/connections.php';
// Get the cleaner script 
require_once '../library/dbCleaner.php';
// Get the functions library
require_once '../library/functions.php';
// Get the main model for use as needed
require_once '../model/main-model.php';
// Get the acciunts model for use as needed
require_once '../model/accounts-model.php';
// Get the reviews model for use as needed
require_once '../model/reviews-model.php';  
// Get the engoje model for use as needed
require_once '../model/warningLog-model.php';

// active tab array
$_SESSION['active_tab'] = $active_tabs;

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    
    case 'login':
        include "../view/login.php";
        break;
    case 'reg':
        include "../view/registration.php";
        break;
    case 'register':
        // Filter and store the data
        $userFirstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_STRING);
        $userLastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_STRING);
        $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
        $csrfToken = filter_input(INPUT_POST, '_csrf', FILTER_SANITIZE_NUMBER_INT);

        // Check for csrf token data
        if($csrfToken != $_SESSION['csrfToken']){
            
            $message = "<p class='small-notice text-center detail-span-bold'>There was an error processing your request, please try again.</p>";
            include '../view/registration.php';
            exit; 
        }
        
        // Check for existing email in the database
        $existingEmail = checkforRegisteredEmail($userEmail);

        $userEmail = checkEmail($userEmail);

        // When email exists reject registration and ask user to user another
        if($existingEmail===1){
            $message = "<p class='detail-span-bold'>An account with the email: $userEmail already exists. Do you want to login instead?</p>";
            include "../view/login.php";
            exit;
        }

        // Check for missing data
        if(empty($userFirstName) || empty($userLastName) || empty($userEmail)){
            $message = "<p class='detail-span-bold'>Please provide information for all empty form fields.</p>";
            include '../view/registration.php';
            exit; 
        }
        
        //////////////////////////////////////////
        //      confirm email with token        //
        //////////////////////////////////////////

        // create token
        $regToken = random_int(100000, 999999);

        // enter user details to temp account table

        if(addTempAccount($userFirstName, $userLastName, $userEmail, $regToken)){

            // temp account id
            $taid = getTempAccountId($userEmail)[0];

            // email token in link to user for him/her to click and confirm
            // email link: https://engoje.co.za/accounts/?action=confirm-eid&$taid=$tuaid&regTk=$regToken

            header("Location: /engoje/accounts/?action=confirm-eid&taid=$taid&regTk=$regToken");
            exit;
        }

        break;

    // email link will bring you here to confirm id and regToken
    case 'confirm-eid':
        $regToken = filter_input(INPUT_GET, 'regTk', FILTER_SANITIZE_NUMBER_INT);
        $temp_accountId = filter_input(INPUT_GET, 'taid', FILTER_SANITIZE_NUMBER_INT);

        // fetch token in the temp accounts using id
        $db_regToken = getRegToken($temp_accountId)[0];

        // When the token is correct email confirmed
        if($regToken == $db_regToken){

            // go enter new password and reg account
            header("Location: /engoje/accounts/?action=new-password&taid=$temp_accountId");
            exit;

        }else{

            include '../view/registration.php';

        }

        break;

    // Once confirmed token, go enter password
    case 'new-password':

        $temp_accountId = filter_input(INPUT_GET, 'taid', FILTER_SANITIZE_NUMBER_INT);

        include '../view/confirmed-email.php';

        break;

    // check if valid password then reg user if valid
    case 'complete-reg':

        $temp_accountId = filter_input(INPUT_POST, 'taid', FILTER_SANITIZE_NUMBER_INT);
        $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);

        $temp_accoutInfo = getTempAccountInfo($temp_accountId);

        $checkPassword = checkPassword($userPassword);

        // Hash the password to hide it from anyone and all.
        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

        // Send the data to the model name, surname, email
        $regOutcome = regUser($temp_accoutInfo[0], $temp_accoutInfo[1], $temp_accoutInfo[2], $userPassword);

        // Check and report the result
        if($regOutcome === 1){
            setcookie('firstName',$userFirstName,strtotime('+1 year'), '/');

            $_SESSION['message'] = "<p class='small-notice text-center detail-span-bold'>Thanks for registering $userFirstName. Please use your email and password to login.</p>";

            deleteTempAccount($temp_accountId);

            header('Location: /engoje/view/login.php');

            exit;
        } else {
            $message = "<p class='small-notice text-center detail-span-bold'>Error! Your registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;

    case 'Login':
        
        // Filter and store the data
        $csrfToken = filter_input(INPUT_POST, '_csrf', FILTER_SANITIZE_NUMBER_INT);
        $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
        $userEmail = checkEmail($userEmail);

        $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);
        $checkPassword = checkPassword($userPassword);

        
        // Check for csrf token data
        if($csrfToken != $_SESSION['csrfToken']){
            
            $message = "<p class='small-notice text-center detail-span-bold'>There was an error processing your request, please try again.</p>";
            include '../view/login.php';
            exit; 
        }

        // Check for missing data
        if(empty($userEmail) || empty($checkPassword)){
            
            $message = "<p class='small-notice text-center detail-span-bold'>Incorrect password and email combination. Please try again.</p>";
            include '../view/login.php';
            exit; 
        }

        // Get all user data
        $userData = getUser($userEmail);

        if($userData!=0){
            // Get default password for the email-password combination entered
            // If email entered was not valid, this will return a boolian and cause an error. 
            // Need to fix that
            $hashed_password = $userData['userPassword'];

            // Save password verification check to a variable
            $password_check = password_verify($userPassword, $hashed_password);

            // If password check has a true value, password is correct
            if($password_check){

                // Set log out session variable
                $_SESSION['logout']="<span class=\" detail-span-bold\"><a class=\"account \" href=\"/engoje/accounts/index.php?action=logout\">Logout</a></span>";


                // A valid user exists, log them in
                $_SESSION['loggedin'] = TRUE;
                // Remove the password from the array
                // the array_pop function removes the last
                // element from an array
                array_pop($userData);
                // Store the array into the session
                $_SESSION['userData'] = $userData;

                // Create a message session variable
                $_SESSION['message'] = "<p class='small-notice text-center detail-span-bold'>Thanks for logging in ".$_SESSION['userData']['userFirstName']."</p>";

                // Get reviews for the specific user for use in showing reviews
                $reviews = getUserReviews($_SESSION['userData']['userId']);

                // Getting the reviews html from the functions.
                $customerReviews = customerReviews($reviews);

                // Send them to the admin view
                header('Location:/engoje/accounts/?action=account');
                exit; 
            }
            else{

                $message = "<p class='small-notice text-center detail-span-bold'>Please check your password and email combination and try again.</p>";
                include '../view/login.php';
                exit; 
            }
        }
        else{

            $message = '<p class="small-notice text-center detail-span-bold ">Please check your password and email combination and try again.</p>';
            include '../view/login.php';
            exit; 
        }

        break;

    case 'logout':

        //Destroy session variables
        $_SESSION = array();

        // Log them out
        $_SESSION['loggedin'] = FALSE;

        header('Location: /engoje/');

        break;

    case 'account':

        // sey the active tab on the admin side nav
        $_SESSION['active_tab']['account'] = "active";

        // Get the side navs library
        include '../library/sidenav.php'; 

        // Build Admin Side Navs
        $adminSideNav = buildAdminSideNav();

        include '../view/account.php';

        break;

    case 'users':

        $users = getUsers();

        $userRows = buildUsersDisplay($users);

        //echo $display; exit;

        include '../view/users.php';

        break;

    case 'user':

        $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_STRING);

        $userInfo = getUserInfo($userId);

        $userDisplay = buildUserDisplay($userInfo);

        //echo $display; exit;

        include '../view/user.php';

        break;

    case 'update':

        $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $userInfo = getUserInfo($userId);

        //echo var_dump($userInfo); exit;
        if (!$userInfo) {
                $message = 'Sorry, no user information could be found.';
        }

        $_SESSION['userId'] = $userId;

        include '../view/user-update.php';
        exit;

        break;

    case 'updateInfo':

        // Filter and store the data
        $userFirstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_STRING);
        $userLastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_STRING);
        $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
        $userPhone = filter_input(INPUT_POST, 'userPhone', FILTER_SANITIZE_NUMBER_INT);
        $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);

        //echo "updating"; exit;
        
        // Check for missing data
        if(empty($userFirstName) || empty($userLastName) || empty($userEmail)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            $_SESSION['message-info']=$message;

            unset($_POST);
            include '../view/user-update.php';
            exit; 
        }

        // Send the data to the model
        $updateResult = updateInfo($userFirstName, $userLastName, $userEmail, $userPhone, $userId);

        // Check and report the result
        if($updateResult===1){
            //echo "done"; exit;

            $_SESSION['message-info'] = "<p class='admin-center'>Your information has been updated successfully $userFirstName.</p>";

            $_SESSION['userData']['userFirstName'] = $userFirstName;

            header('Location: /phpmotors/accounts/');

            exit;
        } else {
            $message = "<p>Error! Details could not be. Please try again.</p>";
            include '../view/user-update.php';
            exit;
        }

        break;

    case 'updatePassword':

            // Filter and store the data
            $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);
            $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);

            // Check for missing data
            if(empty($userPassword)){
                $_SESSION['message-password']='<p>Please provide new password.</p>';

                echo $userPassword; exit;

                include '../view/user-update.php';
                exit; 
            }

            $userPassword = password_hash($userPassword, PASSWORD_DEFAULT); 

            // Send the data to the model
            $updateResult = updatePassword($userId, $userPassword);

            // Check and report the result
            if($updateResult){

                $_SESSION['message-password'] = "<p class='admin-center'>Your password has been updated successfully.</p>";

                header('Location: /phpmotors/accounts/');

                exit;
            } else {

                $message = "<p>Error! Details could not be. Please try again.</p>";
                include '../view/user-update.php';
                exit;
            }



        break;

    case 'admin':

    default:

        // Get reviews for the specific user fior use in displaying reviews
        $reviews = getUserReviews($_SESSION['userData']['userId']);

        // Get the reviews display html from functions file.
        $customerReviews = customerReviews($reviews);

        include '../view/admin.php';
        break;
}

restore_error_handler();

function warning_handler($errno, $errstr) { 

    $warningNumber = $errno;

    $warning = $errstr;

    $warningLocation = 'Account Index';

    addWarning($warningNumber, $warning, $warningLocation);

    // header('Location: /engoje/error/500.php');

}

