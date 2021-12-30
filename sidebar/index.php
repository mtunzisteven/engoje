<?php



//This is the shop controller for the site


// start session with same id in this file
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

// active tab array
$_SESSION['active_tab'] = $active_tabs;

// Get the side navs library
require_once '../library/sidenav.php';
// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

//initial pagination
$lim = 8;
$offset = 0;

// Fetch all products and bring them to scope of all cases
$products = getShopPaginations($lim, $offset);

// Get all products in db
$allProducts = getShopProducts();

// all items on sale
$saleItems = getSaleItems();

// Get the total number products in db
$productsQty = count($allProducts);

// get colours and sizes from db
$colours = getColours();
$sizes = getSizes();

// sanitize action variable
$filter = filter_input(INPUT_POST, 'filter',FILTER_SANITIZE_STRING);
if ($filter == NULL){
    $filter = filter_input(INPUT_GET, 'filter',FILTER_SANITIZE_STRING);
}

switch ($filter){ 

    case "colour-filter":

        // get the input colour value
        $_SESSION['colourFilter'] = filter_input(INPUT_GET, 'colour',FILTER_SANITIZE_STRING);

        // fetch all products
        $products = shopFilters($products, $lim, $offset);

        // make sure products isn't empty
        if(!empty($products)){
            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/sidebar/?filter=clear-shopFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/shop/?action=shopFilters');

        break;

    case "category-filter":

        // get the input size value
        $_SESSION['categoryFilter'] = filter_input(INPUT_GET, 'category',FILTER_SANITIZE_STRING);

        // remove category filter if all is found
        if($_SESSION['categoryFilter'] == 'all'){

            unset($_SESSION['categoryFilter']);

        }

        $products = shopFilters($products, $lim, $offset);

        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/sidebar/?filter=clear-shopFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/shop/?action=shopFilters');
    
        break;

    case "size-filter":

        // get the input size value
        $_SESSION['sizeFilter'] = filter_input(INPUT_GET, 'size',FILTER_SANITIZE_STRING);

        $products = shopFilters($products, $lim, $offset);

        if(!empty($products)){
            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/sidebar/?filter=clear-shopFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/shop/?action=shopFilters');

        break;

    case "price-filter":

        // get the input price values
        $_SESSION['minPriceFilter'] = intval(filter_input(INPUT_GET, 'minPrice',FILTER_SANITIZE_NUMBER_INT));
        $_SESSION['maxPriceFilter'] = intval(filter_input(INPUT_GET, 'maxPrice',FILTER_SANITIZE_NUMBER_INT));

        //echo $maxPrice; exit;

        $products = shopFilters($products, $lim, $offset);

        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/sidebar/?filter=clear-shopFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/shop/?action=shopFilters');

        break;

    case "clear-shopFilters":

        unset($_SESSION['sizeFilter'], $_SESSION['categoryFilter'], $_SESSION['colourFilter'], $_SESSION['maxPriceFilter'], $_SESSION['minPriceFilter'], $_SESSION['productQty']);

        header('Location: /engoje/shop/');


        break;

    case "deletePriceFilter":

        unset($_SESSION['maxPriceFilter'], $_SESSION['minPriceFilter']);

        header('Location: /engoje/shop/');


        break;

    case "deleteSizeFilter":

        unset($_SESSION['sizeFilter']);

        header('Location: /engoje/shop/');


        break;

    case "deleteColourFilter":

        unset($_SESSION['colourFilter']);

        header('Location: /engoje/shop/');


        break;

    case "deleteCategoryFilter":

        unset($_SESSION['categoryFilter']);

        header('Location: /engoje/shop/');


        break;

    default:

        header('Location: /engoje/shop/');

}
