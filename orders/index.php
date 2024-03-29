<?php



//This is the Accounts Controller for the site// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 


// Get the database connection file
require_once '../library/connections.php';
// Get the cleaner script 
require_once '../library/dbCleaner.php';
// Get the functions library
require_once '../library/functions.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the acciunts model for use as needed
require_once '../model/accounts-model.php';
// Get the reviews model for use as needed
require_once '../model/reviews-model.php';  
// Get the orders model for use as needed
require_once '../model/orders-model.php'; 


// Build User Update Admin Nav
$userUpdateNav = buildUserUpdateNav();


$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

// active tab array
$_SESSION['active_tab'] = $active_tabs;
$_SESSION['active_tab']['orders'] = 'active';


// Get the side navs library
include '../library/sidenav.php';

// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

$orders = getOrders();


switch ($action) {

    case 'delete':

        $orderId = filter_input(INPUT_GET, 'orderId',FILTER_SANITIZE_NUMBER_INT);

        // Id must not be empty
        if(!empty($orderId)){

            // get the order items string from the db
            $order_items = getOrderItems($orderId)['order_items'];

            // deletion of order must occur
            if(deleteOrder($orderId)){

                /////////////////////////////////////////////////////////
                // reverse order item amount in the product entry table//
                /////////////////////////////////////////////////////////

                    if(!empty($order_items)){ 

                        /////////////////////////////////////////////////////////////////////////////////////
                        //             reverse order stock amount reduction done at checkout               //
                        /////////////////////////////////////////////////////////////////////////////////////


                            //string must be made an array 
                            $order_items = explode(",", $order_items);

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

                /////////////////////////////////////////////////////////
                //                                                     //
                /////////////////////////////////////////////////////////

                // Send message
                $message = "Order deleted!";

            }else{

                $message = "Error deleting";

            }

        }else{
            $message = "Empty orderId";

        }
    
        $ordersAdminTable = buildordersAdminTable($orders);

        header('Location: /orders/'); exit;

        break;

    case 'update-orderTracking':

        $orderId = filter_input(INPUT_POST, 'orderId',FILTER_SANITIZE_NUMBER_INT);
        $orderTracking = filter_input(INPUT_POST, 'orderTracking',FILTER_SANITIZE_STRING);

        // Id must not be empty
        if(!empty($orderId) && !empty($orderTracking)){

            // deletion of order must occur
            if(updateOrderTracking($orderId, $orderTracking)){

                // Send message
                $message = "<p>Order status changed to $orderTracking</p>";

            }else{

                $message = "Error updating order tracking";

            }

        }else{
            $message = "Empty order tracking";

        }
    
        $ordersAdminTable = buildordersAdminTable($orders);

        header('Location: /orders/'); exit;

        break;

    case 'update-orderStatus':

        $orderId = filter_input(INPUT_POST, 'orderId',FILTER_SANITIZE_NUMBER_INT);
        $orderStatus = filter_input(INPUT_POST, 'orderStatus',FILTER_SANITIZE_STRING);
        $async = filter_input(INPUT_POST, 'async',FILTER_SANITIZE_STRING);


        // Id must not be empty
        if(!empty($orderId) && !empty($orderStatus)){

            // update of order must occur
            if(updateOrderStatus($orderId, $orderStatus)){

                // Send message
                $message = "<p>Order status changed to $orderStatus</p>";

                // return to js with nothing
                if($async){

                    echo true; exit;

                }

            }else{

                $message = "Error updating order status";

            }

        }else{
            $message = "Empty order status";

        }
    
        $ordersAdminTable = buildordersAdminTable($orders);

        header('Location: /orders/'); exit;
    
    case 'orders':

        $ordersAdminTable = buildordersAdminTable($orders);

        include '../view/orders.php';

        break;

    default:

        $ordersAdminTable = buildordersAdminTable($orders);

        include '../view/orders.php';

}

