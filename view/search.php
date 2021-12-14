<?php

    if(!isset($_SESSION)){
    
// no session started var set yet = no session created yet 
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['started'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_regenerate_id(true);

    // set new session started var
    $_SESSION['STARTED'] = time();

}

// start session with same id in this file
session_start();
    }


    if(!isset($_SESSION)){
    
// no session started var set yet = no session created yet 
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['started'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_regenerate_id(true);

    // set new session started var
    $_SESSION['STARTED'] = time();

}

// start session with same id in this file
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