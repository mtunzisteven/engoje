<?php

// This is the image management model

// Add image information to the database table
function storeImages($imagePath, $product_entryId, $imageName, $imagePrimary) {
    $db = zalistingConnect();
    $sql = 'INSERT INTO images (product_entryId, imagePath, imageName, imagePrimary) VALUES (:product_entryId, :imagePath, :imageName, :imagePrimary)';
    $stmt = $db->prepare($sql);
    // Store the full size image information
    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':imagePath', $imagePath, PDO::PARAM_STR);
    $stmt->bindValue(':imageName', $imageName, PDO::PARAM_STR);
    $stmt->bindValue(':imagePrimary', $imagePrimary, PDO::PARAM_INT);
    $stmt->execute();
        
    // Make and store the thumbnail image information
    // Change name in path
    $imagePath = makeThumbnailName($imagePath);
    // Change name in file name
    // $imageName = makeThumbnailName($imageName);

    $sql = 'UPDATE images SET imagePath_tn = :imagePath WHERE product_entryId = :product_entryId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':imagePath', $imagePath, PDO::PARAM_STR);
    $stmt->execute();
    
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

// Get Image Information from images table
function getImages() {
    $db = zalistingConnect();
    $sql = 'SELECT imageId, imagePath, imageName, product_entryId FROM images';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
   }

// Get all thumbnails for a specific images from images table
function getProductThumbnail($imageId){ 

    //echo $invId; exit;

    $db = zalistingConnect();
    $sql = "SELECT imagePath_tn FROM images WHERE imageId=:imageId"; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
    $stmt->execute();
    $ProductThumbnail = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //echo var_dump($ProductThumbnail); exit;

    return $ProductThumbnail;
}

   // Delete image information from the images table
function deleteImage($imageId) {
    $db = zalistingConnect();
    $sql = 'DELETE FROM images WHERE imageId = :imageId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
   }

   // Check for an existing image
function checkExistingImage($imageName){
    $db = zalistingConnect();
    $sql = "SELECT imageName FROM images WHERE imageName = :imageName";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imageName', $imageName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    return $imageMatch;
   }