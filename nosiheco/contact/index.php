<?php

// This is the contact page controller

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}


switch($action){
    case 'contact':

    default:
        include "../views/contact.php";
        break;
}