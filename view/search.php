<?php

    if(!isset($_SESSION)){
        session_start();
    }


    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Search"; 
    $pageShortSummary = "Results";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body>

    <main class="content p-bottom-0">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 

        ?>
        <img  class='col rounded mx-auto d-block' height='300' src='/engoje/images/search.svg' alt='Erro 500' />
        <h1 class='title'>Search Results</h1>

        <div class='bg-white py-5 m-bottom-0'>
            <?php

                echo $searchDisplay;
            ?>

        </div>

        <?php
            require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer2.php'; 

        ?>

        </main>
    </body>
</html>