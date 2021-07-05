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

                    //var_dump($_SESSION['productData'][$index]) echo $index; exit;

                echo "<img id='single-product' class='product-primary-image' src='".$_SESSION['productData'][$index]['imagePath']."' alt='".$_SESSION['productData'][$index]['productName']."'>";

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
                        echo "<p class='productPrice' id='productPrice' >R".$_SESSION['productData'][0]['price']."</p>";
                        echo "<p  class='productShort-descr'>".$_SESSION['productData'][0]['productShortDescr']."</p>";
                        echo "<input type='hidden' id='product_entryId' name='product_entryId' value='".$_SESSION['productData'][0]['product_entryId']."' />";
                        echo "<input type='hidden' id='productId' name='productId' value='".$_SESSION['productData'][0]['productId']."' />";
                        echo "<input type='hidden' id='colourChoice' name='".$_SESSION['colourChoice']."' value='".$_SESSION['colourChoice']."' />";

                        echo $_SESSION['colours'];                            

                        echo $_SESSION['sizes'];

                    }
                ?>
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
        <script type='module' src="/zalisting/js/addtowishlist.js"></script>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
    </main>
 </body>
</html>