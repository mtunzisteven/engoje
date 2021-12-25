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

// make sure to get all sale items
$saleItems = getSaleItems();

//initial pagination
$lim = 4;
$offset = 0;

// Fetch all products and bring them to scope of all cases
$products = getSaleShopProducts($lim, $offset);

// number of sale products in db
$productsQty = count($products);

// BUild a products archive
$productsDisplay = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

// get categories from db
$category = getSaleCategories();

if(isset( $_SESSION['SaleminPriceFilter'])  && isset( $_SESSION['SalemaxPriceFilter'])){

    // input max and min price values
    $maxPrice = $_SESSION['SalemaxPriceFilter'];
    $minPrice = $_SESSION['SaleminPriceFilter'];

}else{

    // input max and min price values
    $maxPrice = getsalemaxPrice();
    $minPrice = 0;

}

$selected = "";

if(isset($_SESSION['SalecategoryFilter'])){

    $selected = $_SESSION['SalecategoryFilter'];

}

// build sidebar display
$_SESSION['sidebarDisplay']  = buildSaleSidebarCategory($category, $selected);
$_SESSION['sidebarDisplay'] .= buildSaleSidebarPrice($minPrice, $maxPrice);
$_SESSION['sidebarDisplay'] .= buildSaleSidebarColour($products, 'colour');
$_SESSION['sidebarDisplay'] .= buildSaleSidebarSize($products, 'sizeValue');

// sanitize action variable
$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){
    case 'next':

        $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_NUMBER_INT);

        $offset += $lim;

        // Fetch sale products and bring them to scope of all cases
        $products = getShopPaginations($lim, $offset);

        // get next offset
        $products = saleFilters($products, $lim, $offset);

        if(!empty($products)){

            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $productsDisplay = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $productsDisplay = '<p class="notice"><br/>No products found...</p>';

        }

        include '../view/sale.php';

        break;

    case 'prev':

        $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_NUMBER_INT);

        if($offset > 0){

            $offset -= $lim;
        }

        // Fetch all products and bring them to scope of all cases
        $products = getShopPaginations($lim, $offset);

        // get next offset
        $products = saleFilters($products, $lim, $offset);

    
        if(!empty($products)){

            
            // reset quantity for paginations
            $productsQty = $_SESSION['productQty'];

            // BUild a products archive
            $productsDisplay = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

        }else{

            // BUild a products archive
            $productsDisplay = '<p class="notice"><br/>No products found...</p>';

        }

        include '../view/sale.php';

        break;

    case 'saleFilters':

        include '../view/sale.php';

        break;

    default:

        $products = saleFilters($products, $lim, $offset);

        // var_dump($products); exit;

        if(!empty($products)){

            // BUild a products archive
            $productsDisplay = buildSaleproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

            unset($_SESSION['productsDisplay']);

        }else{

            // BUild a products archive
            $productsDisplay = '<p class="notice"><br/>No products found...</p>';

        }

        include '../view/sale.php';
    
    }
