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
    case 'checkout':

        break;
    
    default:

        if($_SESSION['userData']){

            $userId = $_SESSION['userData']['userId'];

            //var_dump($userId); exit;

            $userDetails = getUserDetails($userId);

            unset($userDetails['userPassword']);

            //var_dump($userDetails); exit;

            $checkoutDetails = getCartItems($userId);

            $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails);

            // if there is an order previously abondoned at checkout
            if(null != checkCheckout($userId)){

                // clear checkout order in db
                deleteCheckoutOrder($userId);

            }

            // date customer went into checkout page
            $checkoutDate = date('Y-m-d H:i:s');

            // add checkout order in db
            addCheckoutOrder($userId, $checkoutDate);

            header('Location: /zalisting/shop/checkout/');
        }else{

            header('Location: /zalisting/accounts/?action=login');

        }


}