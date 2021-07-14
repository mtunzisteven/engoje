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
// Get the products accounts model for use as needed
require_once '../model/accounts-model.php';
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

    case 'new-shipping-address':

        $addressName = filter_input(INPUT_POST, 'addressName', FILTER_SANITIZE_STRING); 
        $addressNumber = filter_input(INPUT_POST, 'addressNumber', FILTER_SANITIZE_NUMBER_INT);
        $addressEmail = filter_input(INPUT_POST, 'addressEmail', FILTER_SANITIZE_STRING); 
        $addressLineOne = filter_input(INPUT_POST, 'addressLineOne', FILTER_SANITIZE_STRING); 
        $addressLineTwo = filter_input(INPUT_POST, 'addressLineTwo', FILTER_SANITIZE_STRING);
        $addressCity = filter_input(INPUT_POST, 'addressCity', FILTER_SANITIZE_STRING);
        $addressZipCode = filter_input(INPUT_POST, 'addressZipCode', FILTER_SANITIZE_STRING);
        $addressType = filter_input(INPUT_POST, 'addressType', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['userId'] = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);


        if(!empty($addressName) && !empty($addressNumber) && !empty($addressEmail) && !empty($addressLineOne) 
            && !empty($addressLineTwo) && !empty($addressCity) && !empty($addressZipCode) && !empty($addressType)){

            // Add shipping address
            $addressUpdate = updateAddress($addressName, $addressNumber, $addressEmail, $addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $_SESSION['userId']);
        
            echo $addressUpdate; exit;

        }

        include "./";

        break;

    case 'checkout':

        break;
    
    default:

        if($_SESSION['userData']){

            $order_items = $_GET['order'];

            //var_dump($order_items); exit;

            $userId = $_SESSION['userData']['userId'];

            //var_dump($userId); exit;

            $userDetails = getUserDetails($userId);

            //var_dump($userDetails); exit;

            $checkoutDetails = getCartItems($userId);

            // date customer went into checkout page
            $checkoutDate = date('Y-m-d H:i:s');

            // add checkout order in db
            addCheckoutOrder($userId, $checkoutDate);

            $shippingMethodId = 1;

            if(isset($_SESSION['orderId'])){

                // create an order using the model function below.
                $orderId = $_SESSION['orderId'];

                $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId']);


            }else{

                // create an order using the model function below.
                $_SESSION['orderId'] = addOrder($userId, $order_items, $shippingMethodId, $checkoutDate);

                $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId']);


            }


            // if there is an order previously abondoned at checkout
            if(null != checkCheckout($userId)){

                // clear checkout order in db
                deleteCheckoutOrder($userId);

            }
            header("Location: /zalisting/shop/checkout/?order=$_SESSION[orderId]");
        }else{

            header('Location: /zalisting/accounts/?action=login');

        }


}