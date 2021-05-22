<?php

    if(!isset($_SESSION)){
        session_start();
    }


    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Shop"; 
    $pageShortSummary = "Cart";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
    <body>

        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 

                echo "<h1 class='title'>Cart</h1>";


                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                if(isset($message)){
                    echo $message;
                }

                if(isset($cartDisplay)){
                    echo $cartDisplay;
                }

                require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; 
                
            ?>
        </main>
    </body>
    <script src='/zalisting/js/deletecartitem.js'></script>
</html>