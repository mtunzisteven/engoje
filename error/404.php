<?php

    if(!isset($_SESSION)){
        session_start();
    }


    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Error"; 
    $pageShortSummary = "Not Found";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body>

    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 

            echo "<img  class='col rounded mx-auto d-block' height='500' src='/engoje/images/404.svg' alt='Erro 500' />";

            require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>

        </main>
    </body>
</html>