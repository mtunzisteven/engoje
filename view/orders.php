<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
session_start();

// no session started var set yet = session just created 
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['STARTED'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_destroy();

    // set new session started var
    $_SESSION['STARTED'] = time();

}
    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }
    else if($_SESSION['loggedin'] && $_SESSION['userData']['userLevel']<2){
        header('Location: /engoje/view/account.php');
    }

    $pageName ="Orders"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Order management dashboard";

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
        <script src="/engoje/js/counts.js"></script>
        <script src="/engoje/js/sliders.js"></script>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>