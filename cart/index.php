<?php



//This is the shop controller for the site cart responsible for all cart related actions, except go to cart// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 


// Get the database connection file
require_once '../library/connections.php';
// Get the cleaner script 
require_once '../library/dbCleaner.php';
// Get the database connection file
require_once '../library/functions.php';
// Get the side navs library
require_once '../library/sidenav.php';
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
// Get the products orders model for use as needed
require_once '../model/orders-model.php';

// Fetch all products and bring them to scope of all cases
$products = getShopProducts();


$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    // add to cart request: Ajax request
    case 'add-to-cart':

        // sanitize the variables received from Ajax request
        $product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);
        $cart_item_qty = filter_input(INPUT_POST, 'cart_item_qty', FILTER_SANITIZE_NUMBER_INT);

        // if the variables are none-empty, proceed
        if(!empty($product_entryId) || !empty($cart_item_qty)){

            // get the qty of the item in the db
            $amount = getProductQty($product_entryId)['amount'];

            // only add it into cart if it is in stock
            if($amount > 0){
                                
                if($amount >= $cart_item_qty){

                    // for all logged in users use the code block below
                    if(isset($_SESSION['userData'])){
   
                        // get the user id of the logged in user
                        $userId = $_SESSION['userData']['userId'];
    
                        // get allcart items for this user
                        $cartItems = getCartItems($userId);
    
                        // if product_entry exists in the db cart items table for the user don't bother adding it
                        if(!checkIfValueExists($cartItems, 'product_entryId', $product_entryId)){

                            // date item added to cart
                            $dateAdded = date('Y-m-d H:i:s');
    
                            // get product entry details to access the image path below
                            $productDetails = getShopProductEntry($product_entryId);
    
                            // get the image path
                            $imagePath = getImage($productDetails['productId'], $productDetails['colour']); 
    
                            // add the items to the cart
                            $addToCart = addCartItem($product_entryId, $cart_item_qty, $userId, $imagePath['imagePath_tn'], $dateAdded);
    
                            if($addToCart){
    
                                // get all cart items for the user
                                $updatedCartItems = getCartItems($userId);
                
                                // sum all item quantities
                                $_SESSION['cartTotal'] = sumAllValues($updatedCartItems, 'cart_item_qty');
    
                                // add the cart total to the response array
                                $responseText['cartTotal'] = $_SESSION['cartTotal'];
    
                                // add the response text to the response array
                                $responseText['add-to-cart-response'] = "<p class='adding-alert'>$cart_item_qty products added to <a href='/engoje/cart?action=cart'>cart</a></p>";
    
                                // send the associative array back to the js Ajax
                                echo json_encode($responseText);
    
    
                            }
    
                        }else{// if the item already found in db for the same user, don't add it again, just increase its quantity

                            // get the qty of the item in the db cart already added
                            $cartAmount = getCartItemQty($product_entryId, $userId)['cart_item_qty'];
    
                            // if not all items in stock have already been added/bought
                            if($amount > $cartAmount){
    
                                // get all cart items for the user
                                $cartItems = getCartItems($userId);
    
                                // get the index of the item that matches the value in the db
                                $itemIndex = getIndexFromArr($cartItems, 'product_entryId', $product_entryId);
    
                                // get the new total amount of this item
                                $newQty = sumValues($cartItems, 'cart_item_qty', $cart_item_qty);
                
                                // update the db item with the new quantity from above
                                $updateCartQty = updateCartQty($cartItems[$itemIndex]['cart_itemId'], $newQty);
    
                                // get all cart items for the user
                                $updatedCartItems = getCartItems($userId);
                    
                                if($updatedCartItems){
    
                                    // sum all item quantities
                                    $_SESSION['cartTotal'] = sumAllValues($updatedCartItems, 'cart_item_qty');
    
                                    // add the cart total to the response array
                                    $responseText['cartTotal'] = $_SESSION['cartTotal'];
    
                                    // add the response text to the response array
                                    $responseText['add-to-cart-response'] = "<p class='adding-alert'>$cart_item_qty products added to <a href='/engoje/cart?action=cart'>cart</a></p>";
    
                                    // send the associative array back to the js Ajax
                                    echo json_encode($responseText);
    
                                }else{
    
                                    // add the cart total to the response array
                                    $responseText['cartTotal'] = $_SESSION['cartTotal'];
    
                                    // add the response text to the response array
                                    $responseText['add-to-cart-response'] = "<p class='adding-alert'>Error! Product not added.</p>";
    
                                    // send the associative array back to the js Ajax
                                    echo json_encode($responseText);
    
                                }
    
                            }else{//if the max items in db is added, return info
    
                        
    
                                // add the cart total to the response array
                                $responseText['cartTotal'] = $_SESSION['cartTotal'];
        
                                $responseText['add-to-cart-response'] = "<p class='adding-alert'>Only $amount in stock!</p>";
        
                                // send the associative array back to the js Ajax
                                echo json_encode($responseText);
        
                            }
                        }                    
    
                    }
                }else{

                    // add the cart total to the response array
                    $responseText['cartTotal'] = $_SESSION['cartTotal'];

                    $responseText['add-to-cart-response'] = "<p class='adding-alert'>Only $amount in stock!</p>";

                    // send the associative array back to the js Ajax
                    echo json_encode($responseText); exit;

                }
            }else{ //if item is out of stock, return info

                // add the cart total to the response array
                $responseText['cartTotal'] = $_SESSION['cartTotal'];

                $responseText['add-to-cart-response'] = "<p class='adding-alert'>Out of stock!</p>";

                // send the associative array back to the js Ajax
                echo json_encode($responseText);

            }
        }

        break;

    case 'update-cart':

        // turn string into array
        $cartUpdateArr = explode(",", $_POST['cartUpdateArr']);

        // filter external input array
        $cartUpdateArr  = filter_var_array($cartUpdateArr);

        $_SESSION['cartUpdateArr'] = $cartUpdateArr;

        if(isset($cartUpdateArr)){

            if(isset($_SESSION['userData'])){

                // fetch all the cart items for this user
                $cartItems = getCartItems($_SESSION['userData']['userId']);

                if($cartItems){

                    // set the cart total to zero
                    $_SESSION['cartTotal'] = 0;

                    // iterate through the cart items you fetched
                    for($i = 0; $i < count($cartItems); $i++){

                        // update each items quantity
                        $cartItems[$i]['cart_item_qty'] = $cartUpdateArr[$i];

                        // send the updates to the db
                        $updateCartQty = updateCartQty($cartItems[$i]['cart_itemId'], $cartItems[$i]['cart_item_qty']);
    
                        // update the total session variable with a sum of all the new values
                        $_SESSION['cartTotal'] += $cartUpdateArr[$i];

                    }

                    echo $_SESSION['cartTotal'];
                    exit;
                }

            }

        }


        break;

    // delete one product entry from the cart
    case 'remove-cart-item':

        // sanitize the variables received from Ajax request
        $product_entryId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

        // If the user is logged in
        if(isset($_SESSION['userData'])){
            
            // remove the cart item
            $removeRow = deleteCartItem($product_entryId, $_SESSION['userData']['userId']);

            // delete cart display session variable
            unset($_SESSION['cartDisplay']);

            
            // delete order
            deleteOrder($_SESSION['orderId']);

            unset($_SESSION['orderId']);

        }

        // redirect to the cart page
        header('Location: /engoje/cart/');


        break;

    // get the cart total number of items count
    case 'cart-count':

        // define cart total and initialize it to a value of 0
        $_SESSION['cartTotal'] = 0;

        if(isset($_SESSION['userData'])){

            $cartItems = getCartItems($_SESSION['userData']['userId']);

            foreach($cartItems as $cartItem){

                // get a total of all the items in the cart
                $_SESSION['cartTotal'] += $cartItem['cart_item_qty'];
            }
        }

        // return the cart total to ajax request
        echo $_SESSION['cartTotal'];

        break;

    case 'clear-cart':

        if(isset($_SESSION['userData'])){

            //delete in db cart_items
            $removeRow = deleteCartItems($_SESSION['userData']['userId']);

            // delete cart display session variable
            unset($_SESSION['cartDisplay']);

            unset($_SESSION['orderId']);

        }

        header('Location: /engoje/cart/');

        break;

    // cart page accessing through icon or link in product page
    default:

        header('Location: /engoje/shop/cart/');  
        
    }
