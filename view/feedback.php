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

    $pageName ="engoje"; 
    $pageShortSummary = "Feedback";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/head.php'; ?>
    <body>

    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/engoje/snippets/navigation.php'; 

            echo "<h1 class='title'>Feedback</h1>";


                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }else{
            ?>

            <form class="feedback-form" method="post" action="/engoje/?action=fbr">
                <label class="feedback-label">Email</label>
                <input class="feedback-inputs" type="email" name="userEmail" required placeholder="Enter a valid email address" value="<?php if(isset($_SESSION['userData'])){echo $_SESSION['userData']['userEmail'] ;}  ?>" />
                
                <label class="feedback-label borderd">How was your experiance?<br />
                <label class="feedback-label radio"><input class="feedback-radio" type="radio" name="experince" value='Good' /> Good</label> 
                <label class="feedback-label radio"><input class="feedback-radio" type="radio" name="experince" value='Average' /> Average</label> 
                <label class="feedback-label radio"><input class="feedback-radio" type="radio" name="experince" value='Bad' /> Bad</label> 
                </label>

                <label class="feedback-label">Enter Feedback</label>
                <textarea class="feedback-inputs" name="feedback" rows=10 placeholder="Enter feedback" ></textarea>                
                
                <input class="feedback-inputs button" type="submit" value="submit" />
                

            </form>            
            
            <?php } require $_SERVER['DOCUMENT_ROOT'].'/engoje/snippets/footer.php'; ?>
        </main>
    </body>
</html>