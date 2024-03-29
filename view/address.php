<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }

    if(!$_SESSION['loggedin']){
        header('Location: /');
    }
    else if($_SESSION['loggedin'] && $_SESSION['userData']['userLevel']<2){
        header('Location: /view/account.php');
    }

    $pageName ="Address"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "User management dashboard";

?><!DOCTYPE html>
<html lang="en-us" class=" admin-main">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/snippets/navigation.php'; 
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
        <script src="/js/sliders.js"></script>
    </body>
</html>
