<?php

// session expire reset: 180 sec
session_cache_expire();

//This is the shop controller for the site
session_start();

$action = filter_input(INPUT_POST, 'action',FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_STRING);
}

switch ($action){
            
    default:

       //echo "product"; exit;

       include $_SERVER['DOCUMENT_ROOT'].'/zalisting/view/shop-product.php';  
  
    }