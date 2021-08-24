<?php

// session expire reset: 180 sec
session_cache_expire();

    //This is the Accounts Controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the functions library
    require_once '../library/functions.php';
    // Get the side navs library
    require_once '../library/sidenav.php';
    // Get the main model for use as needed
    require_once '../model/main-model.php';
    // Get the acciunts model for use as needed
    require_once '../model/accounts-model.php';
    // Get the reviews model for use as needed
    require_once '../model/reviews-model.php';  

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();



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
            $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);

            $userEmail = checkEmail($userEmail);
            $checkPassword = checkPassword($userPassword);

            // Check for existing email in the database
            $existingEmail = checkforRegisteredEmail($userEmail);

            // When email exists reject registration and ask user to user another
            if($existingEmail===1){
                $message = "<p class='detail-span-bold'>An account with the email: $userEmail already exists. Do you want to login instead?</p>";
                include "../view/login.php";
                exit;
            }

            // Check for missing data
            if(empty($userFirstName) || empty($userLastName) || empty($userEmail) || empty($checkPassword)){
                $message = "<p class='detail-span-bold'>Please provide information for all empty form fields.</p>";
                include '../view/registration.php';
                exit; 
            }

            // Hash the password to hide it from anyone and all.
            $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

            // Send the data to the model
            $regOutcome = regUser($userFirstName, $userLastName, $userEmail, $userPassword);

            // Check and report the result
            if($regOutcome === 1){
                setcookie('firstName',$userFirstName,strtotime('+1 year'), '/');

                $_SESSION['message'] = "<p class='detail-span-bold'>Thanks for registering $userFirstName. Please use your email and password to login.</p>";

                header('Location: /zalisting/view/login.php');

                exit;
            } else {
                $message = "<p class='detail-span-bold'>Error! Your registration failed. Please try again.</p>";
                include '../view/registration.php';
                exit;
            }
            break;

        case 'Login':
            // Filter and store the data
            $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
            $userEmail = checkEmail($userEmail);

            $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);
            $checkPassword = checkPassword($userPassword);

            // Check for missing data
            if(empty($userEmail) || empty($checkPassword)){
                
                $message = "<p class='detail-span-bold'>Incorrect password and email combination. Please try again.</p>";
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
                    $_SESSION['logout']="<span class=\" detail-span-bold\"><a class=\"account \" href=\"/zalisting/accounts/index.php?action=logout\">Logout</a></span>";


                    // A valid user exists, log them in
                    $_SESSION['loggedin'] = TRUE;
                    // Remove the password from the array
                    // the array_pop function removes the last
                    // element from an array
                    array_pop($userData);
                    // Store the array into the session
                    $_SESSION['userData'] = $userData;

                    // Create a message session variable
                    $_SESSION['message'] = "<p class='detail-span-bold'>Thanks for logging in ".$_SESSION['userData']['userFirstName']."</p>";

                    // Get reviews for the specific user for use in showing reviews
                    $reviews = getUserReviews($_SESSION['userData']['userId']);

                    // Getting the reviews html from the functions.
                    $customerReviews = customerReviews($reviews);

                    // Send them to the admin view
                    include '../view/admin.php';
                    exit; 
                }
                else{

                    $message = "<p class='detail-span-bold'>Please check your password and email combination and try again.</p>";
                    include '../view/login.php';
                    exit; 
                }
            }
            else{

                $message = '<p class="notice detail-span-bold">Please check your password and email combination and try again.</p>';
                include '../view/login.php';
                exit; 
            }

            break;

        case 'logout':

            //Destroy session variables
            $_SESSION = array();
            // Log them out
            $_SESSION['loggedin'] = FALSE;
            header('Location: /zalisting/');
            break;

        case 'account':

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