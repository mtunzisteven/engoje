<?php

if(!isset($_SESSION)){
    session_start();
}


if(!isset($_SESSION)){
    session_start();
}

$pageName ="Registration"; 
$pageShortSummary = "Account";
$pageDescription = "";

?><!DOCTYPE html>
<html lang="en-us">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
<body>

<main class="content">
    <?php 
        require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
        require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 

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

        

            <form class="reg-form" method="post" action="/engoje/accounts/index.php">
                <h3>Registration</h3>
                <label class="reg-label">First Name</label>
                <input class="reg-inputs" type="text" name="userFirstName" required placeholder="Enter your first name" />

                <label class="reg-label">Last Name</label>
                <input class="reg-inputs" type="text" name="userLastName" required placeholder="Enter your last name" />
                
                <label class="reg-label">Email Address</label>
                <input class="reg-inputs validity" type="email" name="userEmail" required placeholder="Enter a valid email address" />
                
                <label class="reg-label">Password</label>
                <input class="reg-inputs validity" type="password" name="userPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" />
                <span class="detail-span">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> 

                
                <input class="reg-inputs reg-button button" type="submit" name="submit" id="regbtn" value="register" />
                <input type="hidden" name="action" value="register">
                

            </form>    
        
        <?php require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
    </main>
</body>

</html>
<?php
    unset($_SESSION['message']);
?>