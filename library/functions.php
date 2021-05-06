<?php

function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);

 return $valEmail;
}

// Check the password for a minimum of 8 characters,
 // at least one 1 capital letter, at least 1 number and
 // at least 1 special character
function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

//CHeck that the price is entered as a float
function checkPrice($invPrice){
    $pattern = '/\d+(\.\d{2})?/';
    return preg_match($pattern, $invPrice);
}

//  Build Admin Side Nav display
function buildAdminSideNav(){

    $adminSideNav = "<ul class='dashboard-side-nav'>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/admin' class='dashboard-side-nav-links dashboard-main-link'>DASHBOARD</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/admin/?action=account' class='dashboard-side-nav-links'>My Account</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/products/?action=product' class='dashboard-side-nav-links'>Products</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/admin/?action=users' class='dashboard-side-nav-links'>Accounts</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Orders</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Reviews</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Sales</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Reports</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Logs</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links' href='/zalisting/accounts/index.php?action=logout'>Logout</a></li>";
    $adminSideNav .= "</ul>";

    return $adminSideNav;
}


// Build a multi user display view
function buildUsersDisplay($users){

    $userRows = [];

    foreach($users as $user){

        $userRows[] = "<tr class='user-display-info'> <td><a class='button account-button' href='/zalisting/admin/?action=user&userId=$user[userId]'>update</a> </td>  <td>$user[userFirstName] $user[userLastName]</td> <td>$user[userEmail]</td> <td>0$user[userPhone]</td> </tr>";
    }

   return $userRows;
  }

// Build a multi product display table on admin dashboard
function buildAdminProductsDisplay($products){

    $userRows = [];

    foreach($products as $product){

        $userRows[] = "<tr class='user-display-info'> <td class=td-buttons ><a class='button account-button' href='/zalisting/products/?action=update&productId=$product[productId]'>update</a> <a class='button account-button' href='/zalisting/products/?action=delete&productId=$product[productId]'>delete</a> </td><td><img class=image-tn src=/zalisting/images/$product[imagePath_tn] /></td>  <td>$product[productName] </td> <td>$product[sizeValue]</td> <td>$product[colour]</td> <td>0$product[sku]</td> </tr>";
    }

   return $userRows;
  }


//  Build User Update Admin Nav display
function buildUserUpdateNav(){

    $accountUser = "";

    if(isset($_SESSION['updatinguserId'])){
        $accountUser = $_SESSION['updatinguserId'];
    }

    $updateNav ="<ul class='user-update'>";    
    $updateNav .="<li class='user-update-item' ><a href='/zalisting/admin/?action=user&userId=$accountUser'>Personal</a></li>";
    $updateNav .="<li class='user-update-item' ><a href='/zalisting/admin/?action=address'>Addresses</a></li>";
    $updateNav .="<li class='user-update-item' ><a href=''>Orders</a></li>";
    $updateNav .="<li class='user-update-item' ><a href=''>Returns</a></li>";
    $updateNav .="</ul>";

    return $updateNav;
}


// Build a single user display view
function buildUserDisplay($userInfo){

    $userDisplay = "<form method='POST' action='/zalisting/admin/'>";

    $userDisplay .= "<label>First Name</label><input type='text' name='userFirstName' value='$userInfo[userFirstName]' />";
    $userDisplay .= "<label>Last Name</label><input type='text' name='userLastName' value='$userInfo[userLastName]' />";
    $userDisplay .= "<label>Email</label><input type='text' name='userEmail' value='$userInfo[userEmail]' />";
    $userDisplay .= "<label>Phone Number</label><input type='tel' name='userPhone' value='0$userInfo[userPhone]' />";
    $userDisplay .= "<input class='button account-button' type='submit' value='submit' />";
    $userDisplay .= "<input type='hidden' name='action' value='update-user' />";
    $userDisplay .= "<input type='hidden' name='userId' value='$userInfo[userId]' />";


    $userDisplay .= "</form>";


   return $userDisplay;
  }

