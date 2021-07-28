<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if(!$_SESSION['loggedin']){
        header('Location: /zalisting/');
    }


    $pageName ="Checkout"; 
    $pageShortSummary = "Shipping Information";
    $pageDescription = "Add billing & shipping address";



    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
    <body>

        <main class="content" id='parentContainer'>
            <?php 

                echo "<div id='checkout-header'><img src='/zalisting/images/logo.png' alt='logo image'><h1 class='title'>Address</h1></div>";


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
    <script src="/zalisting/js/checkout.js"></script>
</html>