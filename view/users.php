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

    $pageName ="Users"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "User management dashboard";

?><!DOCTYPE html>
<html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 
            ?>

            <section class="dashboard  desktop-nav">
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
                        echo "<h1 class='h2'>View Users</h1>";
                        echo "<p> This is where all the website management operations will be handled</p>";
                        if(isset($userRows)){

                            echo "<table id='users-display'><tr id='user-display-header'> <th>Action</th> <th>Name </th> <th>Email</th> <th>Phone</th> </tr>";

                            foreach($userRows as $row){

                                echo $row;

                            }

                            echo  "</table>";
                            ;
                        }
                    ?>
                </section>
            </section>         
        </main>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>