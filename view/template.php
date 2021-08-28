<?php 
    $pageName ="Template"; 
    $pageShortSummary = "";
    $pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
 <body>
    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header-top.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header-bottom.php';
        ?>
        
        
        <?php require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
    </main>
 </body>
</html>