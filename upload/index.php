<?php

// session expire reset: 180 sec
session_cache_expire();

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

// active tab array
$_SESSION['active_tab'] = $active_tabs;

// directory name where uploaded images are stored
$image_dir = '/engoje/images';

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
            $message = '<p class="notice">The upload succeeded.</p>';
        } else {
            $message = '<p class="notice">Sorry, the upload failed.</p>';
        }
    }
      
    // Store message to session
    $_SESSION['message'] = $message;
        
    // Redirect to this controller for default action
    header('location: .');
    
    break;

    // This is handled via Ajax request: uploads.js
    // For uploading primary images in product creation
    case 'new-upload':

        // directory name where uploaded images are stored
        $image_dir = '/engoje/images';

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
            } else {
                echo '<p class="notice">Sorry, the upload failed.</p>';
            }
        }

        break;

    case 'multi-upload':

        // directory name where uploaded images are stored
        $image_dir = '/engoje/images';

        // The path is the full path from the server root
        $image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;


        $product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_VALIDATE_INT);
        $imagePrimary = filter_input(INPUT_POST, 'imagePrimary', FILTER_VALIDATE_INT);

        $result = 0; // this will serve as the count for every image uploaded.

        for($i = 0; $i < count($_FILES['file']['name']); $i++){

            //echo $files['file']['name']; break;

            // Store the name of the uploaded image
            $imageName = $_FILES['file']['name'][$i];

            // Check the data base for any name matching this one
            $imageCheck = checkExistingImage($imageName);
                
            if($imageCheck){

                $message = '<p class="notice">An image by that name already exists.</p>';

            } elseif (empty($product_entryId) || empty($imageName)) {

                $message = '<p class="notice">You must add a product and image file for the product.</p>';

            } else {

                // Upload the image, store the returned path to the file
                $imagePath = uploadFiles('file', $i);
                    
                // Insert the image information to the database, get the result
                $result += storeImages($imagePath, $product_entryId, $imageName, $imagePrimary);
                    
                // Set a message based on the insert result

            }

        }

        if ($result == count($_FILES['file']['name'])) {

            echo '<p class="notice">Uploaded files successfully.</p>';
        } else {
            echo '<p class="notice">Sorry, the uploads failed.</p>';
        }

        break;

case 'delete':

    // Get the image name and id
    $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
    $imageId = filter_input(INPUT_GET, 'imageId', FILTER_VALIDATE_INT);

    // get the thumnail of the product to be deleted
    $image = getProductThumbnail($imageId);
        
    // Build the full path to the image and image thumbnail to be deleted
    $target = $image_dir_path . '/'. $filename;

    // careful to include $_SERVER['DOCUMENT ROOT'], other directory cannot be found
    $target_tn = $_SERVER['DOCUMENT_ROOT'] . $image['imagePath_tn']; 
        
    // Check that the file exists in that location
    if (file_exists($target)) {

        // Deletes the files in the folder
        $result = unlink($target); 
        $result_tn = unlink($target_tn);

    }
        
    // Remove from database only if physical file deleted
    // and no other product entry in the product id
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

    // active tab array for adminSidenav
    $_SESSION['active_tab']['images'] = "active";

    // Get the side navs library
    require_once '../library/sidenav.php';
    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    // Call function to return image info from database
    $imageArray = getImages();
        
    // Build the image information into HTML for display
    if (count($imageArray)) {
        $imageDisplay = buildImageDisplay($imageArray);
    } else {
        $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
    }
        
    //var_dump($_SESSION['uploadForms']); exit;
    // use new product image form when uploading image with product
    if(isset($_SESSION['uploadForms'])){

        $uploadForms = $_SESSION['uploadForms'];

        unset($_SESSION['uploadForms']);

        include '../view/image-uploads.php';
        exit;
        
    }else{ // Otherwise, use the normal apload process where you choose the product that is already uploaded.
        
        // Get products information from database 
        $products = getViewableProducts();

        // Build a select list of products to upload an image for
        $productSelect = buildProductSelect($products);

        // Only one form to display
        $uploadForms = buildImageUploadForm($productSelect);

        //var_dump($uploadForms); exit;

        include '../view/image-manager.php';
        exit;

    }
    
    break;
   }

