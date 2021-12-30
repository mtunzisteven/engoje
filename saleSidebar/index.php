<?php



//This is the shop controller for the site// start session with same id in this file
session_start();

// echo "Sale!"; exit;

// no session started var set yet = session just created 
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['STARTED'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_destroy();

    // set new session started var
    $_SESSION['STARTED'] = time();

}

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
$products = getSaleShopPaginations($lim, $offset);

// Get all sale products in db
$allProducts = getSaleItems();

// all items on sale
$saleItems = getSaleItems();

// Get the total number products in db
$productsQty = count($allProducts);

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
        $_SESSION['SalecolourFilter'] = filter_input(INPUT_GET, 'colour',FILTER_SANITIZE_STRING);

        // fetch all products in filter
        $products = saleFilters($products, $lim, $offset);

        // make sure products isn't empty
        if(!empty($products)){
            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/sidebar/?filter=clear-saleFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=saleFilters');

        break;

    case "category-filter":

        // get the input size value
        $_SESSION['SalecategoryFilter'] = filter_input(INPUT_GET, 'category',FILTER_SANITIZE_STRING);

        // remove category filter if all is found
        if($_SESSION['SalecategoryFilter'] == 'all'){

            unset($_SESSION['SalecategoryFilter']);

        }

        $products = saleFilters($products, $lim, $offset);

        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/sidebar/?filter=clear-saleFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=saleFilters');
    
        break;

    case "size-filter":

        // get the input size value
        $_SESSION['SaleSizeFilter'] = filter_input(INPUT_GET, 'size',FILTER_SANITIZE_STRING);

        $products = saleFilters($products, $lim, $offset);

        if(!empty($products)){
            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/sidebar/?filter=clear-saleFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=saleFilters');

        break;

    case "price-filter":

        // get the input price values
        $_SESSION['SaleminPriceFilter'] = intval(filter_input(INPUT_GET, 'minPrice',FILTER_SANITIZE_NUMBER_INT));
        $_SESSION['SalemaxPriceFilter'] = intval(filter_input(INPUT_GET, 'maxPrice',FILTER_SANITIZE_NUMBER_INT));

        $products = saleFilters($products, $lim, $offset);

        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = "<p class='notice'><br/>No products found...<br/><a href='/engoje/saleSidebar/?filter=clear-saleFilters' class='button'>Clear Filters</a></p>";

        }

        header('Location: /engoje/sale/?action=saleFilters');

        break;

    case "clear-saleFilters":

        unset($_SESSION['SaleSizeFilter'], $_SESSION['SalecategoryFilter'], $_SESSION['SalecolourFilter'], $_SESSION['SalemaxPriceFilter'], $_SESSION['SaleminPriceFilter'], $_SESSION['productQty']);

        header('Location: /engoje/sale/');


        break;

    case "deletePriceFilter":

        unset($_SESSION['SalemaxPriceFilter'], $_SESSION['SaleminPriceFilter']);

        header('Location: /engoje/sale/');


        break;

    case "deleteSizeFilter":

        unset($_SESSION['SaleSizeFilter']);

        header('Location: /engoje/sale/');


        break;

    case "deleteColourFilter":

        unset($_SESSION['SalecolourFilter']);

        header('Location: /engoje/sale/');


        break;

    case "deleteCategoryFilter":

        unset($_SESSION['SalecategoryFilter']);

        header('Location: /engoje/sale/');


        break;

    default:

        header('Location: /engoje/sale/');

    }



