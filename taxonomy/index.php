<?php

// session expire reset: 180 sec
session_cache_expire();

//This is the products controller for the site
    session_start();

    // Get the database connection file
    require_once '../library/connections.php';
    // Get the database connection file
    require_once '../library/functions.php';
    // Get the engoje main model for use as needed
    require_once '../model/main-model.php';
    // Get the accounts model for use as needed
    require_once '../model/accounts-model.php';
    // Get the products adproductUpdateNavmin model for use as needed
    require_once '../model/products-model.php';

    // Fetch all product entries and bring them to scope of all cases
    $products = getPrimaryProducts();

    // Create image paths for products of each colour but different size that don't have images
    // fetch all products first:
    $allProducts = getAllProducts();

    // Create an associative array  
    $nonImgedProducts = [];

    // active tab array
    $_SESSION['active_tab'] = $active_tabs;

    $_SESSION['active_tab']['taxonomy'] = "active";

    // Get the side navs library
    require_once '../library/sidenav.php';
    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){

        case 'add-colour':

            $colour = filter_input(INPUT_POST, 'colour',FILTER_SANITIZE_STRING);

            if(!empty($colour)){

                if(addColour($colour)){

                    // added successfully
                }


            }

            break;

        case 'add-size':

            $size = filter_input(INPUT_POST, 'size',FILTER_SANITIZE_STRING);

            if(!empty($size)){

                if(addColour($size)){

                    // added successfully
                }


            }

            break;

        case 'add-category':

            $category = filter_input(INPUT_POST, 'category',FILTER_SANITIZE_STRING);

            if(!empty($category)){

                if(addColour($category)){

                    // added successfully
                }


            }

            break;

        case 'taxonomy':

        default:            

            include '../view/taxonomy-manager.php';
}