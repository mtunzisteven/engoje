<?php

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

