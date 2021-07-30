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
$productsDisplay = buildproductsDisplay($products, $offset, $lim, $productsQty, $saleItems);

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
$sidebarDisplay  = buildShopSidebarPrice($minPrice, $maxPrice);
$sidebarDisplay .= buildShopSidebarColour($products, 'colour');
$sidebarDisplay .= buildShopSidebarSize($products, 'sizeValue');
$sidebarDisplay .= buildShopSidebarCategory($category);

include '../view/sale.php';
