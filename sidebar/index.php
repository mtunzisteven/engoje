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

// get price max and min from db
$maxPriceAll = getmaxPrice();
$minPriceAll = getminPrice();

//echo $productsQty; exit;

// sanitize action variable
$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){

    case "colour-filter":

        $colour = "black";

        $products = getShopColourPaginations($lim, $offset, $colour);

        // BUild a products archive
        $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty);

        include '../view/shop.php';

        break;

    case "size-filter":

        $size = "black";

        $products = getShopSizePaginations($lim, $offset, $size);

        // BUild a products archive
        $productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty);

        include '../view/shop.php';

        break;

    case "price-filter":



        break;

    default:

        // get the innput price values
        $minPrice = filter_input(INPUT_POST, 'minPrice',FILTER_SANITIZE_NUMBER_INT);
        $maxPrice = filter_input(INPUT_POST, 'maxPrice',FILTER_SANITIZE_NUMBER_INT);

        var_dump($_POST); exit;

        // build side bar display
        $_SESSION['$sidebarDisplay'] = buildShopSidebar($minPriceAll, $maxPriceAll,$minPrice, $maxPrice);

        // get filtered products form db
        $products = getShopPricePaginations($lim, $offset, $minPrice, $maxPrice);

        // BUild a products archive
        $_SESSION['productsDisplay'] = buildproductsDisplay($products, $offset, $lim, $productsQty);

        header('Location: /zalisting/shop/');

    }

