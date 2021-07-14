<?php

// session expire reset: 180 sec
session_cache_expire();

    //This is the Accounts Controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the functions library
    require_once '../library/functions.php';
    // Get the PHP Motors model for use as needed
    require_once '../model/main-model.php';
    // Get the acciunts model for use as needed
    require_once '../model/accounts-model.php';
    // Get the reviews model for use as needed
    require_once '../model/reviews-model.php';  

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    // Build User Update Admin Nav
    $userUpdateNav = buildUserUpdateNav();


    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

    switch ($action) {

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

            $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);

            $userInfo = getUserInfo($userId);

            $userDisplay = buildUserDisplay($userInfo);

            $_SESSION['updatinguserId'] = $userInfo['userId'];

            // Build User Update Admin Nav here for scope to updating userId
            $userUpdateNav = buildUserUpdateNav();

            //echo $display; exit;

            include '../view/user.php';

            break;

        case 'update-user':

            $userFirstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_STRING);
            $userLastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_STRING);
            $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_STRING);
            $userPhone = filter_input(INPUT_POST, 'userPhone', FILTER_SANITIZE_NUMBER_INT);

            // Send the data to the model
            $updateResult = updateInfo($userFirstName, $userLastName, $userEmail, $userPhone, $_SESSION['updatinguserId']);

            //var_dump($updateResult); exit;

            // Build Admin Side Nav
            $adminSideNav = buildAdminSideNav();

            //echo var_dump($userInfo); exit;

            // If database update fails, send user a message.
            if (!$updateResult) {
                    $message = "<p class='notice detail-span-bold'>Sorry, we couldn't update the account.</p>";
                    include '../view/user.php';

            }else{

                $message = "<p class='notice detail-span-bold'>Success, we updated $userFirstName $userLastName's account.</p>";
                include '../view/admin.php';

            }

            break;

        // Get Addresses from db
        // Create form based on whether an address exists or not for the user
        // Create a display for the forms if they not are found
        case 'address':

            $addresses = getAddress($_SESSION['updatinguserId']);

            //var_dump($addresses); exit;

            // Set true if because there are no addresses found in the database
            $addressFound = false;

            if(empty($addresses)){

            // Build form
            $addressForm = buildAddressForm($addresses, $addressFound);

            // Build Address display
            $addressSideDisplay = buildAddresses($addresses, $addressFound);

            }else{

                // Set true if because there are addresses found in the database
                $addressFound = true;

                // Build Address display
                $addressSideDisplay = buildAddresses($addresses, $addressFound);

            }

            include '../view/address.php';

            break;


        case 'replace-address':

            // Get and sanitize the variable from the link 
            $addressType = filter_input(INPUT_GET, 'addressType', FILTER_SANITIZE_STRING); 

            //var_dump($addressType); exit;

            // Get specific address from database
            $address = getAddressbyType($_SESSION['updatinguserId'], $addressType);

            if(!empty($address)){

                // Set true if because there are addresses found in the database
                $addressFound = true;

                //var_dump($address); exit;

                // Build form
                $addressForm = buildAddressForm($address, $addressFound); 

            }

            include '../view/address-update.php';

            break;

        // Access adddress update form
        case 'new-address':

            $addressLineOne = filter_input(INPUT_POST, 'addressLineOne', FILTER_SANITIZE_STRING); 
            $addressLineTwo = filter_input(INPUT_POST, 'addressLineTwo', FILTER_SANITIZE_STRING);
            $addressCity = filter_input(INPUT_POST, 'addressCity', FILTER_SANITIZE_STRING);
            $addressZipCode = filter_input(INPUT_POST, 'addressZipCode', FILTER_SANITIZE_STRING);
            $addressType = filter_input(INPUT_POST, 'addressType', FILTER_SANITIZE_NUMBER_INT);

            if(!empty($addressLineOne) && !empty($addressLineTwo) && !empty($addressCity) && !empty($addressZipCode) && !empty($addressType)){
                
                // Add billing address
                $newAddress = addAddress($addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $_SESSION['updatinguserId']);

                // Set shipping addressType
                $addressType =$addressType+1;

                // Add shipping address
                $newAddress = addAddress($addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $_SESSION['updatinguserId']);

            
                // carry on if an address exists for the user
                if($newAddress){

                    // Get the new addresses you added
                    $addresses = getAddress($_SESSION['updatinguserId']);
                
                    // Set true if because there are addresses found in the database
                    $addressFound = true;

                    // Build Address display
                    $addressSideDisplay = buildAddresses($addresses, $addressFound);

                    $message = "<p class='notice detail-span-bold center'>Success, we added the address successfully.</p>";
                }else{
                    // Empty placeholder values, but values were added by user
                    $message = "<p class='notice detail-span-bold'>Error, we couldn't add the address.</p>";
    
                }

            }else{
                $message = "<p class='notice detail-span-bold'>Error! All address details need to be filled</p>";
                include '../view/admin.php';
                exit;
            }

            include '../view/address.php';

            break;

        // Access adddress update form
        case 'update-address':

            $addressLineOne = filter_input(INPUT_POST, 'addressLineOne', FILTER_SANITIZE_STRING); 
            $addressLineTwo = filter_input(INPUT_POST, 'addressLineTwo', FILTER_SANITIZE_STRING);
            $addressCity = filter_input(INPUT_POST, 'addressCity', FILTER_SANITIZE_STRING);
            $addressZipCode = filter_input(INPUT_POST, 'addressZipCode', FILTER_SANITIZE_STRING);
            $addressType = filter_input(INPUT_POST, 'addressType', FILTER_SANITIZE_NUMBER_INT);

            if(!empty($addressLineOne) && !empty($addressLineTwo) && !empty($addressCity) && !empty($addressZipCode) && !empty($addressType)){

                //echo "<br/>Line 1: $addressLineOne"; echo "<br/>Line 2: $addressLineTwo"; echo "<br/>AddressCity: $addressCity";  echo "<br/>AddressZipCode: $addressZipCode";   echo "<br/>AddressType: $addressType";   echo "<br/>User Id: $_SESSION[updatinguserId]"; exit;


                $updatedAddress = updateAddress($addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $_SESSION['updatinguserId']);
            
                // carry on if an address exists for the user
                if($updatedAddress){

                    // Get the new addresses you added
                    $addresses = getAddress($_SESSION['updatinguserId']);

                    // Set true if because there are addresses found in the database
                    $addressFound = true;

                    // Build Address display
                    $addressSideDisplay = buildAddresses($addresses, $addressFound);

                    $message = "<p class='notice detail-span-bold center'>Success, we updated the address successfully.</p>";

                }else{
                    
                    
                    $message = "<p class='notice detail-span-bold'>Error, we couldn't update the address.</p>";
    
                }

            }else{
                $message = "<p class='notice detail-span-bold'>Error! All address details need to be filled</p>";
                include '../view/address.php';
                exit;
            }

            include '../view/address.php';



            break;

        // Send Password reset link
        case 'sendPassword':


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