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

    $pageName ="Products"; 
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

            <section class="dashboard admin-dashboard">
                
                <?php

                    if(isset($adminSideNav)){
                        echo $adminSideNav;
                    }

                ?>

                <section class="dashboard-content">
                    <h1 class='h2'>View Products</h1>
                    <p> This page allows you to view, create, delete, or update products</p>
                    <?php 
                        if(isset($message)){
                            echo $message;
                        }


                    echo '<a href="/zalisting/products/?action=create" class="button add-new" >Add New</a>';

                        echo "<div class='table-holder'>";

                        if(isset($productAdminTable)){

                            echo "<table id='users-display'><tr id='user-display-header'> <th>Action</th> <th>Image </th> <th>Name</th> <th>Price</th> <th>Qty</th> <th>Size</th> <th>Colour</th> <th>SKU</th> </tr>";

                            foreach($productAdminTable as $row){

                                echo $row;

                            }

                            echo  "</table>";
                            
                        }
                        
                        echo "</div>";
                    ?>
                </section>
            </section>         
        </main>
        <script src="/zalisting/js/sliders.js"></script>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>