<?php



//This is the products controller for the site


// start session with same id in this file// start session with same id in this file
session_start();

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
                    header('Location: /engoje/taxonomy/?action=taxonomy');

                }


            }

            break;

        case 'add-size':

            $size = filter_input(INPUT_POST, 'size',FILTER_SANITIZE_STRING);
            $sizeName = filter_input(INPUT_POST, 'sizeName',FILTER_SANITIZE_STRING);

            if(!empty($size) && !empty($sizeName)){

                if(addSize($size, $sizeName)){

                    // added successfully
                    header('Location: /engoje/taxonomy/?action=taxonomy');

                }


            }

            break;

        case 'add-category':

            $category = filter_input(INPUT_POST, 'category',FILTER_SANITIZE_STRING);

            if(!empty($category)){

                if(addCategory($category)){

                    // added successfully
                    header('Location: /engoje/taxonomy/?action=taxonomy');

                }


            }

            break;

        case 'delete-colour':

            $colourId = filter_input(INPUT_POST, 'colourId',FILTER_SANITIZE_NUMBER_INT);

            //echo $colourId; exit;

            if(!empty($colourId)){

                if(deleteColour($colourId)){

                    // added successfully
                    header('Location: /engoje/taxonomy/?action=taxonomy');

                }


            }

            break;

        case 'delete-size':

            $sizeId = filter_input(INPUT_POST, 'sizeId',FILTER_SANITIZE_NUMBER_INT);

            if(!empty($sizeId)){

                if(deleteSize($sizeId)){

                    // added successfully
                    header('Location: /engoje/taxonomy/?action=taxonomy');

                }


            }

            break;

        case 'delete-category':

            $categoryId = filter_input(INPUT_POST, 'categoryId',FILTER_SANITIZE_NUMBER_INT);

            if(!empty($categoryId)){

                if(deleteCategory($categoryId)){

                    // added successfully
                    header('Location: /engoje/taxonomy/?action=taxonomy');

                }


            }

            break;

        case 'taxonomy':

            // get taxonomies to create displays for them
            $colours = getColours();
            $sizes = getSizes();
            $categories = getCategories();

        default:            

            include '../view/taxonomy-manager.php';
}