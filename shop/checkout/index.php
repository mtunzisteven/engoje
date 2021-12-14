<?php



// This is the shop controller for the site checkout responsible only for the default action: go to checkout
// Provides a clean checkout url
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
// Get the products accounts model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/engoje/model/accounts-model.php';

// Fetch all products and bring them to scope of all cases
$products = getShopProducts();


$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    case "addressed":
        // Billing address inputs
        $bname = filter_input(INPUT_POST, 'bname',FILTER_SANITIZE_STRING);
        $bphone = filter_input(INPUT_POST, 'bphone',FILTER_SANITIZE_STRING);
        $bemail = filter_input(INPUT_POST, 'bemail',FILTER_SANITIZE_STRING);
        $baddressLine1 = filter_input(INPUT_POST, 'baddressLine1',FILTER_SANITIZE_STRING);
        $baddressLine2 = filter_input(INPUT_POST, 'baddressLine2',FILTER_SANITIZE_STRING);
        $bcity = filter_input(INPUT_POST, 'bcity',FILTER_SANITIZE_STRING);
        $bzipCode = filter_input(INPUT_POST, 'bzipCode',FILTER_SANITIZE_NUMBER_INT);   
        $baddressType = 1;

        if(addAddress($bname, $bphone, $bemail, $baddressLine1, $baddressLine2, $bcity, $bzipCode, $baddressType, $_SESSION['userData']['userId'])){

            $sameAddress = filter_input(INPUT_POST, 'sameAddress',FILTER_SANITIZE_NUMBER_INT);            
            $saddressType = 2;

            if($sameAddress){

                addAddress($bname, $bphone, $bemail, $baddressLine1, $baddressLine2, $bcity, $bzipCode, $saddressType, $_SESSION['userData']['userId']);

            }else{

                // Shipping address inputs
                $sname = filter_input(INPUT_POST, 'sname',FILTER_SANITIZE_STRING);
                $sphone = filter_input(INPUT_POST, 'sphone',FILTER_SANITIZE_STRING);
                $semail = filter_input(INPUT_POST, 'semail',FILTER_SANITIZE_STRING);
                $saddressLine1 = filter_input(INPUT_POST, 'saddressLine1',FILTER_SANITIZE_STRING);
                $saddressLine2 = filter_input(INPUT_POST, 'saddressLine2',FILTER_SANITIZE_STRING);
                $scity = filter_input(INPUT_POST, 'scity',FILTER_SANITIZE_STRING);
                $szipCode = filter_input(INPUT_POST, 'szipCode',FILTER_SANITIZE_NUMBER_INT);            

                addAddress($sname, $sphone, $semail, $saddressLine1, $saddressLine2, $scity, $szipCode, $saddressType, $_SESSION['userData']['userId']);


            }
            
        }

        header('Location: /engoje/shop/checkout/');
        break;


    default:

        $_SESSION['grandTotal'] = filter_input(INPUT_POST, 'grandTotal',FILTER_SANITIZE_NUMBER_INT); // the cart total excl shipping

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

                    // fetch each cart item qty for this user
                    $cartItemsQty = getCartQuantityForCheckout($_SESSION['userData']['userId'], $product_entryId)['cart_item_qty'];

                    // actual update of quantities done by this line.
                    $_SESSION['order'][$i] = $cartItemsQty;

                }

                // array turned back into a string
                $_SESSION['order']  = implode(",", $_SESSION['order']);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //                                            updating end                                                //
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // When this is a logged in user
            if($_SESSION['userData']){

                // get items that are on sale
                $saleItems = getOnSaleCartItems($_SESSION['userData']['userId']);   

                // receive order string from cart
                $order_items = $_SESSION['order'];


                if(isset($_POST['shippingId'])){ // When coming from cart, this will be true. Not required if reloading, as session var will be set

                    // receive order string from cart
                    $_SESSION['shippingId'] = $_POST['shippingId'];

                }

                // get the shipping info for chosen shipper
                $shippingInfo = getShipping($_SESSION['shippingId']);

                // update grand total to include shipping cost
                $_SESSION['grandTotal'] += $shippingInfo['price'];

                // get the user id of the logged in user
                $userId = $_SESSION['userData']['userId'];

                // get user address details for the user 
                // in checkout model using their id
                $userDetails = getUserDetails($userId);

                // users with no billing or shipping addresses added
                if(empty($userDetails)){

                    $_SESSION['checkoutAddressDisplay'] = buildCheckoutAddressDisplay($_SESSION['userData']['userId']);

                    include $_SERVER['DOCUMENT_ROOT'].'/engoje/view/checkout-address.php';  

                }else{ // users with billing and shipping addresses added

                    // fetch all user cart items in db
                    $checkoutDetails = getCartItems($userId);

                    // date customer went into checkout page
                    $checkoutDate = date('Y-m-d H:i:s');

                    $numberOfItems = $_SESSION['cartTotal'];

                    // when an order has been added to the db for this user
                    if(isset($_SESSION['orderId']) ){

                        // fetch the order from the db and compare it with the current order
                        $db_order_items = getOrderItems($_SESSION['orderId']);

                        // if they are identical, go on and display the checkout view
                        if($order_items === $db_order_items['order_items']){

                            // Update shipping and grand total of order
                            updateShippingnGrandT($_SESSION['orderId'], $_SESSION['shippingId'], $_SESSION['grandTotal']);

                            // build the checkout display
                            $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);

                        } else{ // if they do not match, delete the db order and restart the process

                            if(deleteOrder($_SESSION['orderId'])){

                                // create an order using the model function below.
                                $_SESSION['orderId'] = addOrder($userId, $order_items, $_SESSION['shippingId'], $checkoutDate, $numberOfItems, $_SESSION['grandTotal'] );

                                // build the checkout display
                                $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);

                            }
                        }

                    }else{

                        // create an order using the model function below.
                        $_SESSION['orderId'] = addOrder($userId, $order_items, $_SESSION['shippingId'], $checkoutDate, $numberOfItems, $_SESSION['grandTotal']);

                        // build the checkout display
                        $_SESSION['checkoutDisplay'] = buildCheckoutDisplay($checkoutDetails, $userDetails, $_SESSION['orderId'], $order_items, $shippingInfo);


                    }

                    include $_SERVER['DOCUMENT_ROOT'].'/engoje/view/checkout.php';  
                }

            }else{

                header('Location: /engoje/accounts/?action=login');
            }
        }else{

            header("Location: /engoje/shop/cart/");

        }
}



  