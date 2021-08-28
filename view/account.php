<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }

    //echo $_SESSION['clientData']['clientId']; exit;

    $pageName ="Account"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "User Account dashboard";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 
            ?>

            <section class="dashboard account-dasshboard">
                <ul class="dashboard-side-nav account-side-nav">
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a href="/engoje/view/account.php" class="dashboard-side-nav-links account-dashboard-main-link">DASHBOARD</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class="dashboard-side-nav-links account-dasshboard-links">Orders</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class="dashboard-side-nav-links account-dasshboard-links">Reviews</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class="dashboard-side-nav-links account-dasshboard-links">Returns</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class="dashboard-side-nav-links account-dasshboard-links">Addresses</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class="dashboard-side-nav-links account-dasshboard-links">Contact Details</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class="dashboard-side-nav-links account-dasshboard-links">Security</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class="dashboard-side-nav-links account-dasshboard-links">Talk to us</a></li>
                    <li class="dashboard-side-nav-items account-dashboard-side-nav-items"><a class='dashboard-side-nav-links account-dasshboard-links' href='/engoje/accounts/index.php?action=logout'>Logout</a></li>
                </ul>

                

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