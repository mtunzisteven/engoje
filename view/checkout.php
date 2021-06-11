<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Shop"; 
    $pageShortSummary = "Checkout";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
    <body>

        <main class="content" id='parentContainer'>
            <?php 

                echo "<div id='checkout-header'><img src='/zalisting/images/logo.jpg' alt='logo image'><h1 class='title'>Checkout</h1></div>";


                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                if(isset($message)){
                    echo $message;
                }

                if(isset($checkoutDisplay)){
                    echo $checkoutDisplay;
                }                
            ?>
        </main>
    </body>
    <script src="/zalisting/js/updateCart.js"></script>
</html>