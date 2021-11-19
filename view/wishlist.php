<?php

    if(!isset($_SESSION)){
        session_start();
    }


    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Wishlist"; 
    $pageShortSummary = "Shopping wishlist";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body>

        <main class="content short-content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 

                echo "<h1 class='title'>Wish List</h1>";


                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                }
                if(isset($message)){
                    echo $message;
                }

                if(isset($_SESSION['wishlistDisplay'])){
                    echo $_SESSION['wishlistDisplay'];
                }

                require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; 
                
            ?>
        </main>
    </body>
</html>