<?php

// Get the database connection file
require_once '../library/connections.php';
// Get the cleaner script 
require_once '../library/dbCleaner.php';
// Get the search model for use as needed
require_once '../model/search-model.php';


$searchTerm = filter_input(INPUT_POST, 'search',FILTER_SANITIZE_STRING);
if ($searchTerm == NULL){
    $searchTerm = filter_input(INPUT_GET, 'search',FILTER_SANITIZE_STRING);
}

$products = getSearchItems($searchTerm);

$searchDisplay ="";

if(!empty($products)){
        
    foreach($products as $product){

        $searchDisplay .= "<a href='/engoje/shop?action=product&productId=$product[productId]&product_entryId=$product[product_entryId]&colour=$product[colour]' class='productName-link text-decoration-none mx-5'>
        <div class='container mx-auto py-3 border-top m-0 search-results'>
            <div class='row align-items-start px-0 mx-0'>

                <img class='col-sm-1 img-thumbnail ' width='150' src='$product[imagePath_tn]' alt='...'>


                <div class='col-sm'>
                    <h3 class='productName color-dark'>$product[productName]</h3>
                    <h5 class='price color-dark'>R$product[price]</h5>
                </div>



                <div class='col-sm-4 border-radius-3 box-shadow-large'>
                    <p class='colour color-dark'><strong>Colour: </strong>$product[colour] | <strong>Size: </strong>$product[sizeValue]</p>
                    <p class='descr p-top-3 color-dark'>$product[productShortDescr]</p>
                </div>



                <div class='col-sm-4 border-radius-3 box-shadow-large'>
                    <p class='size p-top-3 color-dark'>$product[productDescription]</p>
                </div>
            </div>
        </div></a>";

    }


    include "../view/search.php";
}else{

    $searchDisplay .= '<p class="notice border-top py-5 mx-5">No items found...</p>';

    include "../view/search.php";

}


