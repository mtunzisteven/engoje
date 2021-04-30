<?php

//This is the products controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';
    // Get the zalisting main model for use as needed
    require_once '../model/main-model.php';
    // Get the accounts model for use as needed
    require_once '../model/accounts-model.php';
    // Get the products adproductUpdateNavmin model for use as needed
    require_once '../model/products-model.php';

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    // Fetch all products and bring them to scope of all cases
    $products = getProducts();

    // Build products update Admin Nav
    $productUpdateNav = buildAdminProductsDisplay( $products);

    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){

        case 'create':

            include '../view/add-product.php';

         break;

         
        case 'update':
            $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);

            $product = getProduct($productId);
            $colour = getColours();
            $sizes = getSizes();
            $images = getImages();
            $categories = getCategories();

            //var_dump($colour); exit;


            $productUpdateDisplay = buildProductUpdateDisplay($product, $colour, $sizes, $images, $categories);

            include '../view/product-update.php';

         break;

         
        case 'delete':
            $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);

            include '../view/product-delete.php';

         break;

         
        case 'lookup':
            
            include '../view/product-admin.php';

         break;
        
        case 'product':
        default:
         include '../view/product-admin.php';
    }