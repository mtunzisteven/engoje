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

            //var_dump($productData); exit;

            // get the different swatches available to this productId
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

        // add to cart request: Ajax request
        case 'add-to-cart':
            // sanitize the variables received from Ajax request
            $product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);
            $cart_item_qty = filter_input(INPUT_POST, 'cart_item_qty', FILTER_SANITIZE_NUMBER_INT);


            // if the variables are none-empty, proceed
            if(!empty($product_entryId) || !empty($qty)){

                if(isset($_SESSION['userData'])){

                    // date item added to cart
                    $dateAdded = date('Y-m-d H:i:s');
    
                    // get product entry details to access the image path below
                    $productDetails = getShopProductEntry($product_entryId);
    
                    // get the image path
                    $imagePath = getImage($productDetails['productId'], $productDetails['colour']);
        
                    $userId = $_SESSION['userData']['userId'];
    
                    $addToCart = addCartItem($product_entryId, $cart_item_qty, $userId, $imagePath['imagePath_tn'], $dateAdded);

                    //echo $addToCart; break;

                    if($addToCart){

        
                        // get a total of all the items in the cart
                        $_SESSION['cartTotal'] += $cart_item_qty;
            
                        // add the cart total to the response array
                        $responseText['cartTotal'] = $_SESSION['cartTotal'];

                        // add the response text to the response array
                        $responseText['add-to-cart-response'] = "<p>$cart_item_qty products added to <a href='/zalisting/shop?action=cart'>cart</a></p>";

                        // send the associative array back to the js Ajax
                        echo json_encode($responseText);

                    }
    
                }else{

                    // create a session variable with the variables
                    $_SESSION['cart'][] = [
                        'product_entryId' => $product_entryId, 
                        'cart_item_qty' => $cart_item_qty
                    ];

                    // define cart total and initialize it to a value of 0
                    $_SESSION['cartTotal'] = 0;
                
                    foreach($_SESSION['cart'] as $cartItems){
        
                        // get a total of all the items in the cart
                        $_SESSION['cartTotal'] += $cartItems['cart_item_qty'];
        
                    }

                    // add the cart total to the response array
                    $responseText['cartTotal'] = $_SESSION['cartTotal'];

                    // add the response text to the response array
                    $responseText['add-to-cart-response'] = "<p>$cart_item_qty products added to <a href='/zalisting/shop?action=cart'>cart</a></p>";

                    // send the associative array back to the js Ajax
                    echo json_encode($responseText);

                }


            }

            break;

        // cart page accessing through icon or link in product page
        case 'cart':

            if(isset($_SESSION['userData'])){

                $cartItems = getCartItems($_SESSION['userData']['userId']);

                if($cartItems){

                    $cartDisplay = buildCartDisplay(sumCartQuantities($cartItems));

                }else{
                    $message = '<p class="notice">Your cart is empty...</p>';
                }


            }else{

                    // create an empty array
                $duplicatedCartDetails = [];

                //unset($_SESSION['cart']);

                // if there are cart session variables available, proceed
                if(isset($_SESSION['cart'])){

                    //var_dump($_SESSION['cart']); exit;

                    foreach($_SESSION['cart'] as $orderItem){


                        // Make an array of cart display items, with the exception of the image
                        $productDetails = getShopProductEntry($orderItem['product_entryId']) + ['cart_item_qty'=>$orderItem['cart_item_qty']];

        
                        // Make an array of all the cart display data including the image
                        $duplicatedCartDetails[] = $productDetails + getImage($productDetails['productId'], $productDetails['colour']);
        
                    }

                    //var_dump($duplicatedCartDetails); exit;
                    
                    // build a cart display
                    $cartDisplay = buildCartDisplay(sumCartQuantities($duplicatedCartDetails));

                }else{

                    $message = '<p class="notice">Your cart is empty...</p>';

                }

            }
            
            include '../view/cart.php';

            break;

        // delete one product entry from the cart
        case 'remove-cart-item':

            // sanitize the variables received from Ajax request
            $product_entryId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

            if(isset($_SESSION['cart'])){

                $count = 0;

                while(array_key_exists ( $product_entryId , $_SESSION['cart'])){

                    if($product_entryId == $_SESSION['cart'][$count]['product_entryId']){

                        unset($_SESSION['cart'][$count]);

                    }

                    $count++;

                }
            }

            //echo $product_entryId; exit;

            if(isset($_SESSION['userData'])){

                $removeRow = deleteCartItem($product_entryId, $_SESSION['userData']['userId']);

            }


            //echo $removeRow; exit;

                
            header('Location: /zalisting/shop/?action=cart');


            break;

        // get the cart total number of items count
        case 'cart-count':

            // define cart total and initialize it to a value of 0
            $_SESSION['cartTotal'] = 0;

            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $cartItems){
    
                // get a total of all the items in the cart
                $_SESSION['cartTotal'] += $cartItems['cart_item_qty'];
                }

            }else if(isset($_SESSION['userData'])){

                $cartItems = getCartItems($_SESSION['userData']['userId']);

                foreach($cartItems as $cartItem){
    
                    // get a total of all the items in the cart
                    $_SESSION['cartTotal'] += $cartItem['cart_item_qty'];
                }
            }

            // return the cart total to ajax request
            echo $_SESSION['cartTotal'];

            break;

        case 'clear-cart':

            unset($_SESSION['cart']);

            if(isset($_SESSION['userData'])){

                $removeRow = deleteCartItems($_SESSION['userData']['userId']);

            }

            header('Location: /zalisting/shop/?action=cart');

            break;
        
        default:

            // BUild a products archive
            $productsDisplay = buildproductsDisplay($products);

            include '../view/shop.php';
    }
