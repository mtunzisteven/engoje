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
        $addressNumber = filter_input(INPUT_POST, 'addressNumber', FILTER_SANITIZE_STRING);
        $addressEmail = filter_input(INPUT_POST, 'addressEmail', FILTER_SANITIZE_STRING); 
        $addressLineOne = filter_input(INPUT_POST, 'addressLineOne', FILTER_SANITIZE_STRING); 
        $addressLineTwo = filter_input(INPUT_POST, 'addressLineTwo', FILTER_SANITIZE_STRING);
        $addressCity = filter_input(INPUT_POST, 'addressCity', FILTER_SANITIZE_STRING);
        $addressZipCode = filter_input(INPUT_POST, 'addressZipCode', FILTER_SANITIZE_STRING);
        $addressType = filter_input(INPUT_POST, 'addressType', FILTER_SANITIZE_NUMBER_INT);

        if(!empty($addressName) && !empty($addressNumber) && !empty($addressEmail) && !empty($addressLineOne) 
            && !empty($addressLineTwo) && !empty($addressCity) && !empty($addressZipCode) && !empty($addressType)){

            //echo $addressName.$addressNumber.$addressEmail.$addressLineOne.$addressLineTwo.$addressCity.$addressZipCode.$addressType; exit;


            // Add shipping address
            $addressUpdate = updateAddress($addressName, $addressNumber, $addressEmail, $addressLineOne, $addressLineTwo, $addressCity, $addressZipCode, $addressType, $_SESSION['userData']['userId']);

        }

        header("Location: /zalisting/checkout");

        break;

    case 'paynow':

        $order_items = $_POST['order'];

        if(!empty($order_items)){

            // make array from order_item string
            $arr = explode(",", $order_items);

            $length = count($arr) - 1;

            $outOfStock = []; // Holds out of stock order information

            $adjustedOrder = []; // Holds reduced order amounts order information

            $noStockMessage = "We've run out of stock of the following:\n";

            $adjustedStockMessage = "We've adjusted your order amounts for the following due to stock availability changes:\n";


            for($i = 0; $i < $length; $i+=5){

                // check and modify qty
                $updateQty = updateQty($arr[$i], $arr[$i+4]);

                // if item out of stock
                if(!$updateQty[0]){

                    // product name and product_entry id of item out of stock
                    $outOfStock[] = ['name'=>$arr[$i+1], 'product_entryId'=>$arr[$i]];


                }

                else if($updateQty[1] != $arr[$i+4]){

                    // product name and product_entry id of item adjusted order amount
                    $adjustedOrder[] = ['name'=>$arr[$i+1], 'product_entryId'=>$arr[$i], 'newQty'=>$updateQty[1]];

                }

            }

            /////////////////////////////////////////////////////////////////////////////////////
            //            Use the following to capture messages from changes in order          //
            /////////////////////////////////////////////////////////////////////////////////////
            foreach($outOfStock as $item){

                $noStockMessage .= $item['name']."\n"; 

            }

            foreach($adjustedOrder as $item){

                $adjustedStockMessage .= $item['name']." | New Qty:".$item['newQty']."\n"; 

            }

            // items out of stock
            $_SESSION['outOfStock '] = $outOfStock;

            if(!empty($outOfStock) && !empty($adjustedOrder)){

                echo $noStockMessage."\n".$adjustedStockMessage;

            }
            else if(empty($outOfStock) && !empty($adjustedOrder)){

                echo $adjustedStockMessage;

            }
            else if(!empty($outOfStock) && empty($adjustedOrder)){

                echo $noStockMessage;

            }else{

                echo "Success!";
                    
            }
            
        }

        break;

    case 'checkout':
    
    default:

        if($_SESSION['userData']){

            $order_items = $_GET['order'];

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

            //unset($_SESSION['orderId']); //exit;


            if(isset($_SESSION['orderId'])){

                // create an order using the model function below.
                $orderId = $_SESSION['orderId'];

                $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items);


            }else{

                // create an order using the model function below.
                $_SESSION['orderId'] = addOrder($userId, $order_items, $shippingMethodId, $checkoutDate);

                $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items);


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