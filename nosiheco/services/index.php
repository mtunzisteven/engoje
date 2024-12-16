<?php

// This is the services page controller

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}


switch($action){
    case 'services':

    default:
        include "../views/services.php";
        break;
}