// Build a Address adding or update form view
function buildAddressForm($address, $addressFound){

    //var_dump($addresses); exit;

    // This will potentially have 2 addresses but is an array none the less
    // So we must loop through regardless how many addresses exist, 
    // the if statements will give us the variable value we want for action

    // When no address exists
    if($addressFound==false){

        $action = 'new-address';
        
        // Set address type to be able to make readonly value of 1
        $addressType = 1;

        // Set address db variables to empty strings
        $addressLineOne = "";
        $addressLineTwo = "";
        $addressCity = "";
        $addressZipCode = "";


    }else if($addressFound==true){//When there is atleast one address found

        $action = 'update-address';

        // Set actual address db variables to their valules

        $addressLineOne = $address['addressLineOne'];
        $addressLineTwo = $address['addressLineTwo'];
        $addressCity = $address['addressCity'];
        $addressZipCode = $address['addressZipCode'];
        $addressType = $address['addressType'];

    }

    //echo $action; exit;
    $form = "<form method='POST' action='/zalisting/admin/?action=$action'>";
    $form .= "<label>Address Line 1</label><input type=text name=addressLineOne value='$addressLineOne' />";
    $form .= "<label>Address Line 2</label><input type=text name=addressLineTwo value='$addressLineTwo' />";
    $form .= "<label>City</label><input type=text name=addressCity value='$addressCity' />";
    $form .= "<label>Zip Code</label><input type=text name=addressZipCode value='$addressZipCode' />";
    $form .= "<input type=hidden name=addressType value='$addressType' />";
    $form .= "<input class=button account-button type=submit value=submit />";
    $form .= "</form>";

    //var_dump($addressType); exit;

    return $form;
  }

//  Build Address display
function buildAddresses($addresses, $addressFound){

    //var_dump($addresses); exit;
    
    $address ="<div class='dashboard-details-addresses'>";

    if($addressFound==false){
        $address .="<div class='dashboard-details-address'>"; 
        $address .="<p class='detail-span-bold'><strong>Billing Address</strong></p>"; 
        $address .="<p class='detail-span-bold' >No address added...</p>";
        $address .="</div>";
        $address .="<div class='dashboard-details-address'>"; 
        $address .="<p class='detail-span-bold'><strong>Shipping Address</strong></p>"; 
        $address .="<p class='detail-span-bold' >No address added...</p>";
        $address .="</div>";
    }else{ 
        foreach($addresses as $eachAddress){

            if($eachAddress['addressType']==1){
                $address .="<div class='dashboard-details-address'>"; 
                $address .="<p class='detail-span-bold'><strong>Billing Address</strong></p>"; 
                $address .="<p class='detail-span-bold' >".$eachAddress['addressLineOne']."</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressLineTwo]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressCity]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressZipCode]</p>";
                $address .="<a class='button account-button center' href='/zalisting/admin/?action=replace-address&addressType=1'>update</a>";
                $address .="</div>";
            }

            else if($eachAddress['addressType']==2){

                //var_dump($eachAddress['addressType']); exit;

                $address .="<div class='dashboard-details-address'>"; 
                $address .="<p class='detail-span-bold'><strong>Shipping Address</strong></p>"; 
                $address .="<p class='detail-span-bold' >$eachAddress[addressLineOne]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressLineTwo]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressCity]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressZipCode]</p>";
                $address .="<a class='button account-button center' href='/zalisting/admin/?action=replace-address&addressType=2'>update</a>";
                $address .="</div>";
            }
        }
    }


    $address .="</div>";

    //var_dump($address); exit;

    return $address;
}

function buildNav($classifications){
    // Build a navigation bar using the $classifications array
    $navList = '<ul>';
    $navList .= "<li><a class=\"links\" href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
    $navList .= "<li><a class=\"links\" href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';

    return $navList;

}

// Build the classifications select list for size and color
function buildTableList($table, $tableItemId, $tableItemName ){ 

    // TableItemId and tavleItemName are both strings to be entered at function call (buildProductUpdateDisplay)
    // eg for categories table:
        // TableItemId = categoryId
        // TableItemName = categoryName

        

    $tableList = "<select name=$tableItemId id=tableList >"; 
    $tableList .= "<option>Choose From List</option>"; 
    foreach ($table as $Item) { 

        if(isset($Item['colour'])){
            $tableList .= "<option style='background:$Item[colour];padding: 4px; margin:3px; border-radius:5px;' value='$Item[$tableItemId]'>$Item[$tableItemName]</option>"; 
        }else{
            $tableList .= "<option value='$Item[$tableItemId]'>$Item[$tableItemName]</option>"; 
        }


    } 
    $tableList .= '</select>'; 

    return $tableList; 
}

