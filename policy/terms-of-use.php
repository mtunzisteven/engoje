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

    $pageName ="Terms of Use"; 
    $pageShortSummary = "Policies";
    $pageDescription = "Store Returns Policy";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            ?>
                <section class="policy-doc">
                    <h1 class="text-center my-5">Terms of Use Policy</h1>
                    <article class="bg-white rounded m-2 p-5">
                        text goes here...
                    </article>
                </section>
            </section>           
        </main>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/footer.php'; ?>

        <script src="/engoje/js/counts.js"></script>
    </body>
</html>
