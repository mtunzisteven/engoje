<?php

// session expire reset: 180 sec
session_cache_expire();

//This is the shop controller for the site
session_start();

// Get the database connection file
require_once '../library/connections.php';
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

// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();


//initial pagination
$lim = 4;
$offset = 0;

// Fetch all products and bring them to scope of all cases
$products = getShopPaginations($lim, $offset);

// all shop products
$allProducts = getShopProducts();

// all items on sale
$saleItems = getSaleItems();

// get categories from db
$category = getCategories();

if(isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

    // input max and min price values
    $maxPrice = $_SESSION['maxPriceFilter'];
    $minPrice = $_SESSION['minPriceFilter'];

}else{

    // input max and min price values
    $maxPrice = getmaxPrice();
    $minPrice = 0;

}

$selected = "";

if(isset($_SESSION['categoryFilter'])){

    $selected = $_SESSION['categoryFilter'];

}

// build sidebar display
$sidebarDisplay  = buildShopSidebarCategory($category, $selected);
$sidebarDisplay .= buildShopSidebarPrice($minPrice, $maxPrice);
$sidebarDisplay .= buildShopSidebarColour($allProducts, 'colour');
$sidebarDisplay .= buildShopSidebarSize($allProducts, 'sizeValue');

// sanitize action variable
$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    // Single product view with details
    case 'product':

        // sanitize shared product id & colour
        $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['product_entryId'] = filter_input(INPUT_GET, 'product_entryId', FILTER_SANITIZE_STRING);
        $_SESSION['colourChoice'] = filter_input(INPUT_GET, 'colour', FILTER_SANITIZE_STRING);

        $_SESSION['sale'] = getSaleItem($_SESSION['product_entryId']);

        // create new date time object
        $today = new DateTime();

        // format today datetime object
        $today->format('U');

        // create another datetime object with the sale start date of the product
        $saleStart = new DateTime($_SESSION['sale']['saleStart']);

        // format the date
        $saleStart->format('Y-m-d H:i:s');

        // today minus the date when the sale started
        $interval = [date_diff($today, $saleStart)];

        // the number of days since start of sale
        $days = ($interval[0]->h)/24;

        // Set price and style appearance for sale items
        if(!empty($_SESSION['sale'])){

            // if sale has not expired
            if($days < $_SESSION['sale']['salePeriod']){

                $_SESSION['salePrice'] = $_SESSION['sale']['salePrice'];
                $_SESSION['sale_product_entryId'] = $_SESSION['sale']['product_entryId'];

                $_SESSION['hidden'] = '';
                $_SESSION['strikeThrough'] = 'strike-through';

            }else{ //when the sale has expired, hide the feature

            $_SESSION['hidden'] = 'hidden';
            $_SESSION['strikeThrough'] = '';

        }


        }else{ //if there's no sale at all, just hide the sale feature

            $_SESSION['hidden'] = 'hidden';
            $_SESSION['strikeThrough'] = '';

        }
        
        //get all the product details for using shared productId
        $_SESSION['productData'] = getShopProduct($productId);

        // get the different swatches available to this productId
        $productSwatch = getShopSwatchProduct($productId);
        
        // build a swatch display for the sizes
        $_SESSION['sizes'] = buildProductSwatchesDisplay($productSwatch, 'sizeValue');

        // build a swatch display for the colours
        $_SESSION['colours'] = buildProductSwatchesDisplay($productSwatch, 'colour');

        header('Location: /engoje/shop/product/');
        
        break;

// when a colour swatch is selected - Ajax request
case 'colour-swatch':
    // sanitize the received variables
    $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
    $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_STRING);

    // makes sure variables aren't empty
    if(!empty($productId) || !empty($colour)){

        // when none-empty, get the product with this product id the selected colour
        // only one product per colour is tied to an image, so one will be returned
        // if it exists in the db.
        $newData = getColourSwatchShopProduct($productId, $colour);

        // if there is such a product, proceed
        if(!empty($newData)){

            $gallery = getSwatchImages($newData[0]['product_entryId']);

            $galleryPaths_tn = [];
            $galleryPaths = [];

            foreach($gallery as $image){

                $galleryPaths_tn[] = $image['imagePath_tn'];
                $galleryPaths[] = $image['imagePath'];

            }

            // load the details of the product into an associative array
            $responseText['galleryPaths_tn'] = $galleryPaths_tn;
            $responseText['galleryPaths'] = $galleryPaths;
            $responseText['imagePath'] = $newData[0]['imagePath'];
            $responseText['product_entryId'] = $newData[0]['product_entryId'];
            $responseText['price'] = $newData[0]['price'];

            // send that associative array back to JS as an ajax response
            echo json_encode($responseText);

        }

    }else{

        echo "Error! The colour or product id are empty.";

    }

    break;

