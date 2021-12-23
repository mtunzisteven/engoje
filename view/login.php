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

            <?php
            
                if (isset($message)) {
                    echo $message;
                }

                $_SESSION['csrfToken'] = random_int(100000, 1000000);
                ?>

            <div class="container shadow-lg w-sm-100 w-75">

                <div class="row align-items-center pb-5 pt-2">
                    <div class="col">

                        <form class="login-form" method="post" action="../accounts/index.php">
                            <label class="login-label" style="text-align:left; min-width: 65%;">Email Address</label>
                            <input class="login-inputs validity" type="email" name="userEmail" required  value="<?php if(isset($userEmail)){echo $userEmail;}  ?>" />
                            
                            <label class="login-label" style="text-align:left; min-width: 65%;">Password</label>
                            <input class="login-inputs" type="password" name="userPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" />
                            
                            
                            <input class="login-inputs button" type="submit" name="action" value="login" />
                            <input type="hidden" name="_csrf" value="<?php echo $_SESSION['csrfToken'] ?>" />
                            <input type="hidden" name="action" value="Login" />

                            <span class='detail-span' >No account? Please register below:</span>
                            <a  class="login-inputs login-reg-button " href="index.php?action=reg" title="registration form">register</a>
                        </form> 

                    </div>
                    <img  class="col" height="400" src="/engoje/images/login.svg" alt="signin" />
                </div>
            </div>
        </main>
    </body>
</html>