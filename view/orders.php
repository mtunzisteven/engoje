<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

    }

    if(!$_SESSION['loggedin']){
        header('Location: /');
    }

    $pageName ="Orders"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Order management dashboard";

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
                    <h1 class='h2'>View Orders</h1>
                    <p> Here you can view, create, delete, or update orders</p>
                    <?php 
                        if(isset($message)){ 
                            echo $message;
                        }

                        if(isset($_SESSION['message'])){
                            echo $_SESSION['message'];
                        }


                        echo "<div class='table-holder'>";

                        if(!empty($ordersAdminTable) ){

                            echo "<table id='users-display' class='table table-striped table-hover'><tr id='user-display-header'><th>#</th> <th>Action</th> <th>Order Id </th> <th>Customer</th> <th>Order Total</th> <th>Order Date</th> <th>Items </th> <th>Status</th> <th> Ship Method</th> <th>Tracking #</th> </tr>";

                            foreach($ordersAdminTable as $row){

                                echo $row;

                            }

                            echo  "</table>";
                            
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