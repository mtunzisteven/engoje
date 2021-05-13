<?php

// This is the images uload controller

session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/products-model.php';
require_once '../model/uploads-model.php';
require_once '../library/functions.php';


// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

/* * ****************************************************
* Variables for use with the Image Upload Functionality
* **************************************************** */

// directory name where uploaded images are stored
$image_dir = '/zalisting/images';

// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
 $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

switch ($action) {
    case 'upload':

    // Store the incoming product entry id and primary picture indicator
	$product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_VALIDATE_INT);
	$imagePrimary = filter_input(INPUT_POST, 'imagePrimary', FILTER_VALIDATE_INT);

    /*$fileName = 'file';
    $num = 0;
    do {

        $fileName .= $num;

        // Search for index with set file name
        if(isset($_FILES[$fileName])){
            $num = -1;
        }else{
            $num++;
        }

    } while ($num != -1);*/

	
    // Store the name of the uploaded image
    $imageName = $_FILES['file1']['name'];
    
    // Check the data base for any name matching this one
    $imageCheck = checkExistingImage($imageName);
        
    if($imageCheck){

        $message = '<p class="notice">An image by that name already exists.</p>';

    } elseif (empty($product_entryId) || empty($imageName)) {

        $message = '<p class="notice">You must add a product and image file for the product.</p>';

    } else {

        // Upload the image, store the returned path to the file
        $imagePath = uploadFile('file1');
            
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
        
    // Redirect to this controller for default action
    header('location: .');
    
    break;
    case 'delete':

    // Get the image name and id
    $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
    $imageId = filter_input(INPUT_GET, 'imageId', FILTER_VALIDATE_INT);


    $image = getProductThumbnail($imageId);

    //var_dump($image['imagePath_tn']); exit; 

        
    // Build the full path to the image and image thumbnail to be deleted
    $target = $image_dir_path . '/'. $filename;

    // careful to include $_SERVER['DOCUMENT ROOT'], other directory cannot be found
    $target_tn = $_SERVER['DOCUMENT_ROOT'] . $image['imagePath_tn']; 

    //var_dump($target); exit; 
        
    // Check that the file exists in that location
    if (file_exists($target)) {
        // Deletes the file in the folder
        $result = unlink($target); 
        $result_tn = unlink($target_tn);

        //var_dump($result); exit; 
    }
        
    // Remove from database only if physical file deleted
    if ($result) {
        $remove = deleteImage($imageId);
    }
        
    // Set a message based on the delete result
    if ($remove) {
        $message = "<p class='notice'>$filename was successfully deleted.</p>";
    } else {
        $message = "<p class='notice'>$filename was NOT deleted.</p>";
    }
        
    // Store message to session
    $_SESSION['message'] = $message;
        
    // Redirect to this controller for default action
    header('location: .');
    
    break;

    default:

    // Call function to return image info from database
    $imageArray = getImages();
        
    // Build the image information into HTML for display
    if (count($imageArray)) {
        $imageDisplay = buildImageDisplay($imageArray);
    } else {
        $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
    }
        
    if(isset($_SESSION['uploadForm'])){

        $uploadForm = $_SESSION['uploadForm'];

        unset($_SESSION['uploadForm']);
        
    }else{
        
        // Get products information from database 
        $products = getProducts();

        // Build a select list of products to upload an image for
        $productSelect = buildProductSelect($products);

        $uploadForm = buildImageUploadForm($productSelect);

    }

        
    include '../view/image-uploads.php';
    exit;
    
    break;
   }

