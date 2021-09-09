<?php

// session expire reset: 180 sec
session_cache_expire();

//This is the Accounts Controller for the site
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the functions library
require_once '../library/functions.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the acciunts model for use as needed
require_once '../model/accounts-model.php';
// Get the reviews model for use as needed
require_once '../model/reviews-model.php';  
// Get the orders model for use as needed
require_once '../model/orders-model.php'; 


// Build User Update Admin Nav
$userUpdateNav = buildUserUpdateNav();


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

// active tab array
$_SESSION['active_tab'] = $active_tabs;
$_SESSION['active_tab']['orders'] = 'active';


// Get the side navs library
include '../library/sidenav.php';

// Build Admin Side Nav
$adminSideNav = buildAdminSideNav();

switch ($action) {

    case 'orders':

        $orders = getOrders();

    default:

        $ordersAdminTable = buildordersAdminTable($orders);

        //var_dump($ordersAdminTable); exit;

        include '../view/orders.php';

}

