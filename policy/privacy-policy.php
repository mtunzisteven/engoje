<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }

    $pageName ="Privacy Policy"; 
    $pageShortSummary = "Policies";
    $pageDescription = "Website Privacy Policy";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/snippets/navigation.php'; 
            ?>
                <section class="policy-doc">
                    <h1 class="text-center my-5">Privacy Policy</h1>
                    <article class="bg-white rounded m-2 p-5">
                        text goes here...
                    </article>
                </section>
            </section>           
        </main>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/footer.php'; ?>

        <script src="/js/counts.js"></script>
    </body>
</html>
