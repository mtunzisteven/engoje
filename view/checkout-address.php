<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
session_start();

// no session started var set yet = session just created 
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['STARTED'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_destroy();

    // set new session started var
    $_SESSION['STARTED'] = time();

}
    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }


    $pageName ="Checkout"; 
    $pageShortSummary = "Shipping Information";
    $pageDescription = "Add billing & shipping address";



    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body>

        <main class="content" id='parentContainer'>
            <?php 

                echo "<div id='checkout-header'><img src='/engoje/images/logo.svg' alt='logo image'><h1 class='title'>Address</h1></div>";


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
    <script src="/engoje/js/checkout.js"></script>
</html>