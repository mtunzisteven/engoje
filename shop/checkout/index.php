<?php

// session expire reset: 180 sec
session_cache_expire();

//This is the shop controller for the site
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/library/connections.php';
// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/library/functions.php';
// Get the za listing main model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/model/main-model.php';
// Get the shop model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/model/shop-model.php';
// Get the products admin model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/model/products-model.php';
// Get the products image uploads model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/model/uploads-model.php';
// Get the products cart model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/model/cart-model.php';
// Get the products orders model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/model/orders-model.php';
// Get the products orders model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/zalisting/model/orders-model.php';

// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

// Fetch all products and bring them to scope of all cases
$products = getShopProducts();


$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){
            
   
    default:

    if(isset($_SESSION['order'])){
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                          updating the order string with cart update amounts                            //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //string must be made an array 
        $_SESSION['order']= explode(",", $_SESSION['order']);


        // iterate through array and update purchase order amounts
        // every 4th element is an amount of an item in the order
        // each order info takes up 5 elements in the array
        for($i = 4; $i < count($_SESSION['order']); $i+=5){

            $product_entryId = $_SESSION['order'][$i-4];

            // fetch all the cart items for this user
            $cartItemsQty = getCartQuantityForCheckout($_SESSION['userData']['userId'], $product_entryId)['cart_item_qty'];

            // actual update of quantities done by this line.
            $_SESSION['order'][$i] = $cartItemsQty;

        }

        // array turned back into a string
        $_SESSION['order']  = implode(",", $_SESSION['order']);

        //var_dump($_SESSION['order']); exit;

        /*var_dump($_SESSION['cartUpdateArr'])."\n"; 
        var_dump($_SESSION['order']); exit;*/

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                                          updating completed                                            //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // When this is a logged in user
        if($_SESSION['userData']){

            // receive order string from cart
            $order_items = $_SESSION['order'];

            if(isset($_GET['shippingId'])){ // When coming from cart, this will be true. Not required if reloading, as session var will be set

                // receive order string from cart
                $_SESSION['shippingId']= $_GET['shippingId'];

            }

            // get the user id of the logged in user
            $userId = $_SESSION['userData']['userId'];

            // get user address details for the user 
            // in checkout model using their id
            $userDetails = getUserDetails($userId);

            // fetch all user cart items in db
            $checkoutDetails = getCartItems($userId);

            // date customer went into checkout page
            $checkoutDate = date('Y-m-d H:i:s');

            $shippingInfo = getShipping($_SESSION['shippingId']);

            // when an order has been added to the db for this user
            if(isset($_SESSION['orderId']) ){

                // fetch the order from the db and compare it with the current order
                $db_order_items = getOrderItems($_SESSION['orderId']);

                // if they are identical, go on and display the checkout view
                // turn db_order_items to string because it comes back as ana array
                if($order_items === $db_order_items['order_items']){

                    // build the checkout display
                    $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);

                } else{ // if they do not match, delete the db order and restart the process

                    if(deleteOrder($_SESSION['orderId'])){

                        // create an order using the model function below.
                        $_SESSION['orderId'] = addOrder($userId, $order_items, $_SESSION['shippingId'], $checkoutDate);

                        // build the checkout display
                        $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);

                    }
                }

            }else{

                // create an order using the model function below.
                $_SESSION['orderId'] = addOrder($userId, $order_items, $_SESSION['shippingId'], $checkoutDate);

                // build the checkout display
                $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);


            }

            include $_SERVER['DOCUMENT_ROOT'].'/zalisting/view/checkout.php';  

        }else{

            header('Location: /zalisting/accounts/?action=login');

        }
    }else{

        header("Location: /zalisting/shop/cart/");

    }


}



  