<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Shop"; 
    $pageShortSummary = "Checkout";
    $pageDescription = "";

    $token = '';
    $orderId = '';
    $status = '';
    $infoUrl = NULL;
    $refundUrl = NULL;
    $approveUrl = NULL;



    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body>

        <main class="content" id='parentContainer'>
            <?php 

                echo "<div id='checkout-header'><img src='/engoje/images/logodark.svg' alt='logo image'><h1 class='title'>Checkout</h1></div>";

                if(isset($_SESSION['checkoutDisplay'])){
                    echo $_SESSION['checkoutDisplay'];
                }    

            ?>
        </main>
    </body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/footerspacer.php'; ?>
    <script src="/engoje/js/checkout.js"></script>
</html>