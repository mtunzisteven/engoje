<?php 
    $pageName ="Home"; 
    $pageShortSummary = "engoje";
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
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/home-hero.php';
        ?>
        
        <div class="categories">
            <a class="category-anchor" href="/new" class="left-category category">
                <img class="category-image" src="/images/WindowShopping.png" alt="window shopping dresses" />
                <h2 class="category-h2">New</h2>
            </a>
            <a class="category-anchor" href="/sale" class="right-category category">
                <img class="category-image" src="/images/accessoriesWindow.png" alt="window shopping accessories" />
                <h2 class="category-h2">Sale</h2>
            </a>
        </div>
                    
        <?php

            require $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; 
            
        ?>

    </main>
 </body>
</html>