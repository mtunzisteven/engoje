<?php 
    if(!isset($products)){
        header('Location: /shop');
    }

    $pageName ="New"; 
    $pageShortSummary = "Engoje";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header-top.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/navigation.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/shop-hero.php';
        ?>
        <div class="shop">
        
            <div class="side-bar">

                <?php

                    // Display the new items shop ads sidebar
                    require $_SERVER['DOCUMENT_ROOT'] . '/snippets/new-sidebar.php';

                ?>

            </div>

            <div class='shop-products-archive'> 
                <?php 

                    // Display the shop products
                    if(isset($productsDisplay)){
                    
                        echo $productsDisplay;

                    }

                    echo "</div>";

                    if(isset($_SESSION['userData'])){
                        echo "<div class='feedback'><a class='feedback-link' href='/?action=fb'>Feedback</a></div>";
                    }
                ?>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; ?>
    </main>
 </body>
 <script src="/js/shopswatch.js"></script>
</html>