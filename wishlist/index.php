<?php



//This is the shop controller for the site// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 


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
// Get the products wishlist model for use as needed
require_once '../model/wishlist-model.php';

// Fetch all products and bring them to scope of all cases
$products = getShopProducts();


$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    // add to wishlist request: Ajax request
    case 'add-to-wishlist':
        // sanitize the variables received from Ajax request
        $product_entryId = filter_input(INPUT_POST, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

        // if the variables are none-empty, proceed
        if(!empty($product_entryId)){

            if(isset($_SESSION['userData'])){

                $alreadyAdded = getWishlistItemByUser($product_entryId, $_SESSION['userData']['userId']);

                if($alreadyAdded){ // Item already added to wishlist of the user


                    // get items already added
                    $Added = getWishlistItems($_SESSION['userData']['userId']);
        
                    // add the cart total to the response array
                    $responseText['wishlistTotal'] = count($Added);

                    // add the response text to the response array
                    $responseText['add-to-wishlist-response'] = "<p class='adding-alert'>Product already added to <a href='/engoje/wishlist?action=wishlist'>wish list</a></p>";

                    // send the associative array back to the js Ajax
                    echo json_encode($responseText);

                }else{ // Item not already added to wishlist of the user

                    // date item added to cart
                    $dateAdded = date('Y-m-d H:i:s');

                    // get product entry details to access the image path below
                    $productDetails = getShopProductEntry($product_entryId);

                    // get the thumbnail image path
                    $imagePath = getImage($productDetails['productId'], $productDetails['colour']);
        
                    // get the user id of the logged in user
                    $userId = $_SESSION['userData']['userId'];

                    // add the items to the cart
                    $addTowishlist = addWishlistItem($userId, $product_entryId, $imagePath['imagePath_tn'], $dateAdded);

                    if($addTowishlist){

                        // get items already added
                        $Added = getWishlistItems($_SESSION['userData']['userId']);
            
                        // add the cart total to the response array
                        $responseText['wishlistTotal'] = count($Added);

                        // add the response text to the response array
                        $responseText['add-to-wishlist-response'] = "<p class='adding-alert'>Product added to <a href='/engoje/wishlist?action=wishlist'>wish list</a></p>";

                        // send the associative array back to the js Ajax
                        echo json_encode($responseText);
                    }

                }

            }else{

                $alreadyAdded = 0; // default value when item is not found in the wishlist session variable

                // check if the item already exists
                if(isset($_SESSION['wishlist'])){

                    // check the entrire wishlist session variable for the item
                    foreach($_SESSION['wishlist'] as $wishlistItem){

                        if($wishlistItem['product_entryId'] == $product_entryId){

                            $alreadyAdded = 1; // 1 when item already added

                        }
                    }
                }

                if($alreadyAdded){// Item already added to wishlist of the user

                    // add the response text to the response array
                    $responseText['add-to-wishlist-response'] = "<p class='adding-alert'>Product already added to <a href='/engoje/wishlist?action=wishlist'>wish list</a></p>";

                     // define wishlist total and initialize it to a value of 0
                     $_SESSION['wishlistTotal'] = count($_SESSION['wishlist']);

                     // add the wishlist total to the response array
                     $responseText['wishlistTotal'] = $_SESSION['wishlistTotal'];

                    // send the associative array back to the js Ajax
                    echo json_encode($responseText);

                }else{

                    // create a session variable with the variables
                    $_SESSION['wishlist'][] = [
                        'product_entryId' => $product_entryId, 
                    ];

                    // define wishlist total and initialize it to a value of 0
                    $_SESSION['wishlistTotal'] = count($_SESSION['wishlist']);

                    // add the wishlist total to the response array
                    $responseText['wishlistTotal'] = $_SESSION['wishlistTotal'];

                    // add the response text to the response array
                    $responseText['add-to-wishlist-response'] = "<p class='adding-alert'>Product added to <a href='/engoje/wishlist?action=wishlist'>wish list</a></p>";

                    // send the associative array back to the js Ajax
                    echo json_encode($responseText);

                }
            }
        }

        break;

    // delete one product entry from the cart
    case 'remove-wishlist-item':                   

        // sanitize the variables received from Ajax request
        $product_entryId = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_NUMBER_INT);

        // if the user is logged in
        if(isset($_SESSION['userData'])){
    
            // remove the cart item
            $removeRow = deleteWishlistItem($product_entryId, $_SESSION['userData']['userId']);

            // remove wishlist display session variable
            unset($_SESSION['wishlistDisplay']);


        }else if(isset($_SESSION['wishlist'])){

            // if there is one item in the cart
            if(count($_SESSION['wishlist']) == 1){

                // remove it
                unset($_SESSION['wishlist']);

                // remove wishlist display session variable
                unset($_SESSION['wishlistDisplay']);
        

            }
            
            // if there are more than 1 item
            else{


                for($i = 0; $i < count($_SESSION['wishlist']); $i++){


                    //var_dump($_SESSION['wishlist']); exit;

                    // go through all the items and find one that has the same product id
                    if($_SESSION['wishlist'][$i]['product_entryId'] == $product_entryId){

                        //echo 'Delete logic'; exit;

                        // delete it
                        unset($_SESSION['wishlist'][$i]);

                        // reindex the array
                        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);

                    }

                }

            }


        }

        // redirect to the cart page
        header('Location: /engoje/wishlist/?action=wishlist');


        break;

    // get the cart total number of items count
    case 'wishlist-count':

        $responseText['wishlistTotal'] = 0; // The value given when user not logged in and no session variable set for wishlist

        if(isset($_SESSION['userData'])){

            // get items already added
            $Added = getWishlistItems($_SESSION['userData']['userId']);

            // add the cart total to the response array
            $responseText['wishlistTotal'] = count($Added);

        }else if(isset($_SESSION['wishlist'])){

            // reindex the array
            $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);

            $responseText['wishlistTotal'] = count($_SESSION['wishlist']);

        }

        // return the cart total to ajax request
        echo $responseText['wishlistTotal'];

        break;

    case 'clear-wishlist':

        if(isset($_SESSION['wishlist'])){

            // remove wishlist display session variable
            unset($_SESSION['wishlist']);
            // remove wishlist display session variable
            unset($_SESSION['wishlistDisplay']);

        }

        if(isset($_SESSION['userData'])){

            // remove from db wishlist_items
            $removeRow = deleteWishlistItems($_SESSION['userData']['userId']);

            // remove wishlist display session variable
            unset($_SESSION['wishlistDisplay']);

        }

        header('Location: /engoje/wishlist/');

        break;
    
    default:

    // cart page accessing through icon or link in product page
    case 'wishlist':

        // create an empty array
        $duplicatedWishlistDetails = [];

        if(isset($_SESSION['userData'])){ // for logged in users

            $wishlistItems = getWishlistItems($_SESSION['userData']['userId']);

            if($wishlistItems){

                // delete cart items from session if there are cart items from db
                if(isset($_SESSION['wishlist'])){ 

                    unset($_SESSION['wishlist']);

                }

                // create a display cart variable to use in the view
                $_SESSION['wishlistDisplay'] = buildWishlistDisplay($wishlistItems);

            }

            // if user logged in and no wishlist exists for the user in db
            // but there is in the session
            else if(isset($_SESSION['wishlist'])){ 

                foreach($_SESSION['wishlist'] as $orderItem){
    
                    // get product entry details to access the image path below
                    $productDetails = getShopProductEntry($orderItem['product_entryId']);
    
                    // get the thumbnail image path
                    $imagePath = getImage($productDetails['productId'], $productDetails['colour']);
            
                    // Make an array of all the cart display data including the image
                    $duplicatedWishlistDetails[] = $productDetails + getImage($productDetails['productId'], $productDetails['colour']);
    
                }

                // clear cart item session variable
                unset($_SESSION['wishlist']);
                
                // create a display cart variable to use in the view
                $_SESSION['wishlistDisplay'] = buildWishlistDisplay($duplicatedWishlistDetails);

            }else{
                $_SESSION['message'] = '<p class="notice">Your wish list is empty...</p>';
            }


        }
                
        //user not logged in so cart session variable will be used exclusively  
        else{ 

            // if there are wishlist session variables available, proceed
            if(isset($_SESSION['wishlist'])){

                foreach($_SESSION['wishlist'] as $orderItem){


                    // Make an array of cart display items, with the exception of the image
                    $productDetails = getShopProductEntry($orderItem['product_entryId']);

    
                    // Make an array of all the cart display data including the image
                    $duplicatedWishlistDetails[] = $productDetails + getImage($productDetails['productId'], $productDetails['colour']);
    
                }

                //var_dump($duplicatedWishlistDetails); exit;
                
                // build a cart display
                $_SESSION['wishlistDisplay'] = buildWishlistDisplay($duplicatedWishlistDetails);

            }else{

                $_SESSION['message'] = '<p class="notice">Your wish list is empty...</p>';

            }

        }

        header('Location: /engoje/shop/wishlist/');  
    }

