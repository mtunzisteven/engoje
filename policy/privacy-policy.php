<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Privacy Policy"; 
    $pageShortSummary = "Policies";
    $pageDescription = "Website Privacy Policy";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            ?>
                <section class="dashboard-content Account-content">
                    <?php
                        echo "<h1 class='h2'>Welcome to Your Account Dashboard</h1>";
                        if(isset($_SESSION['message'])){
                            echo $_SESSION['message'];
                        }
                    ?>
                    <p> This is where all your order operations will be handled</p>
                </section>
            </section>           
        </main>
        <script src="/engoje/js/counts.js"></script>
        <script src="/engoje/js/sliders.js"></script>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>