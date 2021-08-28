<?php 
    if(!isset($products)){
        header('Location: /engoje/shop');
    }

    $pageName ="New"; 
    $pageShortSummary = "ZA Listing";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header-top.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/shop-hero.php';
        ?>
        <div class="shop">
            <div class="side-bar">
                <h2>Side Bar</h2>
            </div>

            
            <div class='shop-products'>
                <?php 

                    // Display the shop products
                    if(isset($productsDisplay)){
                    
                        echo $productsDisplay;

                    }
                ?>
            </div>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
    </main>
 </body>
</html>