<?php

//This model is for the Products 

// Add a single simple or variable product
function addProduct($productName, $productPrice, $productShortDescr, $productCategory, $productDescription, $productQty, $productCreationDate, $reviewId, $variationId){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO products (productName, productPrice, productShortDescr, productCategory, productDescription, productCreationDate, productQty, reviewId, variationId, categoryId) VALUES (:productName, :productPrice, :productShortDescr, :productCategory, :productDescription, :productCreationDate, :productQty, :reviewId, :variationId, :categoryId');
    // Replace the place holders
    $stmt->bindValue(':productName',$productName, PDO::PARAM_STR);
    $stmt->bindValue(':productPrice',$productPrice, PDO::PARAM_INT);
    $stmt->bindValue(':productShortDescr',$productShortDescr, PDO::PARAM_STR);
    $stmt->bindValue(':productCategory',$productCategory, PDO::PARAM_STR);
    $stmt->bindValue(':productDescription',$productDescription, PDO::PARAM_STR);
    $stmt->bindValue(':productCreationDate',$productCreationDate, PDO::PARAM_STR);
    $stmt->bindValue(':productQty',$productQty, PDO::PARAM_INT);
    $stmt->bindValue(':reviewId',$reviewId, PDO::PARAM_STR);
    $stmt->bindValue(':variationId',$variationId, PDO::PARAM_STR);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// Get all products 
function getProducts(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM products JOIN images WHERE products.productId = images.productId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $userData;
   }

//
//This is the shop model

function addCategory($categoryId, $categoryParent){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO categories (categoryId, categoryParent) VALUES (:categoryId, :categoryParent)');
    // Replace the place holder
    $stmt->bindValue(':categoryId',$categoryId, PDO::PARAM_STR);
    $stmt->bindValue(':categoryParent',$categoryParent, PDO::PARAM_STR);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 
   }


