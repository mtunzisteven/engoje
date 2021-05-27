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
                    WHERE images.imagePrimary = 1';
                    #GROUP BY product_entry.productId'; Uncomment to only show one product_entry per product on shop page
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $productData;
}

// Get products by common product Id
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

// Get one product entry
function getShopProductEntry($product_entryId){
    $db = zalistingConnect();
    $sql = 'SELECT product_entry.product_entryId, products.productId, products.productName, colour.colour, size.sizeValue, product_entry.price
                    FROM product_entry 
                    JOIN products ON product_entry.productId = products.productId
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

// Get one product by colour and id
function getColourSwatchShopProduct($productId, $colour){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN images ON product_entry.product_entryId = images.product_entryId
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId AND colour.colour = :colour';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}

// Get one product by colour, size, and id
function getSizeSwatchedShopProduct($productId, $colour, $size){
    $db = zalistingConnect();
    $sql = 'SELECT* FROM product_entry 
                    JOIN products ON product_entry.productId = products.productId
                    JOIN categories ON product_entry.categoryId = categories.categoryId
                    JOIN colour ON product_entry.colourId = colour.colourId
                    JOIN size ON product_entry.sizeId = size.sizeId
                    WHERE product_entry.productId = :productId AND colour.colour = :colour AND size.sizeValue = :size';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productId',$productId, PDO::PARAM_INT);
    $stmt->bindValue(':colour',$colour, PDO::PARAM_STR);
    $stmt->bindValue(':size',$size, PDO::PARAM_STR);
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
    
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
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

// Add a single cart item for the user 
function addWishlistItem($userId, $product_entryId, $imagePath_tn, $dateAdded){
    // Create a connection object from the zalist connection function
    $db = zalistingConnect(); 
    // The next line creates the prepared statement using the zalist connection      
    $stmt = $db->prepare('INSERT INTO 
                            wishlist_items (
                                userId, 
                                product_entryId, 
                                imagePath_tn,
                                dateAdded
                                ) 
                            VALUES (
                                :userId, 
                                :product_entryId, 
                                :imagePath_tn,
                                :dateAdded)'
                            );

    // Replace the place holders    
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
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
function getWishlistItems($userId){
    $db = zalistingConnect();
    $sql = 'SELECT * FROM wishlist_items 
                    JOIN product_entry ON product_entry.product_entryId = wishlist_items.product_entryId
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

function getWishlistItemByUser($product_entryId, $userId){
    
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('SELECT* FROM wishlist_items WHERE product_entryId = :product_entryId AND userId = :userId');

    // Replace the place holder
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':userId',$userId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// get wishlist by user id and id
function deleteWishlistItem($product_entryId, $userId){
      
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('DELETE FROM wishlist_items WHERE product_entryId = :product_entryId AND userId = :userId');

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

function deleteWishlistItems($userId){
      
    // Create a connection object from the zalisting connection function
    $db = zalistingConnect(); 

    // The next line creates the prepared statement using the zalisting connection      
    $stmt = $db->prepare('DELETE FROM wishlist_items WHERE userId = :userId');

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

// Get swatch images for a single product entry by product entry Id
function getSwatchImages($product_entryId){
    $db = zalistingConnect();
    $sql = 'SELECT imagePath, imagePath_tn FROM images 
                    WHERE product_entryId = :product_entryId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId',$product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //var_dump($productData); exit;

    return $productData;
}