<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 

    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }
    else if($_SESSION['loggedin'] && $_SESSION['userData']['userLevel']<2){
        header('Location: /engoje/view/account.php');
    }

    $pageName ="Image Manager"; 
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
                        <p  id='ajaxResponse' class="notice"></p>

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Add New Product Image
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

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

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Existing Images
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <p>These are product images. If one is deleted, the product will no longer appear in the store.</p>
                                        <div class="media-display">
                                            <?php
                                                if (isset($imageDisplay)) {
                                                    echo $imageDisplay;
                                                } 
                                            ?>
                                        </div> 

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </section>         
        </main>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <script src="/engoje/js/counts.js"></script>
    </body>
</html>
