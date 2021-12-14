<?php



//This is the Accounts Controller for the site
session_start();

// Get the database connection file
require_once '../library/connections.php';
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

        // echo $orderId; exit;

        // Id must not be empty
        if(!empty($orderId)){

            // deletion of order must occur
            if(deleteOrder($orderId)){

                // Send message
                $message = "Order deleted!";

            }else{

                $message = "Error deleting";

            }

        }else{
            $message = "Empty orderId";

        }
    
        $ordersAdminTable = buildordersAdminTable($orders);

        header('Location: /engoje/orders/'); exit;

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

        header('Location: /engoje/orders/'); exit;

        break;

    case 'update-orderStatus':

        $orderId = filter_input(INPUT_POST, 'orderId',FILTER_SANITIZE_NUMBER_INT);
        $orderStatus = filter_input(INPUT_POST, 'orderStatus',FILTER_SANITIZE_STRING);

        // Id must not be empty
        if(!empty($orderId) && !empty($orderStatus)){

            // deletion of order must occur
            if(updateOrderStatus($orderId, $orderStatus)){

                // Send message
                $message = "<p>Order status changed to $orderStatus</p>";

            }else{

                $message = "Error updating order status";

            }

        }else{
            $message = "Empty order status";

        }
    
        $ordersAdminTable = buildordersAdminTable($orders);

        header('Location: /engoje/orders/'); exit;

        break;
    
    case 'orders':

        $ordersAdminTable = buildordersAdminTable($orders);

        include '../view/orders.php';

        break;

    default:

        $ordersAdminTable = buildordersAdminTable($orders);

        include '../view/orders.php';

}

