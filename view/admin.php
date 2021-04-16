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

    //echo $_SESSION['clientData']['clientId']; exit;

    $pageName ="Admin"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Website management dashboard";

?><!DOCTYPE html>
<html lang="en-us">
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
                </section>
            </section>            
        </main>
        <script src="/zalisting/js/sliders.js"></script>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>