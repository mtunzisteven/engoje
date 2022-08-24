<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }


    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }

    $pageName ="Search"; 
    $pageShortSummary = "Results";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
    <body>

    <main class="content p-bottom-0">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/navigation.php'; 

        ?>
        <img  class='col rounded mx-auto d-block' height='300' src='/images/search.svg' alt='Erro 500' />
        <h1 class='title'>Search Results</h1>

        <div class='bg-white py-5 m-bottom-0'>
            <?php

                echo $searchDisplay;
            ?>

        </div>

        <?php
            require $_SERVER['DOCUMENT_ROOT'].'/snippets/footer2.php'; 

        ?>

        </main>
    </body>
</html>