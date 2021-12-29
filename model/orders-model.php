<?php

// Add a single cart item for the user 
function getUserDetails($userId){
    $db = engojeConnect();
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
    $db = engojeConnect();
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
    $db = engojeConnect();
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
    $db = engojeConnect();
    $sql = 'SELECT order_items FROM orders WHERE orderId = :orderId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $items = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $items;
}

// update order items string for the order  
function updateOrderItemsAndTotal($orderId, $order_items, $numberOfItems){
    
    $db = engojeConnect();

    $sql = "UPDATE orders SET order_items=:order_items, numberOfItems=:numberOfItems WHERE orderId = :orderId";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->bindValue(':order_items', $order_items, PDO::PARAM_STR);
    $stmt->bindValue(':numberOfItems', $numberOfItems, PDO::PARAM_STR);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();

    return $rowsChanged;
}

// Get all orders  getCartQuantityForCheckout
function getOrders(){
    $db = engojeConnect();
    $sql = 'SELECT * FROM orders 
                    JOIN shipping_method ON orders.shippingId = shipping_method.shippingId
                    JOIN users ON orders.userId = users.userId
    ';

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($orders); exit;

    return $orders;
}

// delete the order using order id
function deleteOrder($orderId){
      
    // Create a connection object from the engoje connection function
    $db = engojeConnect(); 

    // The next line creates the prepared statement using the engoje connection      
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

// update order tracking 
function updateOrderStatus($orderId, $orderStatus){
    
    $db = engojeConnect();

    $sql = "UPDATE orders SET orderStatus=:orderStatus WHERE orderId = :orderId";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->bindValue(':orderStatus', $orderStatus, PDO::PARAM_STR);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();

    return $rowsChanged;
}

// update order tracking 
function updateOrderTracking($orderId, $orderTracking){
    
    $db = engojeConnect();

    $sql = "UPDATE orders SET orderTracking=:orderTracking WHERE orderId = :orderId";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->bindValue(':orderTracking', $orderTracking, PDO::PARAM_STR);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();

    return $rowsChanged;
}

// Get the checkout order for the user 
function checkCheckout($userId){
    $db = engojeConnect();
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
    $db = engojeConnect(); 
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
      
    // Create a connection object from the engoje connection function
    $db = engojeConnect(); 

    // The next line creates the prepared statement using the engoje connection      
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

// get shipping info for the shipping method 
function getShipping($shippingId){
    $db = engojeConnect();
    $sql = 'SELECT* FROM  shipping_method 
                    WHERE shippingId = :shippingId 
                    ';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':shippingId', $shippingId, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

// get shipping all methods 
function getShippingMethods(){
    $db = engojeConnect();
    $sql = 'SELECT* FROM  shipping_method ';

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}


// Add an incomplete order that will be removed as soon as the 
// customer proceeds to buy the items by paying for this order, empties cart
// or when the user revises the order. Only one per user may be added
function addOrder($userId, $order_items, $shippingId, $orderDate, $numberOfItems, $grandTotal){
    // Create a connection object from the zalist connection function
    $db = engojeConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            orders (
                                userId, 
                                order_items, 
                                shippingId, 
                                orderDate,
                                numberOfItems, 
                                grandTotal
                                ) 
                            VALUES (
                                :userId, 
                                :order_items, 
                                :shippingId, 
                                :orderDate,
                                :numberOfItems,
                                :grandTotal)'
                            );

    // Replace the place holders
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);
    $stmt->bindValue(':order_items',$order_items, PDO::PARAM_STR);
    $stmt->bindValue(':shippingId',$shippingId, PDO::PARAM_INT);   
    $stmt->bindValue(':numberOfItems',$numberOfItems, PDO::PARAM_INT); 
    $stmt->bindValue(':grandTotal',$grandTotal, PDO::PARAM_INT);         
    $stmt->bindValue(':orderDate',$orderDate, PDO::PARAM_STR);    

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();



    // if order created, pullmout its id
    if($result){

        // Get the id of the last row
        $id = $db->lastInsertId();

        // The next line closes the interaction with the database 
        $stmt->closeCursor(); 

        return $id;

    }
}

// update shipping and order total when relaoding checkout page
function updateShippingnGrandT($orderId, $shippingId, $grandTotal){
    $db = engojeConnect();

    $sql = "UPDATE orders SET shippingId=:shippingId, grandTotal=:grandTotal WHERE orderId = :orderId";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->bindValue(':shippingId', $shippingId, PDO::PARAM_INT);
    $stmt->bindValue(':grandTotal', $grandTotal, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();

    return $rowsChanged;
}

// The price per item on the db product_entry
function getProduct_entryAmount($product_entryId){
    $db = engojeConnect();

    $sql = "SELECT amount FROM product_entry WHERE product_entryId = :product_entryId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return  $result;
}

// The price per item on the db product_entry
function getCartEntriesForCheckout($userId){
    $db = engojeConnect();

    $sql = "SELECT* FROM cart_items
                    JOIN product_entry ON cart_items.product_entryId = product_entry.product_entryId
                    JOIN colour ON colour.colourId = product_entry.colourId
                    JOIN products ON products.productId = product_entry.productId
                    WHERE userId = :userId";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return  $result;
}

// The item quantity of an item in the cart
function getCartQuantityForCheckout($userId, $product_entryId){
    $db = engojeConnect();

    $sql = "SELECT cart_item_qty FROM cart_items
                    WHERE userId = :userId
                    AND product_entryId = :product_entryId";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return  $result;
}

// This is for updating product entry qty when shopper clicks pay now button
function updateQty($product_entryId, $amount){
    $db = engojeConnect();

    $sql = "UPDATE product_entry SET amount=:amount WHERE product_entryId = :product_entryId";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();

    return $rowsChanged;
}

// // This is for updating product entry qty when shopper clicks checkout button
// function reduceQty($product_entryId, $amount){
//     $db = engojeConnect();

//     $sql = "SELECT amount FROM product_entry
//             WHERE product_entryId = :product_entryId";

//     $stmt = $db->prepare($sql);
//     $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
//     $stmt->execute();
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);

//     $newQty = $result['amount'] - $amount;

//     $sql = "UPDATE product_entry SET amount= :newQty WHERE product_entryId = :product_entryId";
//     $stmt = $db->prepare($sql);
//     $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
//     $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
//     $stmt->bindValue(':newQty', $newQty, PDO::PARAM_INT);

//     $stmt->execute();
//     $rowsChanged = $stmt->rowCount(); 
//     $stmt->closeCursor();

//     return $rowsChanged;
// }

// This is for updating product entry qty when shopper clicks pay now button
function updateCheckoutCartQty($product_entryId, $amount, $userId){
    $db = engojeConnect();

    $sql = "UPDATE cart_items 
                            SET cart_item_qty=:amount 
                            WHERE product_entryId = :product_entryId
                            AND userId = :userId";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount(); 
    $stmt->closeCursor();

    return $rowsChanged;
}