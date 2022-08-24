<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }


    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }

    $pageName ="Cart"; 
    $pageShortSummary = "Shopping cart";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
    <body>

        <main class="content short-content" id='parentContainer'>
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/snippets/navigation.php'; 

                echo "<h1 class='title'>Cart</h1>";

                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }

                if(isset($_SESSION['cartDisplay'])){
                    echo $_SESSION['cartDisplay'];
                }

                require $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; 
                
            ?>
                <script src="/js/updateCart.js"></script>
                
        </main>
    </body>
</html>