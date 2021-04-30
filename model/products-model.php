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
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.productId = images.productId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productsData); exit;

    return $productsData;
   }

// Get all products 
function getProduct($productId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.productId = images.productId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get all product sizes 
function getSizes(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM size';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productsizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productsizes); exit;

    return $productsizes;
}

// Get all product images 
function getImages(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM images';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productImages); exit;

    return $productImages;
}


// Get all product images 
function getColours(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM colour';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productColours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productColours); exit;

    return $productColours;
}

// Get all product images 
function getCategories(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM categories';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productCategories); exit;

    return $productCategories;
}

// Add a single category
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


