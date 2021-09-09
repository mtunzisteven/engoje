<?php 
    if(!isset($products)){
        header('Location: /engoje/shop');
    }

    $pageName ="Sale"; 
    $pageShortSummary = "Engoje";
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
        <div class="shop sale-shop">
            
            <div class='shop-products-archive sale'>
                <?php 

                    // Display the shop products
                    if(isset($productsDisplay)){
                    
                        echo $productsDisplay;

                    }

                    echo "</div>";

                    if(isset($_SESSION['userData'])){
                        echo "<div class='feedback'><a class='feedback-link' href='/engoje/?action=fb'>Feedback</a></div>";
                    }
                ?>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
    </main>
 </body>
 <script src="/engoje/js/shopswatch.js"></script>
</html>