<?php

// Add a single cart item for the user 
function getUserDetails($userId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM  addresses 
                    WHERE userId = :userId 
                    /*AND addresses.addressType = 1*/
                    ';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

// Add a single cart item for the user 
function deleteAddress($addressType){
    $db = zalistingConnect();
    $sql = 'DELETE FROM  addresses 
                    WHERE addressType = :addressType 
                    ';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':addressType', $addressType, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();;
    $stmt->closeCursor();
    return $result;
}

// Get the checkout order details for the user 
function getCheckout($userId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM checkout 
                    JOIN cart_item ON cart_item.userId = checkout.userId
                    WHERE checkout.userId = :userId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

// Get the checkout order for the user 
function checkCheckout($userId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM checkout 
                    WHERE checkout.userId = :userId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

// Add an incomplete order that will be removed as soon as the 
// customer proceeds to buy the items by paying for this order, empties cart
// or when the user revises the order. Only one per user may be added
function addCheckoutOrder($userId, $checkoutDate){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            checkout (
                                userId, 
                                checkoutDate
                                ) 
                            VALUES (
                                :userId, 
                                :checkoutDate)'
                            );

    // Replace the place holders
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);
    $stmt->bindValue(':checkoutDate',$checkoutDate, PDO::PARAM_STR);    



    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();

    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// delete the incomplete order when the user revises
// it, deletes items in the cart, or completes the order
function deleteCheckoutOrder($userId){
      
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('DELETE FROM checkout WHERE userId = :userId');

    // Replace the place holder
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// Add an incomplete order that will be removed as soon as the 
// customer proceeds to buy the items by paying for this order, empties cart
// or when the user revises the order. Only one per user may be added
function addOrder($userId, $product_entryIds, $shipping_MethodId, $orderDate){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            orders (
                                userId, 
                                product_entryIds, 
                                shipping_MethodId, 
                                orderDate
                                ) 
                            VALUES (
                                :userId, 
                                :product_entryIds, 
                                :shipping_MethodId, 
                                :orderDate)'
                            );

    // Replace the place holders
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);
    $stmt->bindValue(':product_entryIds',$product_entryIds, PDO::PARAM_STR);
    $stmt->bindValue(':shipping_MethodId',$shipping_MethodId, PDO::PARAM_INT);    
    $stmt->bindValue(':orderDate',$orderDate, PDO::PARAM_STR);    

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();



    if($result){

        // Get number of affected rows
        $id = $db->lastInsertId();

        // The next line closes the interaction with the database 
        $stmt->closeCursor(); 

        return $id;

    }
}