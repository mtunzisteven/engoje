<?php 
    if(!isset($products)){
        header('Location: /zalisting/shop');
    }

    $pageName ="Shop"; 
    $pageShortSummary = "";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header-top.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 
        ?>
        <div class="shop single-product-shop">
            <div class="single-product">
                <?php

                if(isset($productData)){

                echo "<img src='../images/".$productData[0]['imagePath']."' alt='".$productData[0]['productName']."'>";

                ?>
            </div>

            
            <div class='single-product-details'>
                <form class="form-add-to-cart" action="" >

                    <?php 

                            //var_dump($productData); exit;
                        
                            echo "<h1 id='product-title'>".$productData[0]['productName']."</h1>";
                            echo "<p class='productPrice' >R".$productData[0]['price']."</p>";
                            echo "<p  class='productShort-descr'>".$productData[0]['productShortDescr']."</p>";

                            echo $sizes;

                            echo $colours;                            

                        }
                    ?>
                    <div id="add-to-cart-container">
                        <input id="add-to-cart-qty" type="number" name="qty" value="0" />
                        <input id="add-to-cart-button" class="button" type="button" value="Add to Cart" />
                    </div>

                    <input type="hidden" name="product_entryId" value="$productData[product_entryId]" />

                </form>
            </div>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
    </main>
 </body>
</html>