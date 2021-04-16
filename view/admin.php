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
                <ul class="dashboard-side-nav">
                    <li class="dashboard-side-nav-items"><a href="/zalisting/view/admin.php" class="dashboard-side-nav-links dashboard-main-link">DASHBOARD</a></li>
                    <li class="dashboard-side-nav-items"><a href="/zalisting/accounts/?action=account" class="dashboard-side-nav-links">My Account</a></li>
                    <li class="dashboard-side-nav-items"><a href="/index.php" class="dashboard-side-nav-links">Products</a></li>
                    <li class="dashboard-side-nav-items"><a href="/zalisting/accounts/?action=users" class="dashboard-side-nav-links">Accounts</a></li>
                    <li class="dashboard-side-nav-items"><a class="dashboard-side-nav-links">Orders</a></li>
                    <li class="dashboard-side-nav-items"><a class="dashboard-side-nav-links">Reviews</a></li>
                    <li class="dashboard-side-nav-items"><a class="dashboard-side-nav-links">Sales</a></li>
                    <li class="dashboard-side-nav-items"><a class="dashboard-side-nav-links">Reports</a></li>
                    <li class="dashboard-side-nav-items"><a class="dashboard-side-nav-links">Logs</a></li>
                    <li class="dashboard-side-nav-items"><a class='dashboard-side-nav-links' href='/zalisting/accounts/index.php?action=logout'>Logout</a></li>
                </ul>

                

                <section class="dashboard-content">
                    <?php
                        echo "<h1 class='h2'>Welcome to Your Dashboard</h1>";
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
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>