// Build a product update display form for admin dashboard
function buildProductUpdateDisplay($product, $colours, $sizes, $categories){
    $productUpdate = "<form method='POST' action='/zalisting/product/'>";

    $productUpdate .= "<label>Name</label><input type='text' name='productName' value='$product[productName]' />";
    $productUpdate .= buildTableList($colours, 'colourId', 'colour' );
    $productUpdate .= buildTableList($sizes, 'sizeId', 'sizeValue' );
    $productUpdate .= buildTableList($categories, 'categoryId', 'categoryName' );
    $productUpdate .= "<label>Quantity</label><input type='number' name='qty' value='$product[qty]' />";

    $productUpdate .= "<input type='submit' class='button' value='Submit' />";

    $productUpdate .= "<input type='hidden' name='action' value='update-product' />";
    $productUpdate .= "<input type='hidden' name='productId' value='$product[productId]' />";

    $productUpdate .= "</form>";

   return $productUpdate;
}

// Build a product create display form for admin dashboard
function buildProductCreateForm($categories, $colours){

    $productCreate = "<form class='checkboxed' method='POST' action='/zalisting/products/index.php' ><div class='row-form-content'>";



    $productCreate .= "<div class='column-form-input'><label>Product Name</label> <input type='text' name='productName' />";

    $productCreate .= "<label>Short Description</label> <textarea name='productShortDescr' rows='3' ></textarea>";

    $productCreate .= "<label>Price</label> <input type='number' name='productPrice' />";

    $productCreate .= "<label>Long Description</label> <textarea name='productDescription' rows='5' ></textarea>";

    $productCreate .= "</div><div class='column-form-fieldsets'><fieldset><legend>Add a Category</legend>";

    foreach($categories as $category){
        $productCreate .= "<label class='longChoice' ><input type='radio' class='categoryId' name='categoryId' value='".$category['categoryId']."' /><span>$category[categoryName]</span></label>";
    }

    $productCreate .= "</fieldset>";


    $productCreate .= "<fieldset><legend>Add Colours</legend>";

    foreach($colours as $colour){
        $productCreate .= "<label class='longChoice' ><input type='checkbox' name='colours[]' class='colourId' value='$colour[colourId]' /><span>$colour[colour]</span></label>";
    }

    $productCreate .= "</fieldset></div></div>";

    $productCreate .= "<input type='hidden' name='action' value='core' />";

    $productCreate .= "<input type='submit' class='button' value='Next' />";

    $productCreate .= "</form>";

   return $productCreate;
}

// Build a product create display form for admin dashboard
function buildCreateVariationForm($sizes){

    $productCreate = "<form class='checkboxed' method='POST' action='' >";

    $productCreate .= "<div class=''><fieldset><legend>Add a Category</legend>";

    foreach($_SESSION['colours'] as $colours){
        $productCreate .= "<label class='longChoice' ><input type='radio' onchange='ajaxing()' class='categoryId' name='categoryId' value='".$colours['coloursId']."' /><span>$colours[colours]</span></label>";

    $productCreate .= "</fieldset>";


    $productCreate .= "<fieldset><legend>Add Colours</legend>";

    foreach($sizes as $size){
        $productCreate .= "<label class='longChoice' ><input type='checkbox' onchange='ajaxing()' class='colourId' value='$size[sizeId]' /><span>$size[size]</span></label>";
    }
    }

    $productCreate .= "</fieldset>";

    $productCreate .= "<input type='hidden' name='action' value='variations' />";

    $productCreate .= "</div><input id='variations' type='button' class='button' value='Next' />";

    $productCreate .= "</form>";


   return $productCreate;
}

// Build a product block
function buildproductDisplay($product){

$dv  = "<div  class='product'><a href='/zalisting/shop?action=product&productId=$product[productId]' ><img src='../images/".$product['imagePath']."' alt='".$product['imageName']."' /></a>";
$dv .= "<a href='/zalisting/shop?action=product&productId=$product[productId]' class='productName-link'><h4 class='productName'>$product[productName]</h4></a>";
$dv .= "<p  class='productCategory'>$product[categoryName]</p>";
$dv .= "<h4 class='productPrice' >R$product[productPrice]</h4></div>";

return $dv;

}

// Build a product block
function buildproductsDisplay($products){

    $dv ="";

    if(isset($products)){
                        
        foreach($products as $product){

            $dv .= buildproductDisplay($product);

        }
    }

return $dv;

}

function buildSingleProductDisplay($product){

}


