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

    $pageName ="Address-Update"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "User management dashboard";

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

                <section class="dashboard-content">
                    <div class="user-data-container">

                        <?php
                           
                            if(isset($userUpdateNav)){

                                echo $userUpdateNav;
                            }

                            echo "<div class='dashboard-user-update-data'>";

                                if(isset($addressForm)){

                                    echo $addressForm;
                                }

                            ?>
                            <div class='dashboard-form-details'>
                                <h3>Addresses</h3>
                                <?php
                                    if(isset($addressSideDisplay)){
                                        echo $addressSideDisplay;
                                    }


                                    if(isset($message)){
                                        echo $message;
                                    }
                                ?>

                            

                            </div>
                        </div>
                    </div>
                </section>
            </section>         
        </main>
        <script src="/zalisting/js/sliders.js"></script>
    </body>
</html>
