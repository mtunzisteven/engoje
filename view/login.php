<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Login"; 
    $pageShortSummary = "Account";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/plain-navigation.php'; ?>

        <main class="content py-5 bg-light" >
            <h1 class='title'>Login</h1>

            <div class="container shadow-lg w-sm-100 w-75">
                
                <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>

                <div class="row align-items-center pb-5 pt-2">
                    <div class="col">

                        <form class="login-form" method="post" action="../accounts/index.php">
                            <label class="login-label" style="text-align:left; min-width: 65%;">Email Address</label>
                            <input class="login-inputs validity" type="email" name="userEmail" required  value="<?php if(isset($userEmail)){echo $userEmail;}  ?>" />
                            
                            <label class="login-label" style="text-align:left; min-width: 65%;">Password</label>
                            <input class="login-inputs" type="password" name="userPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" />
                            
                            
                            <input class="login-inputs button" type="submit" name="action" value="login" />
                            <input type="hidden" name="action" value="Login" />

                            <span class='detail-span' style="text-align:left;">No account? Please register below:</span>
                            <a  class="login-inputs login-reg-button " href="index.php?action=reg" title="registration form">register</a>
                        </form> 

                    </div>
                    <img  class="col" height="400" src="/engoje/images/login.svg" alt="signin" />
                </div>
            </div>
        </main>
    </body>
</html>