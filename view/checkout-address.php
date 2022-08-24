<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }

    if(!$_SESSION['loggedin']){
        header('Location: /');
    }


    $pageName ="Checkout"; 
    $pageShortSummary = "Shipping Information";
    $pageDescription = "Add billing & shipping address";



    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
    <body>

        <main class="content" id='parentContainer'>
            <?php 

                echo "<div id='checkout-header'><img src='/images/logo.svg' alt='logo image'><h1 class='title'>Address</h1></div>";


                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                if(isset($message)){
                    echo $message;
                }

                if(isset($_SESSION['checkoutAddressDisplay'])){
                    echo $_SESSION['checkoutAddressDisplay'];
                }    

            ?>
        </main>
    </body>
    <script src="/js/checkout.js"></script>
</html>