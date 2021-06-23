<?php 
    if(!isset($products)){
        header('Location: /zalisting/shop');
    }

    $pageName ="Shop"; 
    $pageShortSummary = "ZA Listing";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header-top.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/shop-hero.php';
        ?>
        <div class="shop">
            <div class="side-bar">
                <h2>Side Bar</h2>
            </div>

            
            <div class='shop-products-archive'>
                <?php 

                    // Display the shop products
                    if(isset($productsDisplay)){
                    
                        echo $productsDisplay;

                    }

                    echo "</div>";

                    if(isset($_SESSION['userData'])){
                        echo "<div class='feedback'><a class='feedback-link' href='/zalisting/?action=fb'>Feedback</a></div>";
                    }
                ?>
             

            

        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
    </main>
 </body>
</html>