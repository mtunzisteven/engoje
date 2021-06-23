<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="ZA Listing"; 
    $pageShortSummary = "Feedback";
    $pageDescription = "";

    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
    <body>

    <main class="content">
        <?php 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/header.php'; 
            require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/navigation.php'; 

            echo "<h1 class='title'>Feedback</h1>";


                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }else{
            ?>

            <form class="feedback-form" method="post" action="/zalisting/?action=fbr">
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
            
            <?php } require $_SERVER['DOCUMENT_ROOT'].'/zalisting/snippets/footer.php'; ?>
        </main>
    </body>
</html>