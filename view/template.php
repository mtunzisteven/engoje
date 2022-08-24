<?php 
    $pageName ="Template"; 
    $pageShortSummary = "";
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
            require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header-bottom.php';
        ?>
        
        
        <?php require $_SERVER['DOCUMENT_ROOT'].'/snippets/footer.php'; ?>
    </main>
 </body>
</html>