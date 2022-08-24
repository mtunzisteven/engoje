<?php

if(!isset($_SESSION)){


// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

}


if(!isset($_SESSION)){


// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/library/sessionsManager.php'; 

}

$pageName ="Registration"; 
$pageShortSummary = "Account";
$pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/head.php'; ?>
<body>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/snippets/plain-navigation.php'; ?>

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
                <img  class="col" height="400" src="/images/register.svg" alt="signin" />
                <div class="col">

                    <form class="login-form" method="post" action="/accounts/index.php">
                        
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
<script src="/js/passwordmatch.js"></script>

</html>
