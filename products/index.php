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

            $createProductForm = buildProductCreateForm();

            include '../view/add-product.php';

         break;

         case 'core':

            //echo 'Here'; exit;

            $productName = filter_input(INPUT_POST, 'productName',FILTER_SANITIZE_STRING);  
            $productShortDescr = filter_input(INPUT_POST, 'productShortDescr',FILTER_SANITIZE_STRING);
            $productPrice = filter_input(INPUT_POST, 'productPrice',FILTER_SANITIZE_NUMBER_INT);
            $productDescription = filter_input(INPUT_POST, 'productDescription',FILTER_SANITIZE_STRING);

            if(empty($productName) || empty($productShortDescr) || empty($productPrice) || empty($productDescription)){

                $message = "<p class='notice detail-span-bold'>Sorry, we couldn't added the Product.</p>";

            }else{

                $productCreationDate = date('Y-m-d H:i:s');

                $productAdded = addProduct($productName, $productShortDescr, $productPrice, $productDescription, $productCreationDate);

                 //echo $productAdded; exit;

                if($productAdded){

                    $message = "<p class='notice detail-span-bold'>Product Information Added!</p>";

                    // Choose and/or add category

                    // Choose and/or colours-sizes

                    $categories = getCategories(); //var_dump($categories); exit;
                    $colours = getColours(); //var_dump($colours); exit;
                    $sizes = getSizes(); //var_dump($sizes); exit;

                    $createVariationsForm = buildCreateVariationForm($categories, $colours, $sizes);

                    //var_dump($createVariationsForm); exit;

                    include '../view/add-each-product.php';
                    break;

                }

            }



            include '../view/add-product.php';

         break;

         case 'variations':

            var_dump($_POST['categoryId']); exit;

            $colours =$_POST['colourId'];

            $cleanColours = [];

            foreach($colours as $colourId){
                $cleanColours[] = filter_var($colourId, FILTER_DEFAULT);
            }

            $sizes =$_POST['sizeId'];

            $cleanSizes = [];

            foreach($sizes as $sizeId){
                $cleanSizes[] = filter_var($sizeId, FILTER_DEFAULT);
            }

            $categories =$_POST['categoryId'];

            $cleanCategories = [];

            foreach($categories as $categoryId){
                $cleanCategories[] = filter_var($categoryId, FILTER_DEFAULT);
            }

            var_dump($cleanCategories); exit;

            break;

        case 'each':


            

            break;
         
        case 'update':
            $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);

            $product = getProduct($productId);
            $colour = getColours();
            $sizes = getSizes();
            $images = getImages();
            $categories = getCategories();

            //var_dump($colour); exit;


            $productUpdateDisplay = buildProductUpdateDisplay($product, $colour, $sizes, $categories);

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