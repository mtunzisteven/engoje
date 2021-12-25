<?php

if (!isset($_SESSION)) {


// start session with same id in this file// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 

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