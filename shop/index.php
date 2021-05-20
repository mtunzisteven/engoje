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

    // Fetch all products and bring them to scope of all cases
    $products = getShopProducts();


    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){

        // Single product view with details
        case 'product':

            // sanitize shared product id
            $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
            
            //get all the product details for using shared productId
            $productData = getShopProduct($productId);

            // get the different swatches available to this products
            $productSwatch = getShopSwatchProduct($productId);

            // build a swatch display for the sizes
            $sizes = buildProductSwatchesDisplay($productSwatch, 'sizeValue');

            // build a swatch display for the colours
            $colours = buildProductSwatchesDisplay($productSwatch, 'colour');

            include '../view/shop-product.php';
         
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

                    // load the details of the product into an associative array
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

        // add to cart request: Ajax request
        case 'add-to-cart':
            // sanitize the variables received from Ajax request
            $product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);
            $qty = filter_input(INPUT_POST, 'qty', FILTER_SANITIZE_NUMBER_INT);

            // if the variables are none-empty, proceed
            if(!empty($product_entryId) || !empty($qty)){

                // create a session variable with the variables
                $_SESSION['cart'][] = [
                    'product_entryId' => $product_entryId, 
                    'qty' => $qty
                ];

                // respond to the Ajax request
                echo "<p>$qty products added to <a href='/zalisting/shop?action=cart'>cart</a></p>";
            }

            break;

        // cart page accessing through icon or link in product page
        case 'cart':

            // create an empty array
            $cartDetails = [];

            // if there are cart session variables available, proceed
            if(isset($_SESSION['cart'])){

                foreach($_SESSION['cart'] as $orderItem){

                    // Make an array of cart display items, with the exception of the image
                    $productDetails = getShopProductEntry($orderItem['product_entryId']) + ['qty'=>$orderItem['qty']];
    
                    // Make an array of all the cart display data including the image
                    $cartDetails[] = $productDetails + getImage($productDetails['productId'], $productDetails['colour']);
    
                }
                
                // build a cart display
                $cartDisplay = buildCartDisplay($cartDetails);

            }else{

                $message = '<p class="notice">Your cart is empty...</p>';

            }

            include '../view/cart.php';

            break;
        
        default:

            // BUild a products archive
            $productsDisplay = buildproductsDisplay($products);

            include '../view/shop.php';
    }