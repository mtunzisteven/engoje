<?php 
    if(!isset($_SESSION['productData'])){
        header('Location: /zalisting/shop');
    }

    $pageName ="Shop"; 
    $pageShortSummary = $_SESSION['productData'][0]['productName'];
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 
        ?>
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
                echo "<div class='sale-img-container'><div id='$product[product_entryId]' class='$_SESSION[hidden] sale-circle'>sale</div><img id='single-product' class='$salePrimaryImage product-primary-image' src='".$_SESSION['productData'][$index]['imagePath']."' alt='".$_SESSION['productData'][$index]['productName']."'></div>";

                echo "<div class='single-product-gallery'>";

                foreach($_SESSION['productData'] as $productrow){
                    if($productrow['product_entryId'] == $_SESSION['productData'][$index]['product_entryId']){

                        echo "<img class='product-gallery-image' id='$productrow[imagePath]' src='".$productrow['imagePath_tn']."' alt='Gallery Image'>";

                    }
                }

                echo "</div>";

                ?>



            </div>
            <form class="form-add-to-cart" action="" >

                <?php 

                        //var_dump($_SESSION['productData']); exit;
                    
                        echo "<h1 id='product-title'>".$_SESSION['productData'][0]['productName']."</h1>";
                                                                                                                        // div.sale-circle below
                        echo "<div class='sale-prices-container'><p class='productPrice $_SESSION[strikeThrough]' id='productPrice' >R".$_SESSION['productData'][0]['price']."</p><p class='$_SESSION[hidden] productPrice sale-price' >R".$_SESSION['salePrice']."</p></div>";
                        echo "<p  class='productShort-descr'>".$_SESSION['productData'][0]['productShortDescr']."</p>";
                        echo "<input type='hidden' id='product_entryId' name='product_entryId' value='".$_SESSION['productData'][0]['product_entryId']."' />";
                        echo "<input type='hidden' id='productId' name='productId' value='".$_SESSION['productData'][0]['productId']."' />";
                        echo "<input type='hidden' id='colourChoice' name='".$_SESSION['colourChoice']."' value='".$_SESSION['colourChoice']."' />";

                        echo $_SESSION['colours'];                            

                        echo $_SESSION['sizes'];

                    }
                ?>
                <div id='add-to-cart-stock'></div>
                <div class="add-to-cart-container">
                    <input id="add-to-cart-qty" class='validity' type="number" name="qty" value="0" min=1 />
                    <input id="add-to-cart-button" class="button" type="button" value="Add to Cart" />
                </div>
                <div class="add-to-cart-container">
                    <input id="add-to-wishlist-button" class="button" type="button" value="Add to Wishlist" />
                </div>
                <div id='add-to-cart-response'></div>
            </form>
        </div>
        <script src='/zalisting/js/swatches.js'></script>
        <script type='module' src='/zalisting/js/singleproduct.js'></script>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
    </main>
 </body>
</html>