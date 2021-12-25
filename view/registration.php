<?php

if(!isset($_SESSION)){


// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 

}


if(!isset($_SESSION)){


// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 

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

            $_SESSION['csrfToken'] = random_int(100000, 1000000);

        ?>
        
        <div class="container shadow-lg w-sm-100 w-75">
            <div class="row align-items-center pb-5 pt-2">
                <img  class="col" height="400" src="/engoje/images/register.svg" alt="signin" />
                <div class="col">

                    <form class="login-form" method="post" action="/engoje/accounts/index.php">
                        <label class="reg-label" style="text-align:left; min-width: 65%;">First Name</label>
                        <input class="reg-inputs" type="text" name="userFirstName" required />

                        <label class="reg-label" style="text-align:left; min-width: 65%;">Last Name</label>
                        <input class="reg-inputs" type="text" name="userLastName" required />
                        
                        <label class="reg-label" style="text-align:left; min-width: 65%;">Email Address</label>
                        <input class="reg-inputs validity" type="email" name="userEmail" required  />

                        <input class="reg-inputs reg-button button" type="submit" name="submit" id="regbtn" value="register" />
                        <input type="hidden" name="_csrf" value="<?php echo $_SESSION['csrfToken'] ?>" />
                        <input type="hidden" name="action" value="register">  
                        <span class='detail-span'>Have an account? login below:</span>

                        <a  class="login-inputs login-reg-button " href="index.php?action=login" title="registration form">login</a>
              
                    </form>   

                </div>
            </div>
        </div>
    </main>
</body>

</html>
<?php
    unset($_SESSION['message']);
?>