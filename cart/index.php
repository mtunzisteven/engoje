<?php

// session expire reset: 180 sec
session_cache_expire();

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
// Get the products cart model for use as needed
require_once '../model/cart-model.php';
// Get the products orders model for use as needed
require_once '../model/orders-model.php';

// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

// Fetch all products and bring them to scope of all cases
$products = getShopProducts();


$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    // add to cart request: Ajax request
    case 'add-to-cart':

        // sanitize the variables received from Ajax request
        $product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);
        $cart_item_qty = filter_input(INPUT_POST, 'cart_item_qty', FILTER_SANITIZE_NUMBER_INT);


        // if the variables are none-empty, proceed
        if(!empty($product_entryId) || !empty($cart_item_qty)){

            // get the qty of the item in the db
            $amount = getProductQty($product_entryId);
            $amount = $amount['amount'];

            // only add it into cart if it is in stock
            if($amount > 0){

                // for all logged in users use the code block below
                if(isset($_SESSION['userData'])){

                    // get the user id of the logged in user
                    $userId = $_SESSION['userData']['userId'];

                    // get allcart items for this user
                    $cartItems = getCartItems($userId);

                    // if product_entry exists in the db cart items table for the user don't bother adding it
                    if(!checkIfValueExists($cartItems, 'product_entryId', $product_entryId)){

                        // date item added to cart
                        $dateAdded = date('Y-m-d H:i:s');

                        // get product entry details to access the image path below
                        $productDetails = getShopProductEntry($product_entryId);

                        // get the image path
                        $imagePath = getImage($productDetails['productId'], $productDetails['colour']); 

                        // add the items to the cart
                        $addToCart = addCartItem($product_entryId, $cart_item_qty, $userId, $imagePath['imagePath_tn'], $dateAdded);

                        if($addToCart){

                            // get all cart items for the user
                            $updatedCartItems = getCartItems($userId);
            
                            // sum all item quantities
                            $_SESSION['cartTotal'] = sumAllValues($updatedCartItems, 'cart_item_qty');

                            // add the cart total to the response array
                            $responseText['cartTotal'] = $_SESSION['cartTotal'];

                            // add the response text to the response array
                            $responseText['add-to-cart-response'] = "<p class='adding-alert'>$cart_item_qty products added to <a href='/zalisting/cart?action=cart'>cart</a></p>";

                            // send the associative array back to the js Ajax
                            echo json_encode($responseText);


                        }

                    }else{// if the item already found in db for the same user, don't add it again, just increase its quantity

                        // get the qty of the item in the db cart already added
                        $cartAmount = getCartItemQty($product_entryId, $userId);
                        $cartAmount = $cartAmount['cart_item_qty'];

                        // if not all items in stock have already been added or bought
                        if($amount > $cartAmount){

                            // get all cart items for the user
                            $cartItems = getCartItems($userId);

                            // get the index of the item that matches the value in the db
                            $itemIndex = getIndexFromArr($cartItems, 'product_entryId', $product_entryId);

                            // get the new total amount of this item
                            $newQty = sumValues($cartItems, 'cart_item_qty', $cart_item_qty);
            
                            // update the db item with the new quantity from above
                            $updateCartQty = updateCartQty($cartItems[$itemIndex]['cart_itemId'], $newQty);

                            // get all cart items for the user
                            $updatedCartItems = getCartItems($userId);
                
                            if($updatedCartItems){

                                // sum all item quantities
                                $_SESSION['cartTotal'] = sumAllValues($updatedCartItems, 'cart_item_qty');

                                // add the cart total to the response array
                                $responseText['cartTotal'] = $_SESSION['cartTotal'];

                                // add the response text to the response array
                                $responseText['add-to-cart-response'] = "<p class='adding-alert'>$cart_item_qty products added to <a href='/zalisting/cart?action=cart'>cart</a></p>";

                                // send the associative array back to the js Ajax
                                echo json_encode($responseText);

                            }else{

                                // add the cart total to the response array
                                $responseText['cartTotal'] = $_SESSION['cartTotal'];

                                // add the response text to the response array
                                $responseText['add-to-cart-response'] = "<p class='adding-alert'>Error! Product not added.</p>";

                                // send the associative array back to the js Ajax
                                echo json_encode($responseText);

                            }

                        }else{//if the max items in db is added, return info

                    

                            // add the cart total to the response array
                            $responseText['cartTotal'] = $_SESSION['cartTotal'];
    
                            $responseText['add-to-cart-response'] = "<p class='adding-alert'>Only $amount in stock!</p>";
    
                            // send the associative array back to the js Ajax
                            echo json_encode($responseText);
    
                        }
                    }                    

                }else { // if user not signed in, user cart session variable

                    // add an item to the cart session variable
                    $_SESSION['cart'][] = [
                        'product_entryId' => $product_entryId, 
                        'cart_item_qty' => $cart_item_qty
                    ];

                    // reindex the array
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                    
                    // get a total of all the items in the cart
                    $_SESSION['cartTotal'] = sumAllValues($_SESSION['cart'], 'cart_item_qty');

                    // add the cart total to the response array
                    $responseText['cartTotal'] = $_SESSION['cartTotal'];

                    // add the response text to the response array
                    $responseText['add-to-cart-response'] = "<p class='adding-alert'>$cart_item_qty products added to <a href='/zalisting/cart?action=cart'>cart</a></p>";

                    // send the associative array back to the js Ajax
                    echo json_encode($responseText);

                }

            }else{ //if item is out of stock, return info

                // add the cart total to the response array
                $responseText['cartTotal'] = $_SESSION['cartTotal'];

                $responseText['add-to-cart-response'] = "<p class='adding-alert'>Out of stock!</p>";

                // send the associative array back to the js Ajax
                echo json_encode($responseText);

            }
        }

        break;

    case 'update-cart':

        // turn string into array
        $cartUpdateArr = explode(",", $_POST['cartUpdateArr']);

        // filter external input array
        $cartUpdateArr  = filter_var_array($cartUpdateArr);

        $_SESSION['cartUpdateArr'] = $cartUpdateArr;

        if(isset($cartUpdateArr)){

            if(isset($_SESSION['cart'])){

                // reindex the array
                $_SESSION['cart'] = array_values($_SESSION['cart']);

                // set cart total to zero
                $_SESSION['cartTotal'] = 0;


                // update the cart quantities of each item
                for($i = 0; $i < count($_SESSION['cart']); $i++){

                    $_SESSION['cart'][$i]['cart_item_qty'] = $cartUpdateArr[$i];


                    $_SESSION['cartTotal'] += $cartUpdateArr[$i];

                }

                echo $_SESSION['cartTotal'];

            }else if(isset($_SESSION['userData'])){

                // fetch all the cart items for this user
                $cartItems = getCartItems($_SESSION['userData']['userId']);

                if($cartItems){

                    //var_dump($cartUpdateArr); exit;

                    // set the cart total to zero
                    $_SESSION['cartTotal'] = 0;

                    // iterate through the cart items you fetched
                    for($i = 0; $i < count($cartItems); $i++){

                        // update each items quantity
                        $cartItems[$i]['cart_item_qty'] = $cartUpdateArr[$i];

                        // send the updates to the db
                        $updateCartQty = updateCartQty($cartItems[$i]['cart_itemId'], $cartItems[$i]['cart_item_qty']);
    
                        // update the total session variable with a sum of all the new values
                        $_SESSION['cartTotal'] += $cartUpdateArr[$i];

                    }

                    echo $_SESSION['cartTotal'];
                    exit;
                }

            }

        }


        break;

    // delete one product entry from the cart
    case 'remove-cart-item':

        // sanitize the variables received from Ajax request
        $product_entryId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

        // If there are items in the cart
        if(isset($_SESSION['cart'])){

            // if there is one item in the cart
            if(count($_SESSION['cart']) == 1){

                // remove it
                unset($_SESSION['cart']);

                // delete cart display session variable
                unset($_SESSION['cartDisplay']);

            }
            
            // if there are more than 1 item
            else{

                for($i = 0; $i < count($_SESSION['cart']); $i++){

                    // re-index the array to fit the if statement below
                    $_SESSION['cart'] = array_values($_SESSION['cart']);

                    // go through all the items and find one that has the same product id
                    if($_SESSION['cart'][$i]['product_entryId'] == $product_entryId){

                        // delete it
                        unset($_SESSION['cart'][$i]);

                    }

                }

            }


        }

        // if the user is logged in
        else if(isset($_SESSION['userData'])){
            
            // remove the cart item
            $removeRow = deleteCartItem($product_entryId, $_SESSION['userData']['userId']);

            // delete cart display session variable
            unset($_SESSION['cartDisplay']);

        }

        // redirect to the cart page
        header('Location: /zalisting/cart/');


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

        if(isset($_SESSION['cart'])){

            // remove cart display session variable
            unset($_SESSION['cart']);
            // remove cart display session variable
            unset($_SESSION['cartDisplay']);
            
        }

        if(isset($_SESSION['userData'])){

            //delete in db cart_items
            $removeRow = deleteCartItems($_SESSION['userData']['userId']);

            // delete cart display session variable
            unset($_SESSION['cartDisplay']);

        }

        header('Location: /zalisting/cart/');

        break;

    // cart page accessing through icon or link in product page
    default:

        // fetch shipping information
        $shippingInfo = getShippingMethods();

        if(isset($_SESSION['userData'])){ // for logged in users

            // get cart items from the db
            $cartItems = getCartItems($_SESSION['userData']['userId']);

            //var_dump($cartItems);

            // they are found, proceed
            if($cartItems){

                // delete cart items from session if there are cart items from db
                if(isset($_SESSION['cart'])){ 

                    unset($_SESSION['cart']);
                }

                // create a display cart variable to use in the view
                $_SESSION['cartDisplay'] = buildCartDisplay(sumCartQuantities($cartItems), $shippingInfo);

            }

            // add the cart items to the db since there user has no cart item data stored there.
            else if(isset($_SESSION['cart'])){ 

                foreach($_SESSION['cart'] as $orderItem){

                    // date item added to cart
                    $dateAdded = date('Y-m-d H:i:s');
    
                    // get product entry details to access the image path below
                    $productDetails = getShopProductEntry($orderItem['product_entryId']);
    
                    // get the image path
                    $imagePath = getImage($productDetails['productId'], $productDetails['colour']);
        
                    // get the user id of the logged in user
                    $userId = $_SESSION['userData']['userId'];
    
                    // add the items to the cart
                    $addToCart = addCartItem($orderItem['product_entryId'], $orderItem['cart_item_qty'], $userId, $imagePath['imagePath_tn'], $dateAdded);

                    // Make an array of cart display items, with the exception of the image
                    $productDetails = getShopProductEntry($orderItem['product_entryId']) + ['cart_item_qty'=>$orderItem['cart_item_qty']];

    
                    // Make an array of all the cart display data including the image
                    $duplicatedCartDetails[] = $productDetails + getImage($productDetails['productId'], $productDetails['colour']);
    
                }

                // clear cart item session variable
                unset($_SESSION['cart']);
                
                // create a display cart variable to use in the view
                $_SESSION['cartDisplay'] = buildCartDisplay(sumCartQuantities($duplicatedCartDetails), $shippingInfo);

            }else{
                $_SESSION['message'] = '<p class="notice">Your cart is empty...</p>';

            }


        }
                
        //user not logged in so cart session variable will be used exclusively  
        else{ 

            // create an empty array
            $duplicatedCartDetails = [];

            //unset($_SESSION['cart']);

            // if there are cart session variables available, proceed
            if(isset($_SESSION['cart'])){

                // reindex the array
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                

                //var_dump($_SESSION['cart']); exit;

                foreach($_SESSION['cart'] as $orderItem){


                    // Make an array of cart display items, with the exception of the image
                    $productDetails = getShopProductEntry($orderItem['product_entryId']) + ['cart_item_qty'=>$orderItem['cart_item_qty']];

    
                    // Make an array of all the cart display data including the image
                    $duplicatedCartDetails[] = $productDetails + getImage($productDetails['productId'], $productDetails['colour']);
    
                }

                //var_dump($duplicatedCartDetails); exit;
                
                // build a cart display
                $_SESSION['cartDisplay'] = buildCartDisplay(sumCartQuantities($duplicatedCartDetails), $shippingInfo);

            }else{

                $_SESSION['message'] = '<p class="notice">Your cart is empty...</p>';
            }

        }
        
        header('Location: /Zalisting/shop/cart/');  
    }


// sum db array item quantities
function sumValues($array, $key, $newValue){

    $sum = 0;

    foreach($array as $item){

        $sum = $item[$key] + $newValue;
    }

    return $sum;
}

// sum db array items
function sumAllValues($array, $key){

    $sum = 0;

    foreach($array as $item){

        $sum += $item[$key];
    }

    return $sum;
}


// check if item value in array items exist
function checkIfValueExists($array, $key, $value){

    $result = 0;

    foreach($array as $item){

        if($item[$key] == $value){

            $result = 1;

        }
    }

    return $result;
}

// get index of item that is equal to the value
function getIndexFromArr($array, $key, $value){

    $index = false;

    for($i = 0; $i < count($array); $i++){

        if($array[$i][$key] == $value){

            $index = $i;

        }
    }

    return $index;
}