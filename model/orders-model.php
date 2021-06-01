<?php

// Add a single cart item for the user 
function getUserDetails($userId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM users 
                    JOIN addresses ON addresses.userId = users.userId
                    WHERE users.userId = :userId AND addresses.addressType = 1';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}