/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {

    // split image name at the period and add string parts into array $i.
    $i = strrpos($image, '.');

    // assign first array element to $image_name and leave only the second item remaining in the array
    $image_name = substr($image, 0, $i);

    // assign remaining substring in array $i to $ext
    $ext = substr($image, $i);

    // Create a new string and assign it to $image
    $image = $image_name . '-tn' . $ext;

    // return the thumbnail image name
    return $image;
   }

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
     $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
     $id .= '</li>';
   }
    $id .= '</ul>';
    return $id;
   }

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    
    if (isset($_FILES[$name])) {
        // Gets the actual file name- e.g: example.png, example.jpg, example.gif
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }

        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];

        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;

        //echo $filename; exit;

        // Moves the file to the target folder : This is a built-in function
        // $target is the file path ending with the file name. 
        move_uploaded_file($source, $target);

        // Send file for further processing
        processImage($image_dir_path, $filename);

        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        
        // Returns the path where the file is stored
        return $filepath;
    }

   }

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
   }

   // Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type: built in function returns array with size, type, and dimensions
    $image_info = getimagesize($old_image_path);

    // 3rd element of the getimagesize returned array is the type represented by int value but equal to:
    // IMAGETYPE_JPEG = 2 / IMAGETYPE_GIF = 1 / IMAGETYPE_PNG = 3
    $image_type = $image_info[2];
   
    // Set up the function names for built in functions
    switch ($image_type) {
    case IMAGETYPE_JPEG:
     $image_from_file = 'imagecreatefromjpeg';
     $image_to_file = 'imagejpeg';
    break;
    case IMAGETYPE_GIF:
     $image_from_file = 'imagecreatefromgif';
     $image_to_file = 'imagegif';
    break;
    case IMAGETYPE_PNG:
     $image_from_file = 'imagecreatefrompng';
     $image_to_file = 'imagepng';
    break;
    default:
     return;
   } // ends the swith
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
     // Calculate height and width for the new image
     $ratio = max($width_ratio, $height_ratio);
     $new_height = round($old_height / $ratio);
     $new_width = round($old_width / $ratio);
   
     // Create the new image
     $new_image = imagecreatetruecolor($new_width, $new_height);
   
     // Set transparency according to image type
     if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
     }
   
     if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
     }
   
     // Copy old image to new image - this resizes the image
     $new_x = 0;
     $new_y = 0;
     $old_x = 0;
     $old_y = 0;
     imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
   
     // Write the new image to a new file
     $image_to_file($new_image, $new_image_path);

     // Free any memory associated with the new image
     imagedestroy($new_image);
     } else {
     // Write the old image to a new file
     $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
   } // ends resizeImage function

   // Build customer reviews for admin and vehicle-details views
   // Only client's reviews appear in admin view while all car's
   // reviews will appear in vehicle-details view
   function customerReviews($reviews){

       $loggedinClientId = 0;

       if(isset($_SESSION['clientData'])){
            $loggedinClientId= $_SESSION['clientData']['clientId'];
       }

    // Design reviews on a table to aid alignment and styling.
    $cutomerReviews = "<table class='review-table'>";
    foreach($reviews as $review){

    
        $cutomerReviews .= "<tr><td class='reviewText' >$review[reviewText]</td></tr>";

        // when a user is logged in, they will have the ability to update or delete 
        // reviews using one of the links below respectively
        // $_SESSION['clientData']['clientId'] is the clientId of a logged in user.
        // When it's not the same as the clientId of a certain review, it will
        // be a review by another user. They wont have ability to update or delete.
        if(isset($review['clientId']) && $review['clientId']!=$loggedinClientId){
            // First letter of the first name obtained using index zero.
            $cutomerReviews .= "<tr><td class='reviewerName' >Posted by: ".substr($review['clientFirstname'],0,1)."".$review['clientLastname']."</td></tr>";
            // Date must not include time for my review display.
            $cutomerReviews .= "<tr><td class='reviewDate' >Date posted: ".date('F j, Y', strtotime($review['reviewDate']))."</td></tr>";

        }
        else if(isset($_SESSION['clientData'])){
            $cutomerReviews .= "<tr><td class='reviewerName'>Posted by: ".substr($_SESSION['clientData']['clientFirstname'],0,1)."".$_SESSION['clientData']['clientLastname']."</td></tr>";
            $cutomerReviews .= "<tr><td class='reviewDate' >Date posted: ".date('F j, Y', strtotime($review['reviewDate']))."</td></tr>";
            $cutomerReviews .= "<tr><td><a href='/phpmotors/reviews?action=getUpdateReview&reviewId=$review[reviewId]' title='Update Review' >Update</a>  <a href='/phpmotors/reviews?action=deleteRequest&clientId=".$_SESSION['clientData']['clientId']."' title='Delete Review' >Delete</a></td></tr>";
        }

        $cutomerReviews .= "<tr><td> <hr/> </td></tr>";

    }
    $cutomerReviews .= "</table>";

    return $cutomerReviews;

   }