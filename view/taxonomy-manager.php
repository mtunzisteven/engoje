<?php

    if(!isset($_SESSION)){
    

// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 

    }

    if(!$_SESSION['loggedin']){
        header('Location: /engoje/');
    }
    else if($_SESSION['loggedin']&& $_SESSION['userData']['userLevel']<2){
        header('Location: /engoje/view/account.php');
    }

    $pageName ="Taxonomy Manager"; 
    $pageShortSummary = "Dashboard";
    $pageDescription = "Product management dashboard";

?><!DOCTYPE html>
<html lang="en-us" class=" admin-main">
    <?php require $_SERVER['DOCUMENT_ROOT']. '/engoje/snippets/head.php'; ?>
    <body class=" admin-main">
        <main class="content">
            <?php 
                require $_SERVER['DOCUMENT_ROOT']. '/engoje/snippets/header.php'; 
                require $_SERVER['DOCUMENT_ROOT']. '/engoje/snippets/navigation.php'; 
            ?>

            <section class="dashboard admin-dashboard">

                <?php

                    if(isset($adminSideNav)){
                        echo $adminSideNav;
                    }

                ?>

                <section class="dashboard-content user-data-container">
                    <div class='uploads-container'>
                        <h1 id=title>Taxonomy Management</h1>    
                        <p  id='ajaxResponse' class="notice"></p>

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Add New Taxonomy
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <form class="taxonomy-forms" action="/engoje/taxonomy/?action=add-colour" method="post">
                                                    <div class="mb-3">
                                                        <label for="colour" class="form-label">New Colour</label>
                                                        <input type="text" class="form-control" id="colour" name="colour">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary button">Submit</button>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <form class="taxonomy-forms" action="/engoje/taxonomy/?action=add-size" method="post">
                                                    <div class="mb-3">
                                                        <label for="size" class="form-label">New Size</label>
                                                        <input type="text" class="form-control" id="size" name="size">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="sizeName" class="form-label">Size Full Name</label>
                                                        <input type="text" class="form-control" id="sizeName" name="sizeName">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary button">Submit</button>
                                                </form>                                            </div>
                                            <div class="col">
                                                <form class="taxonomy-forms" action="/engoje/taxonomy/?action=add-category" method="post">
                                                    <div class="mb-3">
                                                        <label for="category" class="form-label">New Category</label>
                                                        <input type="text" class="form-control" id="category" name="category">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary button">Submit</button>
                                                </form>                                            
                                            </div>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Existing Taxonomies
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="container">
                                            <div class="row">
                                                <div class="col">
                                                    <form class="taxonomy-forms" action="/engoje/taxonomy/?action=delete-colour" method="post">
                                                        
                                                        <select name="colourId" class="form-select" aria-label="Default select example">
                                                            <option selected>select colour</option>

                                                            <?php

                                                                foreach($colours as $colour){

                                                            ?>

                                                            <option value="<?php echo htmlentities($colour['colourId']);?>"><?php echo $colour['colour'];?></option>

                                                            <?php
                                                                }
                                                            ?>

                                                            
                                                        </select>

                                                        <button type="submit" class="btn btn-primary button">Delete</button>
                                                    </form>
                                                </div>
                                                <div class="col">
                                                    <form class="taxonomy-forms" action="/engoje/taxonomy/?action=delete-size" method="post">
                                                        
                                                        <select name="sizeId" class="form-select" aria-label="Default select example">
                                                            <option selected>select size</option>

                                                            <?php

                                                                foreach($sizes as $size){

                                                            ?>

                                                            <option value="<?php echo htmlentities($size['sizeId']); ?>"><?php echo $size['sizeValue']." : ".$size['sizeName']; ?></option>

                                                            <?php
                                                                }
                                                            ?>

                                                            
                                                        </select>

                                                        <button type="submit" class="btn btn-primary button">Delete</button>
                                                    </form>                                      </div>
                                                <div class="col">
                                                    <form class="taxonomy-forms" action="/engoje/taxonomy/?action=delete-category" method="post">
                                                        
                                                        <select name="categoryId" class="form-select" aria-label="Default select example">
                                                            <option selected>select category</option>

                                                            <?php

                                                                foreach($categories as $category){

                                                            ?>

                                                            <option value="<?php echo htmlentities($category['categoryId']);?>"><?php echo $category['categoryName'];?></option>

                                                            <?php
                                                                }
                                                            ?>

                                                            
                                                        </select>

                                                        <button type="submit" class="btn btn-primary button">Delete</button>
                                                    </form>                                            
                                                </div>
                                            </div>
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
