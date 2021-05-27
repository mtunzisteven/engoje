<?php

// Add a single cart item for the user 
function addCartItem($product_entryId, $cart_item_qty, $userId, $imagePath_tn, $dateAdded){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            cart_items (
                                product_entryId, 
                                cart_item_qty, 
                                userId, 
                                imagePath_tn,
                                dateAdded
                                ) 
                            VALUES (
                                :product_entryId, 
                                :cart_item_qty, 
                                :userId, 
                                :imagePath_tn,
                                :dateAdded)'
                            );

    // Replace the place holders
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':cart_item_qty',$cart_item_qty, PDO::PARAM_INT);
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);
    $stmt->bindValue(':imagePath_tn',$imagePath_tn, PDO::PARAM_STR);
    $stmt->bindValue(':dateAdded',$dateAdded, PDO::PARAM_STR);    



    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();

    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// get the cart items for the specified user
function getCartItems($userId){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM cart_items 
                    JOIN product_entry ON product_entry.product_entryId = cart_items.product_entryId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN products ON product_entry.productId = products.productId
                    WHERE userId = :userId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

// update cart item quantity
function updateCartQty($cart_itemId, $cart_item_qty){

        // Create a connection object from the zalist connection function
        $db = zalistingConnect(); 

        // The next line creates the prepared statement using the zalist connection      
        $stmt = $db->prepare('UPDATE cart_items SET cart_item_qty = :cart_item_qty WHERE cart_itemId = :cart_itemId');
    
        // Replace the place holders
        $stmt->bindValue(':cart_itemId',$cart_itemId, PDO::PARAM_INT);
        $stmt->bindValue(':cart_item_qty',$cart_item_qty, PDO::PARAM_INT);
    
        // The next line runs the prepared statement 
        $stmt->execute(); 
        // Get number of affected rows
        $result = $stmt->rowCount();
        // The next line closes the interaction with the database 
        $stmt->closeCursor(); 
    
        return $result;

}

function deleteCartItem($product_entryId, $userId){
      
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('DELETE FROM cart_items WHERE product_entryId = :product_entryId AND userId = :userId');

    // Replace the place holder
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

function deleteCartItems($userId){
      
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('DELETE FROM cart_items WHERE userId = :userId');

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