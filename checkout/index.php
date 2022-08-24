<?php



//This is the shop controller for the site checkout responsible for all checkout related actions, except go to checkout// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 


// Get the database connection file
require_once '../library/connections.php';
// Get the cleaner script 
require_once '../library/dbCleaner.php';
// Get the database connection file
require_once '../library/functions.php';
// Get the engoje main model for use as needed
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

        header("Location: /checkout");

        break;

    case 'reverse-qty-deduction':

            if(isset($_SESSION['userData'])){

                //string must be made an array 
                $order_items = explode(",", $_SESSION['order']);

                if(!empty($order_items)){ 

                    /////////////////////////////////////////////////////////////////////////////////////
                    //             reverse order stock amount reduction done at checkout               //
                    /////////////////////////////////////////////////////////////////////////////////////

                        for($i = 0; $i < count($order_items); $i+=5){


                            // id for the item in the db
                            $product_entryId = $order_items[$i];
                            // amount of this item to be purchased
                            $purchaseAmount = intval($order_items[$i+4]);

                            // amount available in the db
                            $amount = getProduct_entryAmount($product_entryId);

                            $amount = intval($amount['amount']);

                            $reversedAmount = $amount + $purchaseAmount;


                            // updatge done in the model within 
                            // the function used below: updateQty().
                            updateQty($product_entryId, $reversedAmount);
                        }

                    ////////////////////////////////////////////////////////////////////////////////////////
                    //            end reverse order stock amount reduction done at checkout               //
                    ////////////////////////////////////////////////////////////////////////////////////////
                }
            }

            break;

    case 'paynow':

            $csrfToken = filter_input(INPUT_POST, '_csrf', FILTER_SANITIZE_NUMBER_INT);

            // user must be logged in
            if(isset($_SESSION['userData'])){

                // get the order items string from the db
                $orderItemsString = getOrderItems($_SESSION['orderId'])['order_items'];

                // echo $orderItemsString; exit;

                //string must be made an array 
                $_SESSION['order'] = explode(",", $orderItemsString);

                // this was set inside function file
                $order_Total = $_POST['orderTotal'];

                // there must be an order that exists for the user.
                if(!empty($_SESSION['order'])){

                    $outOfStock = []; // Holds out of stock order information

                    $adjustedOrder = []; // Holds reduced order amounts order information

                    /////////////////////////////////////////////////////////////////////////////////////
                    //        pop up message strings initiated for the respective scenarios            //
                    /////////////////////////////////////////////////////////////////////////////////////

                        // out of stock string initiated here
                        $noStockMessage = "<p class='notice detail-span-bold center'>We've run out of stock of the following:";

                        // short and adjusted stock string initiated here
                        $adjustedStockMessage = "<p class='notice detail-span-bold center'>We've adjusted your order amounts for the following due to stock availability changes:";

                    /////////////////////////////////////////////////////////////////////////////////////
                    //                        pop up message strings end                               //
                    /////////////////////////////////////////////////////////////////////////////////////

                    //////////////////////////////////////////////////////////////////////
                    //            Order item amounts and db item amounts logic          //
                    //////////////////////////////////////////////////////////////////////

                        // order_items is found in the cartDisplay builder function 
                        // It is and array that holds specified information
                        // It is easier to use it instead of an associated array. INDEXES:
                        // index 1 : product_entryId
                        // index 2 : name
                        // index 3 : colour
                        // index 4 : price
                        // index 5 : qty

                        $numberOfItems = 0;

                        for($i = 0; $i < count($_SESSION['order']); $i+=5){


                            // id for the item in the db
                            $product_entryId = $_SESSION['order'][$i];
                            // name of the item available in the db
                            $name = $_SESSION['order'][$i+1];
                            // colour of the item available in the db
                            $colour = $_SESSION['order'][$i+2];
                            // price of the item
                            $price = intval($_SESSION['order'][$i+3]);
                            // amount of this item to be purchased
                            $purchaseAmount = intval($_SESSION['order'][$i+4]);

                            $initialPurchaseAmount = $purchaseAmount;

                            // amount available in the db
                            $amount = getProduct_entryAmount($product_entryId);

                            // convert item amount received from db into integer
                            $amount = intval($amount['amount']);

                            // amount remaining in the db of the item: will use the variable later
                            $dbAmountRemaining;

                            // Item available in stock if this value is 1.
                            $stockAvailable = 1;

                            // if there is stock available (from db)
                            if($amount > 0){

                                // if stock is enough for the order, remove the purchase amount from the db and save the value in dbAmountRemaining
                                if($amount >= $purchaseAmount){

                                    $dbAmountRemaining = $amount - $purchaseAmount; // only remove order amount from the order

                                    $numberOfItems += $purchaseAmount; // add the purchase amount to the total amount of items

                                }
                                else{

                                    // if stock is avalable but smaller than the order amount, take all items remaining from db into this order
                                    // set value of dbAmountRemaining to zero and update the order session variable
                                    // set $stockAvailable to 2, meaning no more items remain, except for current order.

                                    $dbAmountRemaining = 0; // all amount available taken by order

                                    $purchaseAmount = $amount; // specify amount in order

                                    $_SESSION['order'][$i+4] = $amount; // also update the session variable order string amount

                                    $numberOfItems += $purchaseAmount; // add the purchase amount to the total amount of items

                                    // no more stock available but available for current order
                                    $stockAvailable = 2;
                                }

                                // updatge product quantity remaining in the db
                                updateQty($product_entryId, $dbAmountRemaining);

                                // update the cart amounts to reflect the above changes as well
                                updateCheckoutCartQty($product_entryId, $purchaseAmount, $_SESSION['userData']['userId']); 

                            }else{


                                // Item out of stock when this value is zero
                                $stockAvailable = 0;

                                $numberOfItems -= $purchaseAmount; // remove the purchase amount to the total amount of items


                            }

                            // if item out of stock
                            if($stockAvailable == 0){

                                // product name and product_entry id of item out of stock
                                $outOfStock[] = ['name'=>$name, 'product_entryId'=>$product_entryId, 'colour' => $colour];

                                // remove the cost of the item out of stock 
                                $order_Total -= $price*$purchaseAmount;

                            }
                            // When the qty received from db is less than the order qty
                            // This happens when stock is less than order amount in cx's order.
                            else if($stockAvailable == 2){

                                // product name and product_entry id of item adjusted order amount
                                $adjustedOrder[] = ['name'=>$name, 'product_entryId'=>$product_entryId, 'newQty'=>$purchaseAmount, 'colour' => $colour];

                                // remove the cost of the item adjusted out of order 
                                $order_Total = $order_Total - $price*($initialPurchaseAmount - $purchaseAmount);

                            }
                            else if($stockAvailable == 1){
                                continue;
                            }

                        } 

                    //////////////////////////////////////////////////////////////////////
                    //                                                                  //
                    //////////////////////////////////////////////////////////////////////

                    // array turned back into a string
                    $_SESSION['order']  = implode(",", $_SESSION['order']);

                    // update the order items string and the total qty in the db 

                    updateOrderItemsAndTotal($_SESSION['orderId'], $_SESSION['order'], $numberOfItems);


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

                    ////////////////////////////////////////////////////////////////////////////////////////////////////////
                    //                                                                                                    //
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////


                    // fetch request response associated array created
                    $response = [];

                    // first fetch request response associative array item loaded into array 
                    $response['orderTotal'] = $order_Total;

                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    //         csrf token check &specific Messages to display for shortage or out of stock scenario           //
                    //        specify the total order amount when order affected n\by shortage or out of stock items          //
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        // make sure the Payfast form changed the csrf token and it is correct.
                        if($_SESSION['csrfToken'] == $csrfToken){

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

                                // update order status for the order
                                if(updateOrderStatus($_SESSION['orderId'], 'checked-out')){

                                    // delete session variables linked to the order
                                    unset($_SESSION['shippingId'], $_SESSION['cart'], $_SESSION['orderId'], $_SESSION['order']);
                                    
                                    //delete in db cart_items
                                    $removeRow = deleteCartItems($_SESSION['userData']['userId']);
                                }
                            }                        
                        
                            $response['csfrTokenFound'] = 1; // true response message for correct csfr token

                        } // if csrf token is incorrect, do not proceed
                        else{

                            $response['csfrTokenFound'] = 0; // false response message for  missing csfr token

                        }

                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    //                                                                                                        //
                    //                                                                                                        //
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    // response to checkout fetch request
                    echo json_encode($response); exit;
                    
                }
            }

            break;

    case 'checkout':
    default:

    header("Location: /shop/checkout/");

}