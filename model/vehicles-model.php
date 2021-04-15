<?php 

//This is the vehicles model

function addClassification($new){
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 
    // The next line creates the prepared statement using the phpmotors connection      
    $stmt = $db->prepare('INSERT INTO carclassification (classificationName) VALUES (:classificationName)');
    // Replace the place holder
    $stmt->bindValue(':classificationName',$new, PDO::PARAM_STR);
    // The next line runs the prepared statement 
    $stmt->execute(); 
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 
   }

function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId){
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 
    // The next line creates the prepared statement using the phpmotors connection      
    $stmt = $db->prepare('INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId) VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)');
    // Replace the place holders
    $stmt->bindValue(':invMake',$invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel',$invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription',$invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage',$invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail',$invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice',$invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock',$invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor',$invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId',$classificationId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
   }

// Get car info using classification ids and Image Primary level
function getClassVehicles($classificationId, $imgPrimary){
    $db = phpmotorsConnect(); 
    $sql = "SELECT images.imgPath, inventory.invModel, inventory.invMake, inventory.invPrice, inventory.invId FROM images INNER JOIN inventory ON images.invId=inventory.invId WHERE images.imgName LIKE '%\-tn%' AND images.imgPrimary=:imgPrimary AND inventory.classificationId=:classificationId"; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT); 
    $stmt->execute(); 
    $classVehicles = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $classVehicles; 
}

// Get vehicle information by invId
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }

   // This function will update vehicles
   function updateVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $invId){
    
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 

    // The next line creates the prepared statement using the phpmotors connection      
    $stmt = $db->prepare('UPDATE inventory SET invMake = :invMake, 
                                                invModel = :invModel, 
                                                invDescription = :invDescription, 
                                                invImage = :invImage, 
	                                            invThumbnail = :invThumbnail, 
                                                invPrice = :invPrice, 
	                                            invStock = :invStock, 
                                                invColor = :invColor, 
	                                            classificationId = :classificationId
                            WHERE invId = :invId');

    // Replace the place holders
    $stmt->bindValue(':invMake',$invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel',$invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription',$invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage',$invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail',$invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice',$invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock',$invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor',$invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId',$classificationId, PDO::PARAM_INT);
    $stmt->bindValue(':invId',$invId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

  // This function will update vehicles
  function deleteVehicle($invId){
    
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 

    // The next line creates the prepared statement using the phpmotors connection      
    $stmt = $db->prepare('DELETE FROM inventory WHERE invId = :invId');

    // Replace the place holder
    $stmt->bindValue(':invId',$invId, PDO::PARAM_INT);

    // The next line runs the prepared statement 
    $stmt->execute(); 
    // Get number of affected rows
    $result = $stmt->rowCount();
    // The next line closes the interaction with the database 
    $stmt->closeCursor(); 

    return $result;
}

function getVehiclesByClassification($classificationName){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
}

function getVehicleDetails($invId){
    $db = phpmotorsConnect();
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
	$db = phpmotorsConnect();
	$sql = 'SELECT invId, invMake, invModel FROM inventory';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $invInfo;
}