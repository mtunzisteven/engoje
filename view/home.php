<?php 
    $pageName ="Home"; 
    $pageShortSummary = "engoje";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header-bottom.php';
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
                <img src="/engoje/images/no-image-tn.png" />
               <p>One</p>
            </a>
            <a href="/" class="product-two product">
                <img src="/engoje/images/no-image-tn.png" />
                <p>Two</p>
            </a>
            <a href="/" class="product-three product">
                <img src="/engoje/images/no-image-tn.png" />
               <p>Three</p>
            </a>
            <a href="/" class="product-four product">
                <img src="/engoje/images/no-image-tn.png" />
                <p>Four</p>
            </a>
        </div>
                    
        <?php
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/shop-hero.php';
        ?>

        <?php require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
    </main>
 </body>
</html>