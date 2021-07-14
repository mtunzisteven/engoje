<?php

// session expire reset: 180 sec
session_cache_expire();

//This is the products controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';
    // Get the zalisting main model for use as needed
    require_once '../model/main-model.php';
    // Get the accounts model for use as needed
    require_once '../model/accounts-model.php';
    // Get the products adproductUpdateNavmin model for use as needed
    require_once '../model/products-model.php';

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    // Fetch all product entries and bring them to scope of all cases
    $products = getPrimaryProducts();

    // Create image paths for products of each colour but different size that don't have images
    // fetch all products first:
    $allProducts = getAllProducts();

    // Create an associative array  
    $nonImgedProducts = [];

    // For each product with no image, loop through products with images and find a matching color.
    foreach($products as $imgProduct){

        if(isset($imgProduct['imagePath_tn'])){

            // add the following values in the order of colour then path
            $nonImgedProducts[] = $imgProduct['colour']; 
            $nonImgedProducts[] = $imgProduct['imagePath_tn']; 
            $nonImgedProducts[] = $imgProduct['productId']; 


        }
    }

    // Build products update Table
    $productAdminTable = buildAdminProductsDisplay( $allProducts,  $nonImgedProducts);

    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){

        case 'create':

            // Fetch categories & colours from db
            $categories = getCategories(); //var_dump($categories); exit;
            $colours = getColours(); //var_dump($colours); exit;
            $sizes = getSizes();

            
            $createProductForm = buildProductCreateForm($categories, $colours, $sizes);

            include '../view/add-product.php';

         break;

         case 'core':

            //var_dump($_POST['colours']); exit;

            $productName = filter_input(INPUT_POST, 'productName',FILTER_SANITIZE_STRING);  
            $productShortDescr = nl2br(filter_input(INPUT_POST, 'productShortDescr',FILTER_SANITIZE_STRING)); //respect new lines (nl2br used)
            $productDescription = nl2br(filter_input(INPUT_POST, 'productDescription',FILTER_SANITIZE_STRING)); //respect new lines (nl2br used)
            $_SESSION['categoryId'] = $_POST['categoryId'];
            $colourIds = $_POST['colourIds'];
            $sizeIds = $_POST['sizeIds'];

            //var_dump($sizeIds); exit;


            if(empty($_SESSION['categoryId']) || empty($productName) || empty($productShortDescr) || empty($productDescription) || empty($colourIds) || empty($sizeIds)){

                $message = "<p class='notice detail-span-bold'>Sorry, we couldn't add the Product.</p>";

            }else{

                $productCreationDate = date('Y-m-d H:i:s');

                $productAdded = addProduct($productName, $productShortDescr, $productDescription, $productCreationDate);

                 //echo $productAdded; exit;

                if($productAdded){

                    $message = "<p class='notice detail-span-bold'>Product Information Added!</p>";

                    // Create an array that will hold the specified colors
                    $colours = [];

                    
                    // Create an array that will hold the specified sizes
                    $sizes = [];

                    // Get lengths for all sizes in db and specified colours
                    $sizeLength = count($sizeIds);
                    $colourLength = count($colourIds);

                    $length = $colourLength*$sizeLength;



                    for($i= 0; $i<$colourLength; $i++){
                        // fetch the specified colours and load them into the array $colours
                        $colours[] = getColourById($colourIds[$i]);
                    }

                    for($i= 0; $i<$sizeLength; $i++){
                        // fetch the specified sizes and load them into the array $sizes
                        $sizes[] = getSizeById($sizeIds[$i]);
                    }

                    //var_dump($colours); exit;

                    // Create the variations form using the highest number of items between the sizes and coloours
                    $variationsForm = "<form class='checkboxed' method='POST' action='/zalisting/products/index.php' >";

                    for($i= 0; $i<$length; $i++){

                        $variationsForm .= buildCreateVariationFormRows($colours, $sizes); // Access the table elements fetched with fetchall
                    }

                    $variationsForm .= "<input type='hidden' name='action' value='swatches' />";

                    $variationsForm .= "<input class='button' type='submit' value='Add Product' /></form>";


                    include '../view/add-each-product.php';
                    break;

                }

            }



            include '../view/add-product.php';

         break;

         case 'swatches':

            //$sizes = getSizes(); //var_dump($sizes); exit;

            if(!empty($_POST['sku']) || !empty($_POST['price']) || !empty($_POST['qty']) || !empty($_POST['sizeValue']) || !empty($_POST['colour']) || !empty($_SESSION['categoryId'])){

                // Get the product id of the product that was last added(recently added)
                $productId = getLastProductId();

                // Get sizes array from datalist inputs
                $size = $_POST['sizeValue'];
                
                // Get colours array from datalist inputs
                $colour = $_POST['colour'];
    
                // Get the amount of product_entries to add
                $length = count($size)*count($colour);

                for($i= 0; $i<$length; $i++){
                    if(isset($colour[$i])){

                        // fetch the non-empty specified non empty colours and load them into the array $colours
                        $colours[] = $colour[$i];

                    }
                }

                for($i= 0; $i<$length; $i++){
                    if(isset($size[$i])){

                    // fetch the non-empty specified sizes and load them into the array $sizes
                    $sizes[] = $size[$i];

                    }
                }
    
                // Filter external input arrays
                $price  = filter_var_array($_POST['price']);
                $qty  = filter_var_array($_POST['qty']);
                $sku  = filter_var_array($_POST['sku']);

                //echo $variationRows."<br/>"; exit;
    
                for($i= 0; $i<count($sizes); $i++){
    
                    $price = $_POST['price'][$i];
                    $qty =  $_POST['qty'][$i];
                    $sku =  $_POST['sku'][$i];

                    // get the size id from the db
                    $sizeId = getSizeId($sizes[$i]);

                    // get the colour id from the db
                    $colourId = getColourId($colours[$i]);
                    
                    if(isset($sizeId['sizeId']) && isset($colourId['colourId']) && isset($price) && !empty($sku) && isset($qty)){

                        // convert all IDs to inegers as array items some were received as strings
                        $product_entry = addProductEntry((int)$productId['productId'], (int)$sizeId['sizeId'], (int)$colourId['colourId'], (int)$_SESSION['categoryId'], (int)$price, $sku, (int)$qty);                


                    }
                }

                // Get product entry ids from database for the last products added
                //$product_entryIds = getLastProductEntryId($colours);

                // fetch all product_entries just added and have no images
                $products = getLastProductsInfoById((int)$productId['productId']);

                // Build a select list of product information for the view
                // Add images to all variations, even if it is size, it doesn't matter
                $productSelect = buildProductSelect($products);

                // get product image upload form
                //$uploadForm = ''; 

                $_SESSION['uploadForms'] = '';

                // display as many image upload forms as products added
                for($i = 0; $i < count($products); $i++){

                    $_SESSION['uploadForms'] .= buildProductImageUploadForm($products[$i]);

                    $_SESSION['uploadForms'] .= buildSecondaryImageUploadForm($products[$i]);

                }
                
                $message = "<p class='notice detail-span-bold'>Success! Product(s) added.</p>";
                header('Location: /zalisting/upload');
                break;

            }else{

                $message = "<p class='notice detail-span-bold'>Sorry, we couldn't added the Product(s).</p>";

            }

            include '../view/product-admin.php';
            break;
         
        case 'update':
            $product_entryId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

            $product = getProduct_entry($product_entryId);
            $colour = getColours();
            $sizes = getSizes();
            $image = getProductImageByProdEntryId($product_entryId);
            $categories = getCategories();

            //var_dump($image['imagePath']); exit;


            $productUpdateDisplay = buildProductUpdateDisplay($product, $colour, $sizes, $categories);

            include '../view/product-update.php';

         break;

         
    case 'delete':
            $product_entryId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

            $product_entry = getProduct_entry($product_entryId);

            //var_dump($product_entry); exit;

            include '../view/product-delete.php';

         break;

    case 'delete-confirmed':

        $product_entryId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

        $deleteProduct = deleteProduct_entry($product_entryId); 
        // The above will return an array with 2 elements: The returned product id and the product delete result

        if($deleteProduct[0]){

            // Find empty product information(products) table anad delete it
            $emptyProducts = deleteNoEntryProducts($deleteProduct[1]); 

            if($emptyProducts){ // Deleted products row for the above deleted entry if there was no other entry

                $_SESSION['message'] = "<p class='notice detail-span-bold'>Success! Product and non-entry products table removed successfully.</p>";

            }else{ // Products row for the above deleted entry has other product_entries, no deletion waranted

                $_SESSION['message'] = "<p class='notice detail-span-bold'>Success! Product removed successfully and no non-entry products table was found</p>";

            }

        }else{

            $_SESSION['message'] = "<p class='notice detail-span-bold'>Error! Product not removed. Please try again.</p>";

        }

        header('Location: /zalisting/products/');

        break;


         
    case 'lookup':
            
            include '../view/product-admin.php';

         break;
        
    case 'product':
    default:

            // 

         include '../view/product-admin.php';
    }