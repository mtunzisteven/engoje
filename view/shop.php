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
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/shop-hero.php';
        ?>
        <div class="shop">
            <div class="side-bar">
                <h2>Side Bar</h2>
            </div>

            
            <div class='shop-products products'>
                <?php 

                    // Display the shop products
                    if(isset($productsDisplay)){
                    
                        echo $productsDisplay;

                    }
                ?>
            </div>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
    </main>
 </body>
</html>