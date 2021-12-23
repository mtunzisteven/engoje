<?php

if (!isset($_SESSION)) {


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

//echo $_SESSION['userData']['userFirstName']; exit;

if (!$_SESSION['loggedin']) {
    header('Location: /engoje/');
}

$pageName = "Account";
$pageShortSummary = "Dashboard";
$pageDescription = "User Account dashboard";

?>
<!DOCTYPE html>
<html lang="en-us">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>

<body class=" admin-main">
    <main class="content">
        <?php
        require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php';
        ?>

        <div class="dashboard admin-dashboard">


            <?php

            if (isset($adminSideNav)) {
                echo $adminSideNav;
            }

            ?>

            <div class="dashboard-content">
                <?php
                echo "<h1 class='h2'>Welcome to your Account Dashboard ". $_SESSION['userData']['userFirstName']."</h1>";

                if (isset($message)) {
                    echo $message;
                }
                ?>
                <p> Here's a summary of your acount activity:</p>
            </div>
        </div>
    </main>
    <script src="/engoje/js/counts.js"></script>
    <script src="/engoje/js/sliders.js"></script>
</body>

</html>
<?php
unset($_SESSION['message']);
?>