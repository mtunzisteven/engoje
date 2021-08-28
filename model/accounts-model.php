<?php

//This model is for the accounts 


function regUser($userFirstName, $userLastName, $userEmail, $userPassword){
    // Create a connection object using the phpmotors connection function
    $db = engojeConnect();
    // The SQL statement
    $sql = 'INSERT INTO users (userFirstName, userLastName,userEmail, userPassword)
        VALUES (:userFirstName, :userLastName, :userEmail, :userPassword)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':userFirstName', $userFirstName, PDO::PARAM_STR);
    $stmt->bindValue(':userLastName', $userLastName, PDO::PARAM_STR);
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
    $stmt->bindValue(':userPassword', $userPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// Check for existing email
function checkforRegisteredEmail($userEmail){
    // Create a connection object using the phpmotors connection function
    $db = engojeConnect();
    // The SQL statement
    $sql = 'SELECT userEmail FROM users WHERE userEmail = :userEmail';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next line replacse the placeholder in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);

    // Execute the request
    $stmt->execute();

    // Get result of the check: returns a numeric indexed array
    $emailMatch = $stmt->fetch(PDO::FETCH_NUM);

    // Close the database interaction
    $stmt->closeCursor();

    if(empty($emailMatch)){
        // test
        //echo "No matching email"; exit;
        return 0;

    }
    else{

        // test
        //echo "Matching email exists"; exit;
        return 1;

    }

}

// get hashed password for the user using email.
function getDefaultPassword($userEmail){

    // Create a connection object using the zalist connection function
    $db = engojeConnect();

    // The SQL statement
    $sql = 'SELECT userPassword FROM users WHERE userEmail = :userEmail';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next line replacse the placeholder in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);

    // Execute the request
    $stmt->execute();

    // Get result of the check: returns a numeric indexed array
    $hashed_password = $stmt->fetch(PDO::FETCH_NUM);

    // Close the database interaction
    $stmt->closeCursor();

    // return the hashed password
    return $hashed_password;
    
}

// Get all registered users 
function getUsers(){
    $db = engojeConnect();
    $sql = 'SELECT userId, userFirstName, userLastName, userEmail, userPhone FROM users';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $userData;
   }

// Get user data based on an email address
function getUser($userEmail){
    $db = engojeConnect();
    $sql = 'SELECT userId, userFirstName, userLastName, userEmail, userLevel, userPassword FROM users WHERE userEmail = :userEmail';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $userData;
   }

// Get user information by invId
function getUserInfo($userId){
    $db = engojeConnect();
    $sql = 'SELECT userId, userFirstName, userLastName, userEmail, userPhone FROM users WHERE userId = :userId'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor();
    return $userData;
}

// This is for updating user information
function updateInfo($userFirstName, $userLastName, $userEmail, $userPhone, $userId){
    $db = engojeConnect();
    $sql = 'UPDATE users SET userFirstName=:userFirstName, userLastName=:userLastName, userEmail=:userEmail, userPhone=:userPhone WHERE userId = :userId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userFirstName', $userFirstName, PDO::PARAM_STR);
    $stmt->bindValue(':userLastName', $userLastName, PDO::PARAM_STR);
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
    $stmt->bindValue(':userPhone', $userPhone, PDO::PARAM_INT);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();
    return $rowsChanged;
}

// Set Password information by invId
function updatePassword($userId, $userPassword){
    $db = engojeConnect();
    $sql = 'UPDATE users SET userPassword=:userPassword WHERE userId = :userId'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':userPassword', $userPassword, PDO::PARAM_STR);
    $stmt->execute();
    $userData = $stmt->rowCount(); 
    $stmt->closeCursor();
    return $userData;
}

// Get user information by userId 
function getAddress($userId){
    $db = engojeConnect();
    $sql = 'SELECT addressLineOne, addressLineTwo, addressCity, addressZipCode, addressType FROM addresses WHERE userId = :userId'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $Address = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor();
    return $Address;
}

// Get user information by userId and addressType
function getAddressbyType($userId, $addressType){
    $db = engojeConnect();
    $sql = 'SELECT addressLineOne, addressLineTwo, addressCity, addressZipCode, addressType FROM addresses WHERE userId = :userId AND addressType = :addressType'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':addressType', $addressType, PDO::PARAM_INT);
    $stmt->execute();
    $Address = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor();
    return $Address;
}

// This is for updating Addresses by address typ
function updateAddress($addressName, $addressNumber, $addressEmail, $addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $userId){
    $db = engojeConnect();
    $sql = "UPDATE addresses SET addressName=:addressName, addressNumber=:addressNumber, addressEmail=:addressEmail, addressLineOne=:addressLineOne, addressLineTwo=:addressLineTwo, addressCity=:addressCity, addressZipCode=:addressZipCode, addressType=:addressType WHERE userId = :userId AND addressType = :addressType";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':addressName', $addressName, PDO::PARAM_STR);
    $stmt->bindValue(':addressNumber', $addressNumber, PDO::PARAM_STR);
    $stmt->bindValue(':addressEmail', $addressEmail, PDO::PARAM_STR);
    $stmt->bindValue(':addressLineOne', $addressLineOne, PDO::PARAM_STR);
    $stmt->bindValue(':addressLineTwo', $addressLineTwo, PDO::PARAM_STR);
    $stmt->bindValue(':addressCity', $addressCity, PDO::PARAM_STR);
    $stmt->bindValue(':addressZipCode', $addressZipCode, PDO::PARAM_STR);
    $stmt->bindValue(':addressType', $addressType, PDO::PARAM_INT);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();
    return $rowsChanged;
}

// This is for updating Addresses
function addAddress($addressName, $addressNumber, $addressEmail, $addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $userId){

    $db = engojeConnect();
    $sql = 'INSERT INTO addresses (addressName, addressNumber, addressEmail, addressLineOne, addressLineTwo, addressCity, addressZipCode, addressType, userId) VALUES(:addressName, :addressNumber, :addressEmail, :addressLineOne, :addressLineTwo, :addressCity, :addressZipCode, :addressType, :userId)';
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':addressName', $addressName, PDO::PARAM_STR);
    $stmt->bindValue(':addressNumber', $addressNumber, PDO::PARAM_STR);
    $stmt->bindValue(':addressEmail', $addressEmail, PDO::PARAM_STR);
    $stmt->bindValue(':addressLineOne', $addressLineOne, PDO::PARAM_STR);
    $stmt->bindValue(':addressLineTwo', $addressLineTwo, PDO::PARAM_STR);
    $stmt->bindValue(':addressCity', $addressCity, PDO::PARAM_STR);
    $stmt->bindValue(':addressZipCode', $addressZipCode, PDO::PARAM_STR);
    $stmt->bindValue(':addressType', $addressType, PDO::PARAM_INT);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();
    return $rowsChanged;
}