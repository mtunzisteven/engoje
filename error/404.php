<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }


    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }

    $pageName ="Error"; 
    $pageShortSummary = "Not Found";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
    <body>

    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header-top.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/navigation.php'; 

            echo "<img  class='col rounded mx-auto d-block' height='500' src='/images/404.svg' alt='Erro 500' />";

            require $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; ?>

        </main>
    </body>
</html>