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
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/admin/?action=users' class='dashboard-side-nav-links'>Accounts</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/products/?action=product' class='dashboard-side-nav-links'>Products</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/upload/' class='dashboard-side-nav-links'>Images</a></li>";
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

  // Build a multi user display view
function buildCartDisplay($cartDetails){

    $cartDisplay = "<div class='cart-display-table'><div class='cart-display-table-row'><div>Product</div><div>Name</div><div>Quantity</div><div>Size</div><div>Price</div><div>Total</div><div>Remove Item</div></div>";

    $grandTotal = 0;

    foreach($cartDetails as $cartItem){

        $lineTotal = $cartItem['price']*$cartItem['qty'];
        $grandTotal += $lineTotal;

        $cartDisplay .= "<div class='seperator'></div><div class='cart-display-table-row'> ";
        $cartDisplay .= "<div><img src='$cartItem[imagePath_tn]'></div>"; 
        $cartDisplay .= "<div>$cartItem[productName]</div>"; 
        $cartDisplay .= "<div class='buttoned-div'><button class='button cart-qty-reduce-button'>-</button><input type='number' value='$cartItem[qty]' /><button class='button cart-qty-reduce-button'>+</button></div>"; 
        $cartDisplay .= "<div>$cartItem[sizeValue]</div>"; 
        $cartDisplay .= "<div>R$cartItem[price]</div>"; 
        $cartDisplay .= "<div>R$lineTotal</div>"; 
        $cartDisplay .= "<div><a href='' title='Remove Item'>x</a></div></div>"; 
    }

    $cartDisplay .= '</div>';
    $cartDisplay .= "<div class='cart-display-table-column'><div class='cart-total-container'><h4>Cart Total:</h4><h4> R$grandTotal</h4></div>";
    $cartDisplay .= "<button class='button cart-buttons'>Update Cart</button></div>";


   return $cartDisplay;
  }
  

