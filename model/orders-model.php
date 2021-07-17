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

// Get the order items string for the order 
function getOrderItems($orderId){
    $db = zalistingConnect();
    $sql = 'SELECT order_items FROM orders WHERE orderId = :orderId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $items = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $items;
}

// delete the order using order id
function deleteOrder($orderId){
      
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('DELETE FROM orders WHERE orderId = :orderId');

    // Replace the place holder
    $stmt->bindValue(':orderId',$orderId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
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
function addOrder($userId, $order_items, $shipping_MethodId, $orderDate){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            orders (
                                userId, 
                                order_items, 
                                shipping_MethodId, 
                                orderDate
                                ) 
                            VALUES (
                                :userId, 
                                :order_items, 
                                :shipping_MethodId, 
                                :orderDate)'
                            );

    // Replace the place holders
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);
    $stmt->bindValue(':order_items',$order_items, PDO::PARAM_STR);
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



// This is for updating product entry qty when shopper clicks pay now button
function updateQty($product_entryId, $amount){
    $db = zalistingConnect();

    //echo $product_entryId; exit;

    // first check that the qty is still available for the item wanted
    $sql = "SELECT amount FROM product_entry WHERE product_entryId = :product_entryId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $enoughStock = true;
    $orderAmount = $amount;

    // if there is stcok available
    if($result['amount'] > 0){

        // if stock is enough for the order
        if($result['amount'] >= $amount){

            $amount = $result['amount'] - $amount; // only remove order amount from the order

        }
        // if stock is avaolable but smaller than the order amount
        else if($result['amount'] < $amount){

            $amount = 0; // all amount available taken by order

            $orderAmount = $result['amount']; // specify amount in order

            $enoughStock = false; // speciify that stock was not enough


        }


        $sql = "UPDATE product_entry SET amount=:amount WHERE product_entryId = :product_entryId";
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);

        $stmt->execute();
        $rowsChanged = $stmt->rowCount(); 
        $stmt->closeCursor();

        //var_dump($rowsChanged+[$orderAmount, $enoughStock]); exit;

        return [$rowsChanged, $orderAmount, $enoughStock];

    }else{

        $enoughStock = false; // speciify that stock was not enough

        //var_dump([0, $orderAmount, $enoughStock]); exit;

        return [0, $orderAmount, $enoughStock]; // no stock

    }

}