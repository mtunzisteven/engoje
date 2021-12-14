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

$pageName ="Registration"; 
$pageShortSummary = "Account";
$pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
<body>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/plain-navigation.php'; ?>

<main class="content py-5 bg-light">
    <?php 

        echo "<h1 class='title'>Register</h1>";


            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            if(isset($message)){
                echo $message;
            }

            if(isset($_SESSION['message'])){
                echo $_SESSION['message'];
            }

        ?>
        
        <div class="container shadow-lg w-sm-100 w-75">
            <div class="row align-items-center pb-5 pt-2">
                <img  class="col" height="400" src="/engoje/images/register.svg" alt="signin" />
                <div class="col">

                    <form class="login-form" method="post" action="/engoje/accounts/index.php">
                        
                        <label class="reg-label" style="text-align:left; min-width: 65%;">Password</label>
                        <input id="password" class="reg-inputs validity" type="password" name="userPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" />
                        <span class="detail-span">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> 

                        <label class="reg-label" style="text-align:left; min-width: 65%;">Confirm Password</label>
                        <input id="password2" class="reg-inputs validity" type="password" name="userPasswordConfirm" required />

                        <div id="match-password-div" class="small-notice text-center my-3"></div>

                        <input class="reg-inputs reg-button button" type="submit" name="submit" id="regbtn" value="Set Password" />
                        <input type="hidden" name="action" value="complete-reg">  
                        <input type="hidden" name="taid" value="<?php echo $temp_accountId ?>">  
              
                    </form>   

                </div>
            </div>
        </div>
    </main>
</body>
<script src="/engoje/js/passwordmatch.js"></script>

</html>
