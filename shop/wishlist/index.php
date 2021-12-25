<?php



//This is the shop controller for the site// start session with same id in this file
require $_SERVER['DOCUMENT_ROOT'] . '/engoje/library/sessionsManager.php'; 


$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){
            
    default:

       include $_SERVER['DOCUMENT_ROOT'].'/engoje/view/wishlist.php';  
  
    }