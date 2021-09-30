<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="FAQs"; 
    $pageShortSummary = "Communication";
    $pageDescription = "Frequently Asked Questions";

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
                    <h1 class="text-center my-5">Frequently Asked Questions</h1>
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
