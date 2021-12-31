<?php

// This is the main-model for engoje

function getSearchItems($searchTerm){
 // Create a connection object from the phpmotors connection function
 $db = engojeConnect(); 

    if(is_numeric($searchTerm)){

        intval($searchTerm);

        // The SQL statement to be used with the database 
        $sql = 'SELECT* FROM product_entry 
                        JOIN products ON products.productId = product_entry.productId
                        JOIN images ON images.product_entryId = product_entry.product_entryId
                        JOIN colour ON colour.colourId = product_entry.colourId
                        JOIN size ON size.sizeId = product_entry.sizeId
                        WHERE (product_entry.product_entryId = :searchTerm OR product_entry.price = :searchTerm) AND images.imagePrimary = 1
                        '; 
        // The next line creates the prepared statement using the phpmotors connection      
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':searchTerm',$searchTerm, PDO::PARAM_INT);

        // The next line runs the prepared statement 
        $stmt->execute(); 
        // The next line gets the data from the database and 
        // stores it as an array in the $searchItems variable 
        $searchItems = $stmt->fetchAll(); 
        // The next line closes the interaction with the database 
        $stmt->closeCursor(); 
        // The next line sends the array of data back to where the function 
        // was called (this should be the controller) 
        return $searchItems;
        
    }else{

        $searchTerm = "%".$searchTerm."%";

        // The SQL statement to be used with the database 
        $sql = 'SELECT* FROM product_entry 
                        JOIN images ON images.product_entryId = product_entry.product_entryId
                        JOIN products ON products.productId = product_entry.productId
                        JOIN colour ON colour.colourId = product_entry.colourId
                        JOIN size ON size.sizeId = product_entry.sizeId
                        WHERE (products.productName LIKE :searchTerm OR products.productShortDescr LIKE :searchTerm OR products.productDescription LIKE :searchTerm) AND images.imagePrimary = 1
                        '; 

        // The next line creates the prepared statement using the phpmotors connection      
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':searchTerm',$searchTerm, PDO::PARAM_STR);

        // The next line runs the prepared statement 
        $stmt->execute(); 
        // The next line gets the data from the database and 
        // stores it as an array in the $searchItems variable 
        $searchItems = $stmt->fetchAll(); 
        // The next line closes the interaction with the database 
        $stmt->closeCursor(); 
        // The next line sends the array of data back to where the function 
        // was called (this should be the controller) 

        return $searchItems;

    }
}
