<?php

//This is the shop controller for the site
session_start();

$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){
            
    default:

       include $_SERVER['DOCUMENT_ROOT'].'/zalisting/view/wishlist.php';  
  
    }