// when a size swatch is selected - Ajax request
case 'size-swatch':
        $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
        $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_STRING);
        $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);

        // if all the variables are none-empty, proceed
        if(!empty($productId) || !empty($colour) || !empty($size)){

            // get the product details of the product with the selected colour,
            // size, and product id. only one will have this combination of variables
            $newData = getSizeSwatchedShopProduct($productId, $colour, $size);
            
            //var_dump($colour); exit;

            // if this product is found in the db, proceed
            if(!empty($newData)){

                // load the associative array with the response data
                $responseText['product_entryId'] = $newData[0]['product_entryId'];
                $responseText['price'] = $newData[0]['price'];

                // send the associative array back to the js Ajax
                echo json_encode($responseText);

            }else{
                echo '';
            }

        }else{

            echo "Error! The size or product id are empty.";

        }

        break;

    case 'next':

        $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_NUMBER_INT);

        $offset += $lim;

        // Fetch all products and bring them to scope of all cases
        $products = getShopPaginations($lim, $offset);

        // get next offset
        $products = filters($products, $lim, $offset);

        if(!empty($products)){

            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $productsDisplay = '<p class="notice"><br/>No products found...</p>';

        }

        include '../view/shop.php';

        break;

    case 'prev':

        $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_NUMBER_INT);

        if($offset > 0){

            $offset -= $lim;
        }

        // Fetch all products and bring them to scope of all cases
        $products = getShopPaginations($lim, $offset);

        // get next offset
        $products = filters($products, $lim, $offset);

    
        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $productsDisplay = '<p class="notice"><br/>No products found...</p>';

        }

        include '../view/shop.php';

        break;

    case 'filters':

        include '../view/shop.php';

        break;

    default:

        $products = filters($products, $lim, $offset);

        if(!empty($products)){

            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $productsDisplay = '<p class="notice"><br/>No products found...</p>';

        }

        include '../view/shop.php';
    }


function filters($products, $lim, $offset){

    // colour price category size
    if(isset( $_SESSION['sizeFilter']) && isset( $_SESSION['categoryFilter'])  && isset( $_SESSION['colourFilter']) && isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopSizeColourCategoryPrice($_SESSION['sizeFilter'], $_SESSION['colourFilter'], $_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopSizeColourCategoryPricePaginations($lim, $offset, $_SESSION['sizeFilter'], $_SESSION['colourFilter'], $_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    }  // colour price category
    else if(isset( $_SESSION['categoryFilter'])  && isset( $_SESSION['colourFilter']) && isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopColourCategoryPrice($_SESSION['colourFilter'], $_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopColourCategoryPricePaginations($lim, $offset, $_SESSION['colourFilter'], $_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    }  // size price category
    else if(isset( $_SESSION['categoryFilter'])  && isset( $_SESSION['sizeFilter']) && isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopSizeCategoryPrice($_SESSION['sizeFilter'], $_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopSizeCategoryPricePaginations($lim, $offset, $_SESSION['sizeFilter'], $_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    }
    // colour price size
    else if(isset( $_SESSION['sizeFilter']) && isset( $_SESSION['colourFilter']) && isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopSizeColourPrice($_SESSION['sizeFilter'], $_SESSION['colourFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopSizeColourPricePaginations($lim, $offset, $_SESSION['sizeFilter'], $_SESSION['colourFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    } // colour price 
    else if(isset( $_SESSION['colourFilter']) && isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopColourPrice($_SESSION['colourFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopColourPricePaginations($lim, $offset, $_SESSION['colourFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    }   // price size
    else if(isset( $_SESSION['sizeFilter']) && isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopSizePrice($_SESSION['sizeFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopSizePricePaginations($lim, $offset, $_SESSION['sizeFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    }   // price category
    else if(isset( $_SESSION['categoryFilter'])  && isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){
        
        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopCategoryPrice($_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopCategoryPricePaginations($lim, $offset, $_SESSION['categoryFilter'], $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    } // size colour category
    else if(isset( $_SESSION['sizeFilter']) && isset( $_SESSION['categoryFilter'])  && isset( $_SESSION['colourFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopSizeColourCategory($_SESSION['sizeFilter'], $_SESSION['colourFilter'], $_SESSION['categoryFilter']));

        // get next offset
        return getShopSizeColourCategoryPaginations($lim, $offset, $_SESSION['sizeFilter'], $_SESSION['colourFilter'], $_SESSION['categoryFilter']);

    } // colour category
    else if( isset($_SESSION['colourFilter']) && isset( $_SESSION['categoryFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopCategoryColour($_SESSION['categoryFilter'], $_SESSION['colourFilter']));

        // get next offset
        return getShopCategoryColourPaginations($lim, $offset, $_SESSION['categoryFilter'], $_SESSION['colourFilter']);

    } // size category
    else if(isset( $_SESSION['sizeFilter']) && isset( $_SESSION['categoryFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopCategorySize($_SESSION['categoryFilter'], $_SESSION['sizeFilter']));

        // get next offset
        return getShopCategorySizePaginations($lim, $offset, $_SESSION['categoryFilter'], $_SESSION['sizeFilter']);

    } // size colour
    else if(isset( $_SESSION['colourFilter']) && isset( $_SESSION['sizeFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopSizeColour( $_SESSION['sizeFilter'], $_SESSION['colourFilter']));

        // get next offset
        return getShopSizeColourPaginations($lim, $offset, $_SESSION['sizeFilter'], $_SESSION['colourFilter']);

    }  // price
    else if(isset($_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getProductsByPrice($_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']));

        // get next offset
        return getShopPricePaginations($lim, $offset, $_SESSION['minPriceFilter'], $_SESSION['maxPriceFilter']);

    }  // size
    else if(isset($_SESSION['sizeFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getProductsBySize($_SESSION['sizeFilter']));

        // get next offset
        return getShopSizePaginations($lim, $offset, $_SESSION['sizeFilter']);

    }  // category
    else if(isset($_SESSION['categoryFilter'])){

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopCategory($_SESSION['categoryFilter']));

        // get next offset
        return getShopCategoryPaginations($lim, $offset, $_SESSION['categoryFilter']);

    }  // colour
    else if(isset($_SESSION['colourFilter'])){

        //echo $_SESSION['colourFilter']; exit;

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getProductsByColour($_SESSION['colourFilter']));

        // get next offset
        return getShopColourPaginations($lim, $offset, $_SESSION['colourFilter']);

    } // all products   
    else{

        // get total prod quantity in filter
        $_SESSION['productQty'] = count(getShopProducts());

        return $products;

    }
}