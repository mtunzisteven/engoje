<?php

//This model is for the Products 

// Add a single product meta
function addProduct($productName, $productShortDescr, $productDescription, $productCreationDate){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
            
            products (
                productName, 
                productShortDescr, 
                productDescription, 
                productCreationDate) 
            VALUES (
                :productName, 
                :productShortDescr, 
                :productDescription, 
                :productCreationDate)');

    // Replace the place holders
    $stmt->bindValue(':productName',$productName, PDO::PARAM_STR);
    $stmt->bindValue(':productShortDescr',$productShortDescr, PDO::PARAM_STR);
    $stmt->bindValue(':productDescription',$productDescription, PDO::PARAM_STR);
    $stmt->bindValue(':productCreationDate',$productCreationDate, PDO::PARAM_STR);


    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();

    //echo $result; exit;

    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// Add acual product with qty and price
function addProductEntry($productId, $sizeId, $colourId, $categoryId, $price, $sku, $amount){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
            
            product_entry (
                productId, 
                sizeId, 
                colourId, 
                categoryId,
                price,
                sku,
                amount
                ) 
            VALUES (
                :productId, 
                :sizeId, 
                :colourId, 
                :categoryId,
                :price,
                :sku,
                :amount)'
            );

    // Replace the place holders
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->bindValue(':sizeId',$sizeId, PDO::PARAM_INT);
    $stmt->bindValue(':colourId',$colourId, PDO::PARAM_INT);
    $stmt->bindValue(':categoryId',$categoryId, PDO::PARAM_INT);
    $stmt->bindValue(':price',$price, PDO::PARAM_INT);
    $stmt->bindValue(':sku',$sku, PDO::PARAM_STR);    
    $stmt->bindValue(':amount',$amount, PDO::PARAM_INT);



    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();

    //echo $result; exit;

    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}


// Get all products 
function getProducts(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
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

// Get one product 
function getProduct($productId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
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

// Get one product entry by id
function getProduct_entry($product_entryId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.product_entryId = :product_entryId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get the largest product id 
function getLastProductId(){
    $db = zalistingConnect();
    $sql = 'SELECT productId FROM products ORDER BY productId DESC LIMIT 0, 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productId = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productId); exit;

    return $productId;
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

// Get size Id by name
function getSizeId($sizeValue){
    $db = zalistingConnect();
    $sql = 'SELECT sizeId FROM size WHERE sizeValue = :sizeValue';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sizeValue',$sizeValue, PDO::PARAM_STR);
    $stmt->execute();
    $sizeId = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($sizeId); exit;

    return $sizeId;
}

// Get colour Id by name
function getColourId($colour){
    $db = zalistingConnect();
    $sql = 'SELECT colourId FROM colour WHERE colour = :colour';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->execute();
    $colourId = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($colourId); exit;

    return $colourId;
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

// Get colours by ids images 
function getColourById($colourId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM colour WHERE colourId = :colourId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colourId',$colourId, PDO::PARAM_STR);
    $stmt->execute();
    $productColours = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productColours); exit;

    return $productColours;
}

// Get sizes by ids images 
function getSizeById($sizeId){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM size WHERE sizeId = :sizeId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sizeId',$sizeId, PDO::PARAM_STR);
    $stmt->execute();
    $productColours = $stmt->fetch(PDO::FETCH_ASSOC);
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


