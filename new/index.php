<?php

//This is the shop controller for the site// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 


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
$products = getNewShopProducts($lim, $offset);

$productsQty = count($products);

// BUild a products archive
$productsDisplay = buildNewProductsDisplay($products, $saleItems);

include '../view/new.php';
