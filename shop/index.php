<?php

//This is the shop controller for the site
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the database connection file
require_once '../library/functions.php';
// Get the za listing main model for use as needed
require_once '../model/main-model.php';
// Get the shop model for use as needed
require_once '../model/shop-model.php';
// Get the products admin model for use as needed
require_once '../model/products-model.php';
// Get the products image uploads model for use as needed
require_once '../model/uploads-model.php';

// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

//initial pagination
$lim = 24;
$offset = 0;

// Fetch all products and bring them to scope of all cases
$products = getShopPaginations($lim, $offset);

// Get the number of products in db
$allProducts = getShopProducts();

//var_dump($allProducts); exit;

// Get the total number products in db
$productsQty = count($allProducts);

// get colours and sizes from db
$colours = getColours();
$sizes = getSizes();

// input max and min price values
$maxPrice = '';
$minPrice = '';

// build sidebar display
$sidebarDisplay = buildShopSidebarPrice($minPrice, $maxPrice);
$sidebarDisplay .= buildShopSidebarColour($products, 'colour');
$sidebarDisplay .= buildShopSidebarSize($products, 'sizeValue');


//echo $minPrice; exit;

// sanitize action variable
$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    // Single product view with details
    case 'product':

        // sanitize shared product id & colour
        $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['product_entryId'] = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_STRING);
        $_SESSION['colourChoice'] = filter_input(INPUT_GET, 'colour', FILTER_SANITIZE_STRING);


        
        //get all the product details for using shared productId
        $_SESSION['productData'] = getShopProduct($productId);

        //var_dump($_SESSION['productData']); exit;

        // get the different swatches available to this productId
        $productSwatch = getShopSwatchProduct($productId);

        // build a swatch display for the sizes
        $_SESSION['sizes'] = buildProductSwatchesDisplay($productSwatch, 'sizeValue');

        // build a swatch display for the colours
        $_SESSION['colours'] = buildProductSwatchesDisplay($productSwatch, 'colour');

        header('Location: /zalisting/shop/product/');
        
        break;

    // when a colour swatch is selected - Ajax request
    case 'colour-swatch':
    // sanitize the received variables
    $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
    $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_STRING);

    // makes sure variables aren't empty
    if(!empty($productId) || !empty($colour)){

        // when none-empty, get the product with this product id the selected colour
        // only one product per colour is tied to an image, so one will be returned
        // if it exists in the db.
        $newData = getColourSwatchShopProduct($productId, $colour);

        // if there is such a product, proceed
        if(!empty($newData)){

            $gallery = getSwatchImages($newData[0]['product_entryId']);

            $galleryPaths_tn = [];
            $galleryPaths = [];

            foreach($gallery as $image){

                $galleryPaths_tn[] = $image['imagePath_tn'];
                $galleryPaths[] = $image['imagePath'];

            }

            // load the details of the product into an associative array
            $responseText['galleryPaths_tn'] = $galleryPaths_tn;
            $responseText['galleryPaths'] = $galleryPaths;
            $responseText['imagePath'] = $newData[0]['imagePath'];
            $responseText['product_entryId'] = $newData[0]['product_entryId'];
            $responseText['price'] = $newData[0]['price'];

            // send that associative array back to JS as an ajax response
            echo json_encode($responseText);

        }

    }else{

        echo "Error! The colour or product id are empty.";

    }

    break;

    // when a size swatch is selected - Ajax request
    case 'size-swatch':
        $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_STRING);
        $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);

        // if all the variables are none-empty, proceed
        if(!empty($productId) || !empty($colour) || !empty($size)){

            // get the product details of the product with the selected colour,
            // size, and product id. only one will have this combination of variables
            $newData = getSizeSwatchedShopProduct($productId, $colour, $size);
            
            //var_dump($colour); exit;

            // if this product is found in the db, proceed
            if(!empty($newData)){

                // load the associative array with the response data
                $responseText['product_entryId'] = $newData[0]['product_entryId'];
                $responseText['price'] = $newData[0]['price'];

                // send the associative array back to the js Ajax
                echo json_encode($responseText);

            }else{
                echo '';
            }

        }else{

            echo "Error! The size or product id are empty.";

        }

        break;

    case 'next':

        $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_NUMBER_INT);

        $offset += $lim;

        // get next offset
        $products = getShopPaginations($lim, $offset);        

        // Build a products archive
        $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty);

        include '../view/shop.php';

        break;

    case 'prev':

        $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_NUMBER_INT);

        if($offset > 0){

            $offset -= $lim;

        }

        // get next offset
        $products = getShopPaginations($lim, $offset);        

        // Build a products archive
        $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty);

        include '../view/shop.php';

        break;

    case 'filters':

        include '../view/shop.php';

        break;

    default:

        // BUild a products archive
        $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty);

        include '../view/shop.php';
    }

