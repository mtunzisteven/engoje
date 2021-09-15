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

    <main class="content py-5 bg-light" >
        <h1 class='title'>Login</h1>

        <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            if(isset($message)){
                echo $message;
            }
        ?>
        <div class="container shadow-lg w-sm-100 w-75">
            <div class="row align-items-center pb-5 pt-2">
                <div class="col">

                    <form class="login-form" method="post" action="../accounts/index.php">
                        <label class="login-label">Email Address</label>
                        <input class="login-inputs validity" type="email" name="userEmail" required placeholder="Enter a valid email address" value="<?php if(isset($userEmail)){echo $userEmail;}  ?>" />
                        
                        <label class="login-label">Password</label>
                        <input class="login-inputs" type="password" name="userPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Enter your password" />
                        
                        
                        <input class="login-inputs button" type="submit" name="action" value="login" />

                        <span class='detail-span'>No account? Please register below:</span>
                        <a  class="login-inputs login-reg-button " href="index.php?action=reg" title="registration form">register</a>
                    </form> 

                </div>
                <img  class="col" height="400" src="/engoje/images/logodark.png" alt="logo" />

            </div>

                       
        </main>
    </body>
</html>