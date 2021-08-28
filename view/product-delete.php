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

    $pageName ="Product-Update"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Product management dashboard";

?><!DOCTYPE html>
<html lang="en-us" class=" admin-main">
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
                    <div class="user-data-container">

                        <?php
                           
                            echo "<div class='dashboard-user-update-data'><div>";
                            echo "<p>Name: $product_entry[productName]</p>";
                            echo "<p>Price: R$product_entry[price]</p>";
                            echo "<p>Products in Stock: $product_entry[amount]</p>";
                            echo "<p>Description:$product_entry[productDescription]</p>";
                            echo "<a class='button' href='/engoje/products?action=delete-confirmed&product_entryId=$product_entryId' >Delete Product";
                            echo "</a>";
                            echo "</div></div'>";


                            ?>
                            <div class='dashboard-form-details'>
                                
                                <?php
                                    if(isset($product_entry['imagePath'])){
                                        echo "<h3>Primary Image</h3>";
                                        echo "<img class='product-image' src='$product_entry[imagePath]' alt='Product Image'/>";
                                    }


                                    if(isset($message)){
                                        echo $message;
                                    }
                                ?>

                            

                            </div>
                        </div>
                    </div>
                </section>
            </section>         
        </main>
        <script src="/engoje/js/sliders.js"></script>
    </body>
</html>
