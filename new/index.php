<?php


if(!empty($_POST)){
    
    
// This is the images uload controller

session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/products-model.php';
require_once '../model/uploads-model.php';
require_once '../library/functions.php';

/* * ****************************************************
* Variables for use with the Image Upload Functionality
* **************************************************** */

// directory name where uploaded images are stored
$image_dir = '/zalisting/images';

// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;


$product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_VALIDATE_INT);
$imagePrimary = filter_input(INPUT_POST, 'imagePrimary', FILTER_VALIDATE_INT);

// Store the name of the uploaded image
$imageName = $_FILES['file']['name'];

// Check the data base for any name matching this one
$imageCheck = checkExistingImage($imageName);
    
if($imageCheck){

    $message = '<p class="notice">An image by that name already exists.</p>';

} elseif (empty($product_entryId) || empty($imageName)) {

    $message = '<p class="notice">You must add a product and image file for the product.</p>';

} else {

    // Upload the image, store the returned path to the file
    $imagePath = uploadFile('file');
        
    // Insert the image information to the database, get the result
    $result = storeImages($imagePath, $product_entryId, $imageName, $imagePrimary);
        
    // Set a message based on the insert result
    if ($result) {
        echo '<p class="notice">The upload succeeded.</p>';
        exit;
    } else {
        $message = '<p class="notice">Sorry, the upload failed.</p>';
    }
}
    
// Store message to session
$_SESSION['message'] = $message;

}else{
    echo "Error! There was a problem adding your image. Please try again, or consult maintenance."; 
}
