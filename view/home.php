<?php 
    $pageName ="Home"; 
    $pageShortSummary = "engoje";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/shop-hero.php';
        ?>
        
        <div class="categories">
            <a href="/" class="left-category category">
               <p>Left</p>
            </a>
            <a href="/" class="right-category category">
                <p>Right</p>
            </a>
        </div>

        <div class="container products px-0 my-3 ms-auto ">
            <div class="row w-100 px-0 my-0 mx-auto">
                <div class="col-5 placeholder bg-white rounded mx-2"></div>
                <div class="col-2 placeholder bg-white rounded mx-2"></div>
                <div class="col-2 placeholder bg-white rounded mx-2"></div>
                <div class="col-2 placeholder bg-white rounded mx-2"></div>
            </div>
        </div>
                    
        <?php
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header-bottom.php';
        ?>

        <?php require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
    </main>
 </body>
</html>