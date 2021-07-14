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

// Fetch all products on sale and bring them to scope of all cases
$products = getShopProducts();

// BUild a products archive
$productsDisplay = buildproductsDisplay($products);

//var_dump($productsDisplay); exit;

include '../view/new.php';
