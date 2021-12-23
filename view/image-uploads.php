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

    $pageName ="Add Manage"; 
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

                <section class="dashboard-content user-data-container">
                    <div class='uploads-container'>
                        <h1 id=title>Image Management</h1>    

                        <h2 class="notice">Add New Product Image</h2>
                        <p  id='ajaxResponse' class="notice"></p>
                        <?php
                            if (isset($message)) {
                                echo $message;
                            } 
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                            } 

                            echo "<div class='upload-forms-container'>";

                            if (isset($uploadForms)) {

                                echo $uploadForms;

                            } 

                            echo "</div>";

                        ?>



                        <hr/>

                        <h2 class="notice">Existing Images</h2>
                        <p>These are product images. If one is deleted, the product will no longer appear in the store.</p>
                        <div class="media-display">
                            <?php
                                if (isset($imageDisplay)) {
                                    echo $imageDisplay;
                                } 
                            ?>
                        </div> 
                    </div>
                </section>
            </section>         
        </main>
        <script src="../js/sliders.js"></script>
        <script src="../js/uploads.js"></script>
    </body>
</html>
