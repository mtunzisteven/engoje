<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }
    else if($_SESSION['loggedin'] && $_SESSION['userData']['userLevel']<2){
        header('Location: /engoje/view/account.php');
    }

    $pageName ="Print Order"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Order management dashboard";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body class=" admin-main">

        <?php
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/printorder-header.php'; 
        ?>

            <div class="dashboard admin-dashboard">

                <div class="dashboard-content">
                    <?php
                        echo "<h1 class='h2'>Website Admin Dashboard</h1>";
                        if(isset($_SESSION['message'])){
                            echo $_SESSION['message'];
                        }

                        if(isset($message)){
                            echo $message;
                        }
                    ?>
                    <p> This is where all the website management operations will be handled</p>
                    </div>
                </div>            
        </main>
    </body>
    <script>

        window.print();

    </script>
</html>
