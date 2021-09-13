<?php

// Add review to the database table
function addReviews($userId, $product_entryId, $productRating, $reviewText, $reviewDate) {
    $db = engojeConnect();
    $sql = 'INSERT INTO reviews (reviewText,reviewDate, productRating, product_entryId, userId) VALUES (:reviewText, :reviewDate, :productRating, :product_entryId, :userId)';
    $stmt = $db->prepare($sql);

    // Store the full size image information
    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':productRating', $productRating, PDO::PARAM_INT);
    $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->execute();
    
    // Get the total amount of rows that have been updated
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

// Get review information from reviews by product_entryId
function getProductReviews($product_entryId) {
    $db = engojeConnect();

    $sql = 'SELECT reviewText, 
                   reviewDate, 
                   reviewId, 
                   productRating, 
                   reviews.userId, 
                   users.userFirstname, 
                   users.userLastname  
                   FROM  reviews 
                   JOIN users ON reviews.userId=users.userId 
                   WHERE reviews.product_entryId=:product_entryId 
                   ORDER BY reviews.reviewDate DESC';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_entryId', $product_entryId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    return $reviewsArray;
   }


// Get review information from reviews table by user
function getUserReviews($userId) {
    $db = engojeConnect();

    $sql = 'SELECT reviewText, 
                   reviewDate, 
                   reviewId,
                   productRating, 
                   users.userFirstname, 
                   users.userLastname  
                   FROM  reviews 
                   JOIN users ON reviews.userId=users.userId 
                   WHERE reviews.userId=:userId 
                   ORDER BY reviewDate DESC';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewsArray;
   }

// Get review Text from reviews table by review Id
function getReview($reviewId) {
    $db = engojeConnect();
    $sql = 'SELECT reviewText, productRating  FROM  reviews WHERE reviewId= :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewsArray = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewsArray;
   }


// Update review Text from reviews table by review Id
function updateReview($reviewId, $reviewText, $productRating) {
    $db = engojeConnect();
    $sql = 'UPDATE reviews, productRating SET reviewText= :reviewText & productRating= :productRating  WHERE reviewId= :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':productRating', $productRating, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
   }

// Delete review Text from reviews table by review Id
function deleteReview($reviewId) {
    $db = engojeConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
   }
