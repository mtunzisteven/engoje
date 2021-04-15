<?php

// Add review to the database table
function addReviews($userId, $invId, $reviewText, $reviewDate) {
    $db = zalistingConnect();
    $sql = 'INSERT INTO reviews (reviewText,reviewDate, invId, userId) VALUES (:reviewText, :reviewDate, :invId, :userId)';
    $stmt = $db->prepare($sql);

    // Store the full size image information
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->execute();
    
    // Get the total amount of rows that have been updated
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

// Get review information from reviews by inventory
function getInventoryReviews($invId) {
    $db = zalistingConnect();
    $sql = 'SELECT reviewText, reviewDate, reviewId, reviews.userId, users.userFirstname, users.userLastname  FROM  reviews JOIN users ON reviews.userId=users.userId WHERE reviews.invId=:invId ORDER BY reviews.reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //echo $reviewsArray[0]['userId']; exit;

    $stmt->closeCursor();
    return $reviewsArray;
   }


// Get review information from reviews table by user
function getUserReviews($userId) {
    $db = zalistingConnect();
    $sql = 'SELECT reviewText, reviewDate, reviewId, users.userFirstname, users.userLastname  FROM  reviews JOIN users ON reviews.userId=users.userId WHERE reviews.userId=:userId ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewsArray;
   }

// Get review Text from reviews table by review Id
function getUpdateReview($reviewId) {
    $db = zalistingConnect();
    $sql = 'SELECT reviewText  FROM  reviews WHERE reviewId= :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewsArray = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewsArray;
   }


// Update review Text from reviews table by review Id
function updateReview($reviewId, $reviewText) {
    $db = zalistingConnect();
    $sql = 'UPDATE reviews SET reviewText= :reviewText  WHERE reviewId= :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
   }

// Delete review Text from reviews table by review Id
function deleteReview($reviewId) {
    $db = zalistingConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
   }
