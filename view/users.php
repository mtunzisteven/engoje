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

    $pageName ="Users"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "User management dashboard";

?><!DOCTYPE html>
<html lang="en-us">
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
                    <?php
                        echo "<h1 class='h2'>View Users</h1>";
                        echo "<p> This is where all user management operations are handled</p>";
                        echo "<div class='table-holder'>";
                        if(isset($userRows)){

                            echo "<table id='users-display' class='table table-striped table-hover'><tr id='user-display-header'> <th>Action</th> <th>Name </th> <th>Email</th> <th>Phone</th> </tr>";

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
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <script src="/js/counts.js"></script>
        <script src="/js/sliders.js"></script>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>