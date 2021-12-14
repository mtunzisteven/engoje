<?php



// This is the shop controller for the site cart responsible only for the default action: go to cart
// Provides a clean cart url
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/library/connections.php';
// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/library/functions.php';
// Get the engoje main model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/model/main-model.php';
// Get the shop model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/model/shop-model.php';
// Get the products admin model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/model/products-model.php';
// Get the products image uploads model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/model/uploads-model.php';
// Get the products cart model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/model/cart-model.php';
// Get the products orders model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/model/orders-model.php';

$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    // cart page accessing through icon or link in product page
    default:

        // fetch shipping information
        $shippingInfo = getShippingMethods();

        if(isset($_SESSION['userData'])){ // for logged in users

            // get cart items from the db
            $cartItems = getCartItems($_SESSION['userData']['userId']);

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


        }else{ //user not logged in so cart session variable will be used exclusively 

            // create an empty array
            // $duplicatedCartDetails = [];

            //unset($_SESSION['cart']);

            // // if there are cart session variables available, proceed
            // if(isset($_SESSION['cart'])){

            //     // reindex the array
            //     $_SESSION['cart'] = array_values($_SESSION['cart']);
                

            //     //var_dump($_SESSION['cart']); exit;

            //     foreach($_SESSION['cart'] as $orderItem){


            //         // Make an array of cart display items, with the exception of the image
            //         $productDetails = getShopProductEntry($orderItem['product_entryId']) + ['cart_item_qty'=>$orderItem['cart_item_qty']];

    
            //         // Make an array of all the cart display data including the image
            //         $duplicatedCartDetails[] = $productDetails + getImage($productDetails['productId'], $productDetails['colour']);
    
            //     }

            //     //var_dump($duplicatedCartDetails); exit;
                
            //     // build a cart display
            //     $_SESSION['cartDisplay'] = buildCartDisplay(sumCartQuantities($duplicatedCartDetails), $shippingInfo);

            // }else{

            //     $_SESSION['message'] = '<p class="notice">Your cart is empty...</p>';
            // }

            $_SESSION['message'] = '<p class="notice">Your cart is empty...</p>'; 


        }
        
        include $_SERVER['DOCUMENT_ROOT'].'/engoje/view/cart.php';  
    }
