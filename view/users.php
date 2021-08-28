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

    $pageName ="Users"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "User management dashboard";

?><!DOCTYPE html>
<html lang="en-us">
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
                    <?php
                        echo "<h1 class='h2'>View Users</h1>";
                        echo "<p> This is where all user management operations are handled</p>";
                        echo "<div class='table-holder'>";
                        if(isset($userRows)){

                            echo "<table id='users-display'><tr id='user-display-header'> <th>Action</th> <th>Name </th> <th>Email</th> <th>Phone</th> </tr>";

                            foreach($userRows as $row){

                                echo $row;

                            }

                            echo  "</table>";
                            ;
                        }
                        echo "</div>";

                    ?>
                </section>
            </section>         
        </main>
        <script src="/engoje/js/sliders.js"></script>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>