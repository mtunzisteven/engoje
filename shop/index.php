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

    // Build Admin Side Nav
    $adminSideNav = buildAdminSideNav();

    // Fetch all products and bring them to scope of all cases
    $products = getShopProducts();


    $action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
    if ($action == NULL){
        $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
    }

    switch ($action){
        case 'product':
            $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);
            
            $productData = getShopProduct($productId);

            $productSwatch = getShopSwatchProduct($productId);

            $sizes = buildProductSwatchesDisplay($productSwatch, 'sizeValue');

            $colours = buildProductSwatchesDisplay($productSwatch, 'colour');

            //echo $productData[0]['product_entryId']; exit;

            include '../view/shop-product.php';
         
         break;

         case 'colour-swatch':
            $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
            $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_STRING);

            if(!empty($productId) || !empty($colour)){

                $newData = getColourSwatchShopProduct($productId, $colour);

                if(!empty($newData)){

                    $responseText['imagePath'] = $newData[0]['imagePath'];
                    $responseText['product_entryId'] = $newData[0]['product_entryId'];
                    $responseText['price'] = $newData[0]['price'];

                    echo json_encode($responseText);

                }

            }else{

                echo "Error! The colour or product id are empty.";

            }

            break;

            case 'size-swatch':
                $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
                $colour = filter_input(INPUT_POST, 'colour', FILTER_SANITIZE_STRING);
                $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);

                //echo $productId . $colour . $size ; 

    
                if(!empty($productId) || !empty($colour) || !empty($size)){
    
                    $newData = getSizeSwatchedShopProduct($productId, $colour, $size);
                    
                    //var_dump($colour); exit;

    
                    if(!empty($newData)){
    
                        $responseText['product_entryId'] = $newData[0]['product_entryId'];
                        $responseText['price'] = $newData[0]['price'];
    
                        echo json_encode($responseText);
    
                    }else{
                        echo '';
                    }
    
                }else{
    
                    echo "Error! The colour or product id are empty.";
    
                }
    
                break;
        
        default:

            //var_dump($products); exit;

            // BUild a products archive
            $productsDisplay = buildproductsDisplay($products);

            //var_dump($productsDisplay); exit;

            include '../view/shop.php';
    }