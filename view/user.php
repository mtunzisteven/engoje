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

    $pageName ="User"; 
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
                    <div class="user-data-container">
                        <ul class="user-update">
                            <li class="user-update-item <?php if($pageName=='User'){echo "user-update-item-active";} ?>" ><a href="">Personal</a></li>
                            <li class="user-update-item" ><a href="">Addresses</a></li>
                            <li class="user-update-item" ><a href="">Orders</a></li>
                            <li class="user-update-item" ><a href="">Returns</a></li>
                        </ul>
                        <div class="dashboard-user-update-data">

                            <?php

                                if(isset($userDisplay)){

                                    echo $userDisplay;
                                }

                            ?>
                            <div class="dashboard-form-details">
                                <h3>Heading</h3>
                                <p>Information about the form on the left.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </section>    
            <?php 
                 unset($_SESSION['message']);
            ?>        
        </main>
    </body>
</html>
