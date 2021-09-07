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

    $pageName ="Products"; 
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
                    <h1 class='h2'>View Products</h1>
                    <p> Here you can view, create, delete, or update products</p>
                    <?php 
                        if(isset($message)){ 
                            echo $message;
                        }

                        if(isset($_SESSION['message'])){
                            echo $_SESSION['message'];
                        }


                    echo '<a href="/engoje/products/?action=create" class="button add-new line-height-button" >add new</a>';

                        echo "<div class='table-holder'>";

                        if(isset($productAdminTable)){

                            echo "<table id='users-display' class='table table-striped table-hover'><tr id='user-display-header'><th>#</th> <th>Action</th> <th>Image </th> <th>Name</th> <th>Price</th> <th>Qty</th> <th>Size</th> <th>Colour</th> <th>SKU</th> </tr>";

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
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <script src="/engoje/js/counts.js"></script>
        <script src="/engoje/js/sliders.js"></script>
    </body>
</html>
<?php 
    unset($_SESSION['message']);
?>