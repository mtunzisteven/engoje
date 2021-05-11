<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if(!$_SESSION['loggedin']){
        header('Location: /zalisting/');
    }
    else if($_SESSION['loggedin'] && $_SESSION['userData']['userLevel']<2){
        header('Location: /zalisting/view/account.php');
    }

    $pageName ="Add Image"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Product management dashboard";

?><!DOCTYPE html>
<html lang="en-us" class=" admin-main">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 
            ?>

            <section class="dashboard admin-dashboard">

                <?php

                    if(isset($adminSideNav)){
                        echo $adminSideNav;
                    }

                ?>

                <section class="dashboard-content user-data-container">
                    <div class='uploads-container'>
                        <h1 id=title>Image Management</h1>    

                        <h2 class="notice">Add New Vehicle Image</h2>
                        <?php
                            if (isset($message)) {
                                echo $message;
                            } 

                            echo "<div class='upload-forms-container'>";

                            if (isset($uploadForm)) {
                                echo $uploadForm;
                            } 

                            echo "</div>";

                        ?>



                        <hr/>

                        <h2 class="notice">Existing Images</h2>
                        <p>These are product images. If one is deleted, the product will no longer appear in the store.</p>
                        <div class="media-display">
                            <?php
                                if (isset($imageDisplay)) {
                                    echo $imageDisplay;
                                } 
                            ?>
                        </div> 
                    </div>
                </section>
            </section>         
        </main>
        <script src="../js/sliders.js"></script>
        <script src="../js/functions.js"></script>
    </body>
</html>
