<?php

// This is the main-model for ZA Listing

function getClassifications(){
 // Create a connection object from the phpmotors connection function
 $db = zalistingConnect(); 
 // The SQL statement to be used with the database 
 $sql = 'SELECT* FROM products ORDER BY productCreationDate ASC'; 
 // The next line creates the prepared statement using the phpmotors connection      
 $stmt = $db->prepare($sql);
 // The next line runs the prepared statement 
 $stmt->execute(); 
 // The next line gets the data from the database and 
 // stores it as an array in the $classifications variable 
 $classifications = $stmt->fetchAll(); 
 // The next line closes the interaction with the database 
 $stmt->closeCursor(); 
 // The next line sends the array of data back to where the function 
 // was called (this should be the controller) 
 return $classifications;
}


// Add an incomplete order that will be removed as soon as the 
// customer proceeds to buy the items by paying for this order, empties cart
// or when the user revises the order. Only one per user may be added
function addUserFeedback($userId, $experience, $feedback, $feedbackDate){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            user_feedback (
                                userId, 
                                experience,
                                feedback,
                                feedbackDate
                                ) 
                            VALUES (
                                :userId, 
                                :experience,
                                :feedback,
                                :feedbackDate)'
                            );

    // Replace the place holders
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);
    $stmt->bindValue(':experience',$experience, PDO::PARAM_STR);    
    $stmt->bindValue(':feedback',$feedback, PDO::PARAM_STR);    
    $stmt->bindValue(':feedbackDate',$feedbackDate, PDO::PARAM_STR);    

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();

    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}