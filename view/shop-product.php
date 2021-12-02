<?php 
    if(!isset($_SESSION['productData'])){
        header('Location: /engoje/shop');
    }

    $pageName ="Shop"; 
    $pageShortSummary = $_SESSION['productData'][0]['productName'];
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
        ?>
        <div class="all-product-info">
            <div class="shop single-product-shop">
                <div class="single-product">

                    <?php

                    $index = 0;
                    $count = 0;

                    if(isset($_SESSION['productData'])){

                        foreach($_SESSION['productData'] as $product){

                            if($product['product_entryId'] == $_SESSION['product_entryId']){

                                $index = $count; 

                                break; 

                            }

                            $count += 1;
                            
                        }

                    $salePrimaryImage = '';

                    // when the sale display is not hidden, give primary image class name holder a value
                    if(empty($_SESSION['hidden'])){

                        $salePrimaryImage = 'sale-primary-image';

                    }

                    // The sale icon will only appear when the product is found in the sale table.
                    // sale-circle and sale-price classed elements remain hidden unless the requirement above is met.
                                                                                                    // div.sale-circle below
                    echo "<div class='sale-img-container'><div id='$product[product_entryId]' class='$_SESSION[hidden] sale-circle'>sale</div><img id='single-product' class='$salePrimaryImage product-primary-image' src='/engoje/images/placeholder.png' data-src='".$_SESSION['productData'][$index]['imagePath']."' alt='".$_SESSION['productData'][$index]['productName']."' loading='lazy' /></div>";

                    echo "<div class='single-product-gallery'>";

                    foreach($_SESSION['productData'] as $productrow){
                        if($productrow['product_entryId'] == $_SESSION['productData'][$index]['product_entryId']){

                            echo "<img class='product-gallery-image' id='$productrow[imagePath]' src='/engoje/images/placeholder.png' data-src='".$productrow['imagePath_tn']."' alt='Gallery Image' loading='lazy' />";
                        }
                    }

                    echo "</div>";

                    ?>

                </div>
                <form class="form-add-to-cart" action="" >

                    <?php 

                            $salePrice = ''; // When there is no sale price

                            if(isset($_SESSION['salePrice'])){ $salePrice = "R".$_SESSION['salePrice']; } //When there is a sale price
                        
                            echo "<h1 id='product-title'>".$_SESSION['productData'][0]['productName']."</h1>";
                                                                                                                            // div.sale-circle below
                            echo "<div class='sale-prices-container'><p class='productPrice $_SESSION[strikeThrough]' id='productPrice' >R".$_SESSION['productData'][0]['price']."</p><p class='$_SESSION[hidden] productPrice sale-price' >".$salePrice."</p></div>";
                            echo "<p  class='productShort-descr'>".$_SESSION['productData'][0]['productShortDescr']."</p>";
                            echo "<input type='hidden' id='product_entryId' name='product_entryId' value='".$_SESSION['productData'][0]['product_entryId']."' />";
                            echo "<input type='hidden' id='productId' name='productId' value='".$_SESSION['productData'][0]['productId']."' />";
                            echo "<input type='hidden' id='colourChoice' name='".$_SESSION['colourChoice']."' value='".$_SESSION['colourChoice']."' />";

                            echo $_SESSION['colours'];                            

                            echo $_SESSION['sizes'];

                        }

                        if(isset($_SESSION['userData'])){ // do not show the add to cart button if user not signed in 
                    ?>
                    <div id='add-to-cart-stock'></div>
                    <div class="add-to-cart-container">
                        <input id="add-to-cart-qty" class='validity' type="number" name="qty" value="0" min=1 />
                        <input id="add-to-cart-button" class="button" type="button" value="Add to Cart" />
                    </div>

                    <?php }else{ ?>

                        <div class="add-to-cart-container">
                            <a href="/engoje/accounts/index.php?action=login">Sign in &NonBreakingSpace;</a><span> to place an order.</span>
                        </div>

                    <?php } ?>

                    <div class="add-to-cart-container">
                        <input id="add-to-wishlist-button" class="button" type="button" value="Add to Wishlist" />
                    </div>
                    <div id='add-to-cart-response'></div>
                </form>
            </div>

            <div class='container description-container bg-white pt-2 px-0 pb-3 mt-2'>
                <h1 id='product-title' class='description-title ps-3 ms-1'>Description</h1>
                <div class="shop full-shop description mb-1 pb-1">
                    <?php
                        if(isset($_SESSION['productData'])){ // do not show the add to cart button if user not signed in 

                            echo $_SESSION['productData'][0]['productDescription'];

                        }
                    ?>
                </div>
            <div class="row">

            </div>
        </div>

        </div>
        <div class='container related-products bg-white pt-2 px-0 pb-3 mt-2'>
            <h1 id='product-title' class='related-title ps-3 ms-1'>Related Products</h1>
            <div class="shop full-shop related-products mb-1 pb-1">
                <div class='shop-products-archive'>
                    <?php
                        if(isset($_SESSION['relatedProducts'])){ // do not show the add to cart button if user not signed in 

                            echo $_SESSION['relatedProducts'];

                        }
                    ?>
                </div>
            </div>
            <h1 id='product-title' class='related-title ps-3 ms-1'>Reviews</h1>
            <div class="row">

            </div>
        </div>
        <script src='/engoje/js/swatches.js'></script>
        <script type='module' src='/engoje/js/singleproduct.js'></script>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
    </main>
 </body>
</html>