// Build a multi product display table on admin dashboard
function buildAdminProductsDisplay($allProducts, $nonImgedProducts){

    $productRows = [];

    foreach($allProducts as $product){

        for($i = 0; $i < count($nonImgedProducts); $i++){

            $path = $i + 1;    // The actual path for the same colour image
            $productId = $i+2; // products table productId which is shred by all product_entries from that product

            // Match colour and shared productId from products table
            if($nonImgedProducts[$i] == $product['colour'] && $nonImgedProducts[$productId] == $product['productId']){


                $productRows[] = "<tr class='user-display-info'> <td class=td-buttons ><a class='button account-button' href='/zalisting/products/?action=update&product_entryId=$product[product_entryId]'>update</a> <a class='button account-button' href='/zalisting/products/?action=delete&product_entryId=$product[product_entryId]'>delete</a> </td><td><img class=image-tn src='$nonImgedProducts[$path]' /></td>  <td>$product[productName] </td> <td>$product[price] </td> <td>$product[amount] </td> <td>$product[sizeValue]</td> <td>$product[colour]</td> <td>$product[sku]</td> </tr>";
        
            }
        }
    }

   return $productRows;
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

// Build a product update display form for admin dashboard
function buildProductUpdateDisplay($product, $colours, $sizes, $categories){
    $productUpdate = "<form method='POST' action='/zalisting/product/'><div class='swatch-row small-width-swatches'>";

    $productUpdate .= "<div class='swatch-item'><label>Change Colour</label>".buildDropDownList($colours, 'colourId', 'colour' )."</div>";
    $productUpdate .= "<div class='swatch-item'><label>Change Size</label>".buildDropDownList($sizes, 'sizeId', 'sizeValue' )."</div>";
    $productUpdate .= "<div class='swatch-item'><label>Change Category</label>".buildDropDownList($categories, 'categoryId', 'categoryName' )."</div></div>";
    $productUpdate .= "<label>Quantity</label><input type='number' name='amount' value='$product[amount]' />";

    $productUpdate .= "<input type='submit' class='button' value='Submit' />";

    $productUpdate .= "<input type='hidden' name='action' value='update-product' />";
    $productUpdate .= "<input type='hidden' name='product_entryId' value='$product[product_entryId]' />";

    $productUpdate .= "</form>";

   return $productUpdate;
}

// Build a product create display form for admin dashboard
function buildProductCreateForm($categories, $colours, $sizes){

    $productCreate = "<form class='checkboxed' method='POST' action='/zalisting/products/index.php' ><div class='row-form-content'>";



    $productCreate .= "<div class='column-form-input'><label>Product Name</label> <input type='text' name='productName' />";

    $productCreate .= "<label>Short Description</label> <textarea name='productShortDescr' rows='3' ></textarea>";

    $productCreate .= "<label>Long Description</label> <textarea name='productDescription' rows='5' ></textarea>";

    $productCreate .= "</div><div class='column-form-fieldsets'><fieldset><legend>Add a Category</legend>";

    foreach($categories as $category){// Get the category for the product
        $productCreate .= "<label class='longChoice' ><input type='radio' class='categoryId' name='categoryId' value='".$category['categoryId']."' /><span>$category[categoryName]</span></label>";
    }

    $productCreate .= "</fieldset>";

    $productCreate .= "<fieldset><legend>Add Sizes</legend>";

    foreach($sizes as $size){  // Create an array that will hold all the sizes chosen by the user
        $productCreate .= "<label class='longChoice' ><input type='checkbox' name='sizeIds[]' value='".$size['sizeId']."' /><span>$size[sizeValue]</span></label>";
    }

    $productCreate .= "</fieldset>";


    $productCreate .= "<fieldset><legend>Add Colours</legend>";

    foreach($colours as $colour){// Create an array that will hold all the colours chosen by the user
        $productCreate .= "<label class='longChoice' ><input type='checkbox' name='colourIds[]' value='$colour[colourId]' /><span>$colour[colour]</span></label>";
    }

    $productCreate .= "</fieldset></div></div>";

    $productCreate .= "<input type='hidden' name='action' value='core' />";

    $productCreate .= "<input type='submit' class='button' value='Next' />";

    $productCreate .= "</form>";

   return $productCreate;
}


// Create a dropdown list for the size variations form
function buildDropDownList($array, $id, $name){

    $placeholder = '';
    if($name == 'sizeValue'){ 
        $placeholder = 'size';
    }    
    else if($name == 'categoryName'){ 
        $placeholder = 'category';
    }else{
        $placeholder = $name; }

    // Build a navigation bar using the $classifications array
    $DropDownList = "<input list='$id' name='".$name."[]' placeholder='$placeholder' />";
    $DropDownList .= "<datalist id='$id'>";
    foreach ($array as $item) {
        //var_dump($item); exit;
    $DropDownList .= "<option value='$item[$name]' ></option>";
    }
    $DropDownList .= '</datalist>';

    return $DropDownList;

}

// Build the inner portion of the variation form
function buildCreateVariationFormRows($colours, $sizes){

    //var_dump($colours); exit;

    $productCreate = "<div class='swatch-row'>";

    $productCreate .= "<label>Choose Colour".buildDropDownList($colours, 'colourId', 'colour')."</label>";

    $productCreate .= "<label>Choose Size".buildDropDownList($sizes, 'sizeId', 'sizeValue')."</label>";

    $productCreate .= "<label>Enter Price<input type='number' name='price[]' placeholder='Price' /></label>";

    $productCreate .= "<label>Enter SKU<input type='text' name='sku[]' placeholder='sku code' /></label>";

    $productCreate .= "<label>Enter Quantity<input type='number' name='qty[]' placeholder='number of items' /></label></div>";

   return $productCreate;
}

// Build the form for uploading product images
function buildImageUploadForm($productSelect){

    $imageUploadForm = "<form class='db-entry-form form-image-upload' action='/zalisting/upload/' method='post' enctype='multipart/form-data'>";
    $imageUploadForm .= "<label for='product_entryId'>Products</label>";

    if(isset($productSelect)){ 
        $imageUploadForm .= $productSelect;
    }

    $imageUploadForm .= "<label class='radio'>Is this the main image for the product?</label>";

    $imageUploadForm .= "<div class='pImage-container'>";
    $imageUploadForm .= "<label for='priYes' class='pImage'>Yes</label><input type='radio' name='imagePrimary' id='priYes' value='1' />";
    $imageUploadForm .= "</div>";

    $imageUploadForm .= "<div class='pImage-container'>";
    $imageUploadForm .= "<label for='priNo' class='pImage'>No</label><input type='radio' name='imagePrimary' id='priNo'  checked value='0' />";
    $imageUploadForm .= "</div>";

    $imageUploadForm .= "<label>Upload Image:</label>";
    $imageUploadForm .= "<input type='file' name='file1'>";
    $imageUploadForm .= "<input type='submit' class='button' value='Upload'>";
    $imageUploadForm .= "<input type='hidden' name='action' value='upload'>";
    $imageUploadForm .= "</form>";

    return $imageUploadForm;

}


// Build the form for uploading product images
function buildProductImageUploadForm($productSelect){

    $imageUploadForm = "<form class='db-entry-form form-image-upload uploadform'  method='post' enctype='multipart/form-data'>";
    $imageUploadForm .= "<label for='product_entryId'>Products</label>";

    if(isset($productSelect)){ 
        $imageUploadForm .= $productSelect;
    }

    $imageUploadForm .= "<label class='radio'>This is the main image for the product</label>";

    $imageUploadForm .= "<input type='hidden' name='imagePrimary' class='primary' value='1' />";

    $imageUploadForm .= "<label>Upload Image:</label>";
    $imageUploadForm .= "<input type='file' id='file1' name='file' multiple>";
    $imageUploadForm .= "<input type='submit' class='button' id='productImageUploadForm' value='Upload'>";
    $imageUploadForm .= "</form>";

    return $imageUploadForm;

}


// Build product swatches display for product details view
function buildProductSwatchesDisplay($products, $swatch){

    if($swatch == 'sizeValue'){
        $label = 'size';
        $swatchClass = '';
    }else{
        $label = $swatch;
        $swatchClass = $swatch;
    }

    $swatchDisplay = "<label class='swatch-label'>$label: <strong id='label-$label'></strong></label><div class='swatch-container'>";

    foreach($products as $product){


        if(!strpos($swatchDisplay, ' '.$product[$swatch].' ') && $product[$swatch]!='N/A'){ // When substring:$product[$swatch] is not found in the string: $swatchString, execute block
            
            if($label == 'size'){

                $swatchDisplay .= "<textarea class='swatch-single-item $label' readonly name='$product[$swatch]' > $product[$swatch] </textarea>"; //spaces help avoid reding XS from XXS or S from XS 

            }else if($label == $swatch){

                $swatchDisplay .= "<textarea class='swatch-single-item $swatchClass' name='$product[$swatch]' > $product[$swatch] </textarea>"; //spaces help avoid reding XS from XXS or S from XS 

            }
        }
    }

    $swatchDisplay .= "</div>";

    //var_dump($swatchDisplay); exit;


    return $swatchDisplay;

}

// Build a product display card for shop views
function buildproductDisplay($product){

    if(isset($product['imagePath'])){
        $path = $product['imagePath'];
    }else{
        $path = '/zalisting/images/no-image';
        
    }

    $dv  = "<div  class='product'><a href='/zalisting/shop?action=product&productId=$product[productId]' ><img src='$path' alt='".$product['productName']."' /></a>";
    $dv .= "<a href='/zalisting/shop?action=product&productId=$product[productId]' class='productName-link'><h4 class='productName'>$product[productName]</h4></a>";
    $dv .= "<p  class='productCategory'>$product[categoryName]</p>";
    $dv .= "<h4 class='productPrice' >R$product[price]</h4></div>";

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
    $id = '<ul id="image-library">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img class='library-images' src='$image[imagePath]' title='image on zalisting.com' alt=' $image[imageName] image on zalisting.com'>";
     $id .= "<p><a class='media-delete-button button' href='/zalisting/upload?action=delete&imageId=$image[imageId]&filename=$image[imageName]' title='Delete the image'>Delete</a></p>";
     $id .= '</li>';
   }
    $id .= '</ul>';
    return $id;
   }

// Build the product select list
function buildProductSelect($products) {
    $prodList = '<select name="product_entryId" id="product_entryId">';
    $prodList .= "<option>Choose a Product</option>";
    foreach ($products as $product) {
     $prodList .= "<option value='$product[product_entryId]'>$product[productName] in $product[colour]</option>";
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
   
        if($width_ratio === $height_ratio){

            // Calculate height and width for the new image
            $ratio = max($width_ratio, $height_ratio);
            $new_height = round($old_height / $ratio);
            $new_width = round($old_width / $ratio);
            
        }else{
            
            // Calculate height and width for the new image
            $new_height = $max_height;
            $new_width = $max_width;
            
        }

   
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
            $cutomerReviews .= "<tr><td><a href='/zalisting/reviews?action=getUpdateReview&reviewId=$review[reviewId]' title='Update Review' >Update</a>  <a href='/zalisting/reviews?action=deleteRequest&clientId=".$_SESSION['clientData']['clientId']."' title='Delete Review' >Delete</a></td></tr>";
        }

        $cutomerReviews .= "<tr><td> <hr/> </td></tr>";

    }
    $cutomerReviews .= "</table>";

    return $cutomerReviews;

   }