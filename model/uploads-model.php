<?php

// This is the image management model

// Add image information to the database table
function storeImages($imagePath, $productId, $imageName, $imagePrimary) {
    $db = zalistingConnect();
    $sql = 'INSERT INTO images (productId, imagePath, imageName, imagePrimary) VALUES (:productId, :imagePath, :imageName, :imagePrimary)';
    $stmt = $db->prepare($sql);
    // Store the full size image information
    $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
    $stmt->bindValue(':imagePath', $imagePath, PDO::PARAM_STR);
    $stmt->bindValue(':imageName', $imageName, PDO::PARAM_STR);
    $stmt->bindValue(':imagePrimary', $imagePrimary, PDO::PARAM_INT);
    $stmt->execute();
        
    // Make and store the thumbnail image information
    // Change name in path
    $imagePath = makeThumbnailName($imagePath);
    // Change name in file name
    $imageName = makeThumbnailName($imageName);
    $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
    $stmt->bindValue(':imagePath', $imagePath, PDO::PARAM_STR);
    $stmt->bindValue(':imageName', $imageName, PDO::PARAM_STR);
    $stmt->bindValue(':imagePrimary', $imagePrimary, PDO::PARAM_INT);
    $stmt->execute();
    
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

// Get Image Information from images table
function getImages() {
    $db = zalistingConnect();
    $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invMake, invModel FROM images JOIN inventory ON images.invId = inventory.invId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
   }

// Get all thumbnails for a specific images from images table
function getVehicleThumbnails($invId){

    //echo $invId; exit;

    $db = zalistingConnect();
    $sql = "SELECT imgPath FROM images WHERE imgName LIKE '%\-tn%' AND invId=:invId"; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicleDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    //echo var_dump($vehicleDetails); exit;

    return $vehicleDetails;
}

   // Delete image information from the images table
function deleteImage($imgId) {
    $db = zalistingConnect();
    $sql = 'DELETE FROM images WHERE imgId = :imgId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
   }

   // Check for an existing image
function checkExistingImage($imgName){
    $db = zalistingConnect();
    $sql = "SELECT imgName FROM images WHERE imgName = :name";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    return $imageMatch;
   }