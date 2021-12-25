<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 

    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }
    else if($_SESSION['loggedin'] && $_SESSION['userData']['userLevel']<2){
        header('Location: /engoje/view/account.php');
    }

    $pageName ="Add Product"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Product management dashboard";

?><!DOCTYPE html>
<html lang="en-us" class=" admin-main">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            ?>

            <section class="dashboard admin-dashboard">

                <?php

                    if(isset($adminSideNav)){
                        echo $adminSideNav;
                    }

                ?>

                <section class="dashboard-content">
                    <h1 class='h2'>Product Information</h1>
                    <p> Enter all the core product information that will be shared by all colour and size swatches with the same product id.</p>
                    <div class="user-data-container">

                        <?php
                           
                            if(isset($userUpdateNav)){

                                echo $userUpdateNav;
                            }

                            echo "<div class='dashboard-user-update-data'>";

                                    if(isset($createProductForm)){

                                        echo $createProductForm;
                                    }

                                    
                                    if(isset($message)){

                                        echo $message;
                                    }
                                ?>

                            </div>
                    </div>
                </section>
            </section>         
        </main>
        <script src="/engoje/js/sliders.js"></script>
    </body>
</html>
