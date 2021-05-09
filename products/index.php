<?php

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

    // Fetch all products and bring them to scope of all cases
    $products = getProducts();

    // Build products update Table
    $productAdminTable = buildAdminProductsDisplay( $products);

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
            $productShortDescr = filter_input(INPUT_POST, 'productShortDescr',FILTER_SANITIZE_STRING);
            $productDescription = filter_input(INPUT_POST, 'productDescription',FILTER_SANITIZE_STRING);
            $_SESSION['categoryId'] = $_POST['categoryId'];
            $colourIds = $_POST['colourIds'];
            $sizeIds = $_POST['sizeIds'];

            //var_dump($sizeIds); exit;


            if(empty($_SESSION['categoryId']) || empty($productName) || empty($productShortDescr) || empty($productDescription) || empty($colourIds) || empty($sizeIds)){

                $message = "<p class='notice detail-span-bold'>Sorry, we couldn't added the Product.</p>";

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

                //var_dump($_POST['colour']); exit;

                $productId = getLastProductId();

                // Get sizes array from datalist inputs
                $size = $_POST['sizeValue'];
                
                // Get colours array from datalist inputs
                $colour = $_POST['colour'];
    
                // Get the amount of products to add colour or size count would both work the same
                $length = count($size);
    
                // Filter external input arrays
                $price  = filter_var_array($_POST['price']);
                $qty  = filter_var_array($_POST['qty']);
                $sku  = filter_var_array($_POST['sku']);

                /*var_dump($price)."<br/>";
                var_dump($qty)."<br/>";
                var_dump($sku)."<br/>"; exit;*/

                
    
                for($i= 0; $i<$length; $i++){
    
                    $price = $_POST['price'][$i];
                    $qty =  $_POST['qty'][$i];
                    $sku =  $_POST['sku'][$i];

                    // get the size id from the db
                    $sizeId = getSizeId($size[$i]);

                    // get the colour id from the db
                    $colourId = getColourId($colour[$i]);


                    /*echo gettype ((int)$productId['productId'])."<br/>";
                    echo gettype ((int)$sizeId['sizeId'])."<br/>";
                    echo gettype ((int)$colourId['colourId'])."<br/>"; 
                    echo gettype ((int)$_SESSION['categoryId'])."<br/>";
                    echo gettype ((int)$price)."<br/>";
                    echo gettype ((int)$qty)."<br/>";
                    echo gettype ($sku)."<br/>";                    
                    exit;*/
    
                    // convert all IDs to inegers as array items some were received as strings
                    $product_entry = addProductEntry((int)$productId['productId'], (int)$sizeId['sizeId'], (int)$colourId['colourId'], (int)$_SESSION['categoryId'], (int)$price, $sku, (int)$qty);                
                }

                //$uploadForm = buildImageUploadForm();

                $message = "<p class='notice detail-span-bold'>Success! Product(s) added.</p>";
                include '../view/image-uploads.php';
                exit;

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
            $images = getImages();
            $categories = getCategories();

            //var_dump($colour); exit;


            $productUpdateDisplay = buildProductUpdateDisplay($product, $colour, $sizes, $categories);

            include '../view/product-update.php';

         break;

         
        case 'delete':
            $productId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

            include '../view/product-delete.php';

         break;

         
        case 'lookup':
            
            include '../view/product-admin.php';

         break;
        
        case 'product':
        default:
         include '../view/product-admin.php';
    }