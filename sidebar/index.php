<?php

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

//initial pagination
$lim = 24;
$offset = 0;

// Fetch all products and bring them to scope of all cases
$products = getShopPaginations($lim, $offset);

// Get the number of products in db
$allProducts = getShopProducts();

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
        $colour = filter_input(INPUT_GET, 'colour',FILTER_SANITIZE_STRING);

        //echo $colour; exit;

        $products = getShopColourPaginations($lim, $offset, $colour);

        //var_dump($products); exit;

        // BUild a products archive
        $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty);

        header('Location: /zalisting/shop/?action=filters');

        break;

    case "size-filter":

        // get the input size value
        $size = filter_input(INPUT_GET, 'size',FILTER_SANITIZE_STRING);

        $products = getShopSizePaginations($lim, $offset, $size);

        // BUild a products archive
        $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty);

        header('Location: /zalisting/shop/?action=filters');

        break;

    case "price-filter":

        // get the input price values
        $minPrice = filter_input(INPUT_GET, 'minPrice',FILTER_SANITIZE_NUMBER_INT);
        $maxPrice = filter_input(INPUT_GET, 'maxPrice',FILTER_SANITIZE_NUMBER_INT);

        //echo $maxPrice; exit;

        // get filtered products form db
        $products = getShopPricePaginations($lim, $offset, $minPrice, $maxPrice);

        //var_dump($products); exit;

        if(!empty($products)){

            // BUild a products archive
            $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty);

        }else{

            // BUild a products archive
            $_SESSION['productsDisplay'] = '<p class="notice"><br/>No products found...</p>';

        }


        header('Location: /zalisting/shop/?action=filters');

        break;

    default:

        // get the innput price values
        $minPrice = filter_input(INPUT_POST, 'minPrice',FILTER_SANITIZE_NUMBER_INT);
        $maxPrice = filter_input(INPUT_POST, 'maxPrice',FILTER_SANITIZE_NUMBER_INT);

        var_dump($_POST); exit;

        // build side bar display
        $_SESSION['$sidebarDisplay'] = buildShopSidebarPrice($minPrice, $maxPrice);


        // get filtered products form db
        $products = getShopPricePaginations($lim, $offset, $minPrice, $maxPrice);

        // BUild a products archive
        $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty);

        header('Location: /zalisting/shop/');

    }

