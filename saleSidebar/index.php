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

// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

// make sure to get all sale items
$saleItems = getSaleItems();

//initial pagination
$lim = 4;
$offset = 0;

// Fetch all products and bring them to scope of all cases
$products = getSaleShopProducts($lim, $offset);

//var_dump($products); exit;

$productsQty = count($products);

// BUild a products archive
$productsDisplay = buildsaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

// get categories from db
$category = getSaleCategories();

if(isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter'])){

    // input max and min price values
    $maxPrice = $_SESSION['maxPriceFilter'];
    $minPrice = $_SESSION['minPriceFilter'];

}else{

    // input max and min price values
    $maxPrice = getmaxPrice();
    $minPrice = 0;

}


// build sidebar display
$saleSidebarDisplay  = buildShopSidebarPrice($minPrice, $maxPrice);
$saleSidebarDisplay .= buildShopSidebarColour($products, 'colour');
$saleSidebarDisplay .= buildShopSidebarSize($products, 'sizeValue');
$saleSidebarDisplay .= buildShopSidebarCategory($category);

// get colours and sizes from db
$colours = getColours();
$sizes = getSizes();

//echo $productsQty; exit;

// sanitize action variable
$filter = filter_input(INPUT_POST, 'filter',FILTER_SANITIZE_STRING);
if ($filter == NULL){
    $filter = filter_input(INPUT_GET, 'filter',FILTER_SANITIZE_STRING);
}

switch ($filter){

    case "colour-filter":

        // get the input colour value
        $_SESSION['colourFilter'] = filter_input(INPUT_GET, 'colour',FILTER_SANITIZE_STRING);

        //echo $_SESSION['colourFilter']; exit;

        $products = filters($products, $lim, $offset);

        //var_dump($products); exit;


        if(!empty($products)){
            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildsaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/saleSidebar/?filter=clear-filters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=filters');

        break;

    case "category-filter":

        // get the input size value
        $_SESSION['categoryFilter'] = filter_input(INPUT_GET, 'category',FILTER_SANITIZE_STRING);

        $products = filters($products, $lim, $offset);

        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildsaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/saleSidebar/?filter=clear-filters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=filters');
    
        break;

    case "size-filter":

        // get the input size value
        $_SESSION['sizeFilter'] = filter_input(INPUT_GET, 'size',FILTER_SANITIZE_STRING);

        $products = filters($products, $lim, $offset);

        if(!empty($products)){
            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildsaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/saleSidebar/?filter=clear-filters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=filters');

        break;

    case "price-filter":

        // get the input price values
        $_SESSION['minPriceFilter'] = filter_input(INPUT_GET, 'minPrice',FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['maxPriceFilter'] = filter_input(INPUT_GET, 'maxPrice',FILTER_SANITIZE_NUMBER_INT);

        //echo $maxPrice; exit;

        $products = filters($products, $lim, $offset);

        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildsaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/saleSidebar/?filter=clear-filters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=filters');

        break;

    case "clear-filters":

        unset($_SESSION['sizeFilter'], $_SESSION['categoryFilter'], $_SESSION['colourFilter'], $_SESSION['maxPriceFilter'], $_SESSION['minPriceFilter'], $_SESSION['productQty']);

        header('Location: /engoje/sale/');


        break;

    case "deletePriceFilter":

        unset($_SESSION['maxPriceFilter'], $_SESSION['minPriceFilter']);

        header('Location: /engoje/sale/');


        break;

    case "deleteSizeFilter":

        unset($_SESSION['sizeFilter']);

        header('Location: /engoje/sale/');


        break;

    case "deleteColourFilter":

        unset($_SESSION['colourFilter']);

        header('Location: /engoje/sale/');


        break;

    case "deleteCategoryFilter":

        unset($_SESSION['categoryFilter']);

        header('Location: /engoje/sale/');


        break;

    default:

        header('Location: /engoje/sale/');

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
    
    