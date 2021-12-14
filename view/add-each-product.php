<?php

    if(!isset($_SESSION)){
    
// no session started var set yet = no session created yet 
if(!isset($_SESSION['STARTED'])){

    $_SESSION['STARTED'] = time();

}else if(time()-$_SESSION['started'] > 1800){
    // session older than 30min
    // change session id if session is older than 30 min
    session_regenerate_id(true);

    // set new session started var
    $_SESSION['STARTED'] = time();

}

// start session with same id in this file
session_start();
    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }
    else if($_SESSION['loggedin'] && $_SESSION['userData']['userLevel']<2){
        header('Location: /engoje/view/account.php');
    }

    $pageName ="Add Product"; 
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
                    <h1 class='h2'>Product Swatches Information</h1>
                    <p> Enter all the product swatches information for each product entry.</p>
                    <div class="user-data-container">

                        <?php

                            echo "<div class='dashboard-user-update-data wide-form-container'>";

                                    if(isset($variationsForm)){

                                        echo $variationsForm;
                                    }
                        ?>

                            </div>
                    </div>
                </section>
            </section>         
        </main>
        <script src="../js/sliders.js"></script>
    </body>
</html>
