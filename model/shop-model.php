<?php 

//  

// Get one product entry by id
function getShopProducts(){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE images.imagePrimary = 1
                    GROUP BY size.sizeId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get one product 
function getShopProduct($productId){
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
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get one product for swatches 
function getShopSwatchProduct($productId){
    $db = zalistingConnect();
    $sql = 'SELECT size.sizeValue, colour FROM product_entry 
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get vehicles by categoryId 
function getProductByCategory($categoryId){ 
    $db = zalistingConnect(); 
    $sql = ' SELECT * FROM product WHERE categoryId = :categoryId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $product; 
   }

// Get car info using category ids and Image Primary level
function getCategoryProduct($categoryId, $imgPrimary){
    $db = zalistingConnect(); 
    $sql = "SELECT images.imgPath, inventory.invModel, inventory.invMake, inventory.invPrice, inventory.invId FROM images INNER JOIN inventory ON images.invId=inventory.invId WHERE images.imgName LIKE '%\-tn%' AND images.imgPrimary=:imgPrimary AND inventory.classificationId=:classificationId"; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT); 
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT); 
    $stmt->execute(); 
    $categoryProduct = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $categoryProduct; 
}

// Get product information by productId
function getProductItemInfo($productId){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM products WHERE productId = :productId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $productInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $productInfo;
   }

// This function will update product
function updateProduct($productName, $productPrice, $productDescription, $productCreationDate, $reviewId, $variationId, $categoryId){
    
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('UPDATE inventory SET $productName, $productPrice, $productDescription, $productCreationDate, $reviewId, $variationId, $categoryId WHERE productId = :productId');

    // Replace the place holders
    $stmt->bindValue(':productName',$productName, PDO::PARAM_STR);
    $stmt->bindValue(':productPrice',$productPrice, PDO::PARAM_STR);
    $stmt->bindValue(':productDescription',$productDescription, PDO::PARAM_STR);
    $stmt->bindValue(':productCreationDate',$productCreationDate, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId',$reviewId, PDO::PARAM_STR);
    $stmt->bindValue(':variationId',$variationId, PDO::PARAM_STR);
    $stmt->bindValue(':categoryId',$categoryId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// This function will update product
function deleteProduct($productId){
    
    // Create a connection object from the phpmotors connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the phpmotors connection      
    $stmt = $db->prepare('DELETE FROM products WHERE productId = :productId');

    // Replace the place holder
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

function getProductsByCategory($categoryName){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM products WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :categoryName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

/*
function getVehicleDetails($invId){
    $db = zalistingConnect();
    $sql = "SELECT images.imgPath, inventory.invModel, inventory.invMake, inventory.invPrice, inventory.invId, inventory.invStock, inventory.invDescription, inventory.invId FROM images INNER JOIN inventory ON images.invId=inventory.invId WHERE images.imgName NOT LIKE '%\-tn%' AND inventory.invId=:invId"; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicleDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicleDetails;
}


// Get information for all vehicles
function getVehicles(){
	$db = zalistingConnect();
	$sql = 'SELECT invId, invMake, invModel FROM inventory';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $invInfo;
}

*/