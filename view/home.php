<?php 
    $pageName ="Home"; 
    $pageShortSummary = "ZA Listing";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header-bottom.php';
        ?>
        
        <div class="categories">
            <a href="/" class="left-category category">
               <p>Left</p>
            </a>
            <a href="/" class="right-category category">
                <p>Right</p>
            </a>
        </div>
        <div class="products">

            <a href="/" class="product-one product">
                <img src="/zalisting/images/no-image-tn.png" />
               <p>One</p>
            </a>
            <a href="/" class="product-two product">
                <img src="/zalisting/images/no-image-tn.png" />
                <p>Two</p>
            </a>
            <a href="/" class="product-three product">
                <img src="/zalisting/images/no-image-tn.png" />
               <p>Three</p>
            </a>
            <a href="/" class="product-four product">
                <img src="/zalisting/images/no-image-tn.png" />
                <p>Four</p>
            </a>
        </div>
                    
        <?php
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/shop-hero.php';
        ?>

        <?php require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
    </main>
 </body>
</html>