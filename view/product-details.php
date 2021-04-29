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
        <div class="shop">
            <div class="single-product">
                <img src='../images/<?php if(isset($productData['imagePath'])){echo $productData['imagePath'];}else{echo "no-image.png";} ?>'>
            </div>

            
            <div class='single-product-details'>
                <?php 

                    // Display the shop products
                    if(isset($productData)){
                    
                        echo "<h1>$productData[productName]</h1>";
                        echo "<p  class='productShortDescr'>$productData[productShortDescr]</p>";
                        echo "<p  class='productCategory'>$productData[categoryName]</p>";
                        echo "<h4 class='productPrice' >R$productData[productPrice]</h4>";

                    }
                ?>
                <form class="form-add-to-cart" action="" >
                    <input id="add-to-cart-qty" type="number" name="qty" value="0" />
                    <input type="hidden" name="productId" value="$productData[productId]" />
                    <input id="add-to-cart-button" class="button" type="button" value="Add to Cart" />
                </form>
            </div>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
    </main>
 </body>
</html>