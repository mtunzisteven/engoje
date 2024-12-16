<?php 

    $pageName="Template";
    $pageDescription="This page is just a template. It is used to create the rest of the views";
    $pageShortSummary="This page is just a template";
    $heading="This is a template"

?><!DOCTYPE html>
<html lang="en-us">

    <?php require $_SERVER['DOCUMENT_ROOT'].'/nosiheco/snippets/head.php'; ?>

    <body>
        <main class="content">            

            <?php require $_SERVER['DOCUMENT_ROOT'] . '/nosiheco/snippets/navigation.php'; ?>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/nosiheco/snippets/hero.php'; ?>

            <h2 id=title>Content Title Here</h2>    



            <?php require $_SERVER['DOCUMENT_ROOT'].'/nosiheco/snippets/footer.php'; ?>
        </main>
    </body>
</html>