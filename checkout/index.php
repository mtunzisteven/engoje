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

        if(isset($_SESSION['userData'])){

            // get the list of items in cart for the user
            $order_items = getCartEntriesForCheckout($_SESSION['userData']['userId']);

            $order_Total = $_POST['orderTotal'];

            if(!empty($order_items)){

                $outOfStock = []; // Holds out of stock order information

                $adjustedOrder = []; // Holds reduced order amounts order information

                /////////////////////////////////////////////////////////////////////////////////////
                //        pop up message strings initiated for the respective scenarios            //
                /////////////////////////////////////////////////////////////////////////////////////

                // out of stock string initiated here
                $noStockMessage = "<p class='notice detail-span-bold center'>We've run out of stock of the following:";

                // short and adjusted stock string initiated here
                $adjustedStockMessage = "<p class='notice detail-span-bold center'>We've adjusted your order amounts for the following due to stock availability changes:";

                // order_items is found in the cartDisplay builder function 
                // It is and array that holds specified information
                // It is easier to use it instead of an associated array. INDEXES:
                // index 1 : product_entryId
                // index 2 : name
                // index 3 : colour
                // index 4 : price
                // index 5 : qty

                foreach($order_items as $order_item){


                    // id for the item in the db
                    $product_entryId = $order_item['product_entryId'];
                    // amount of this item to be purchased
                    $purchaseAmount = $order_item['cart_item_qty'];
                    // price of the item
                    $price = $order_item['price'];
                    // amount of the item available in the db
                    $amount = $order_item['amount'];
                    // colour of the item available in the db
                    $colour = $order_item['colour'];
                    // name of the item available in the db
                    $name = $order_item['productName'];

                    // amount remaining in the db of the item: will use the variable later
                    $dbAmountRemaining = 0;

                    // Item out of stock
                    $stockAvailable = true;

                    // if there is stock available
                    if($amount > 0){

                        // if stock is enough for the order
                        if($amount >= $purchaseAmount){

                            $dbAmountRemaining = $amount - $purchaseAmount; // only remove order amount from the order

                        }
                        // if stock is avalable but smaller than the order amount
                        else if($amount < $purchaseAmount){

                            $dbAmountRemaining = 0; // all amount available taken by order

                            $purchaseAmount = $amount; // specify amount in order


                        }

                        // updatge done in the model within 
                        // the function used below: updateQty().
                        updateQty($product_entryId, $dbAmountRemaining);

                    }else{


                        // Item out of stock
                        $stockAvailable = false;

                    }

                    // if item out of stock
                    if(!$stockAvailable){

                        // product name and product_entry id of item out of stock
                        $outOfStock[] = ['name'=>$name, 'product_entryId'=>$product_entryId, 'colour' => $colour];

                        // remove the cost of the item out of stock 
                        $order_Total -= $price*$purchaseAmount;

                    }

                    // When the qty received from db is less than the order qty
                    // This happens when stock is less than order amount in cx's order.
                    else if($dbAmountRemaining == 0 && $purchaseAmount != 0){

                        // product name and product_entry id of item adjusted order amount
                        $adjustedOrder[] = ['name'=>$name, 'product_entryId'=>$product_entryId, 'newQty'=>$purchaseAmount, 'colour' => $colour];

                        // remove the cost of the item adjusted out of order 
                        $order_Total -= $price*$purchaseAmount;

                    }

                }

                //echo "Post increment: ".$order_Total; exit;

                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                //            Use the following to capture messages from changes in order for each order item         //
                ////////////////////////////////////////////////////////////////////////////////////////////////////////

                // When an order item is out of order
                foreach($outOfStock as $item){

                    // Load message for pop up card
                    $noStockMessage .= "<br/>".$item['name']." - ".$item['colour']; 

                }

                // when an order item has lower quanity than ordered amount
                foreach($adjustedOrder as $item){

                    // Load message for pop up card
                    $adjustedStockMessage .= "<br/>".$item['name']." - ".$item['colour']." | New Qty: ".$item['newQty']; 

                }

                // items out of stock
                $_SESSION['outOfStock '] = $outOfStock;

                // fetch request response associated array created
                $response = [];

                // first fetch request response associative array item loaded into array 
                $response['orderTotal'] = $order_Total;


                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //                   specific Messages to display for shortage or out of stock scenario                   //
                //        specify the total order amount when order affected n\by shortage or out of stock items          //
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                // out of stock items and stock amount adjustment in order
                if(!empty($outOfStock) && !empty($adjustedOrder)){

                    // second fetch request response associative array item loaded into array 
                    $response['message'] = $noStockMessage."\n".$adjustedStockMessage."<br/><br/>New Order Total: $order_Total</p>";

                }

                // only stock amount adjustment in order, none out of stock
                else if(empty($outOfStock) && !empty($adjustedOrder)){

                    // second fetch request response associative array item loaded into array 
                    $response['message'] = $adjustedStockMessage."<br/><br/>New Order Total: $order_Total</p>";

                }

                // out of stock items in order, no adjsutments
                else if(!empty($outOfStock) && empty($adjustedOrder)){

                    // second fetch request response associative array item loaded into array 
                    $response['message'] = $noStockMessage."<br/><br/>New Order Total: $order_Total</p>";

                }

                // no out of stock items or stock amount adjustment in order. Perfect order!
                else{

                    $response['message'] = 1;
                        
                }

                // response to checkout fetch request
                echo json_encode($response); exit;
                
            }
        }

        break;

    case 'checkout':
    
    default:

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                          updating the order string with cart update amounts                            //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //string must be made an array 
        $_SESSION['order']= explode(",", $_SESSION['order']);

        // initialize updater
        // iteration index.
        $j = 0;

        // iterate through array and update purchase order amounts
        // every 4th element is an amount of an item in the order
        // each order info takes up 5 elements in the array
        for($i = 4; $i < count($_SESSION['order']); $i+=5){

            // actual update of quantities done by this line.
            $_SESSION['order'][$i] = $_SESSION['cartUpdateArr'][$j];

            // increment updater
            // iteration index.
            $j += 1;

        }

        // array turned back into a string
        $_SESSION['order']  = implode(",", $_SESSION['order']);

        /*var_dump($_SESSION['cartUpdateArr'])."\n"; 
        var_dump($_SESSION['order']); exit;*/

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                                          updating completed                                            //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // When this is a logged in user
        if($_SESSION['userData']){

            // receive order string from cart
            $order_items = $_SESSION['order'];

            // receive order string from cart
            $shippingId = $_GET['shippingId'];

            // get the user id of the logged in user
            $userId = $_SESSION['userData']['userId'];

            // get user address details for the user 
            // in checkout model using their id
            $userDetails = getUserDetails($userId);

            // fetch all user cart items in db
            $checkoutDetails = getCartItems($userId);

            // date customer went into checkout page
            $checkoutDate = date('Y-m-d H:i:s');

            $shippingInfo = getShipping($shippingId);

            // when an order has been added to the db for this user
            if(isset($_SESSION['orderId']) ){

                // fetch the order from the bd and compare it with the current order
                $db_order_items = getOrderItems($_SESSION['orderId']);

                // if they are identical, go on and display the checkout view
                // turn db_order_items to string because it comes back as ana array
                if($order_items === $db_order_items['order_items']){

                    // build the checkout display
                    $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);

                } else{ // if they do not match, delete the db order and restart the process

                    if(deleteOrder($_SESSION['orderId'])){

                        // create an order using the model function below.
                        $_SESSION['orderId'] = addOrder($userId, $order_items, $shippingId, $checkoutDate);

                        // build the checkout display
                        $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);

                    }

                }

            }else{

                // create an order using the model function below.
                $_SESSION['orderId'] = addOrder($userId, $order_items, $shippingId, $checkoutDate);

                // build the checkout display
                $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);


            }

            header("Location: /zalisting/shop/checkout/?order=$_SESSION[orderId]");
        }else{

            header('Location: /zalisting/accounts/?action=login');

        }


}