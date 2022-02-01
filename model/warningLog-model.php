<?php

// Add a single cart item for the user 
function addWarning($warningNumber, $warning, $warningLocation){
    // Create a connection object from the zalist connection function
    $db = engojeConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            warningLog (
                                warningNumber, 
                                warning,
                                warningLocation
                                ) 
                            VALUES (
                                :warningNumber, 
                                :warning,
                                :warningLocation)'
                            );

    // Replace the place holders
    $stmt->bindValue(':warningNumber',$warningNumber, PDO::PARAM_INT);
    $stmt->bindValue(':warning',$warning, PDO::PARAM_STR);
    $stmt->bindValue(':warningLocation',$warningLocation, PDO::PARAM_STR);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();

    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}