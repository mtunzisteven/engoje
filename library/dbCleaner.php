<?php


// Get the database connection file
require_once '../library/connections.php';
// Get the cleaner script 
require_once '../library/dbCleaner.php';
// Get the engoje main model for use as needed
require_once '../model/main-model.php';
// Get the shop model for use as needed
require_once '../model/shop-model.php';
// Get the products admin model for use as needed
require_once '../model/products-model.php';
// Get the products image uploads model for use as needed
require_once '../model/uploads-model.php';

// This script cleans the data base of all redundant or expired data 

// create new date time object
$today = new DateTime();

// format datetime object
$today->format('U');

////////////////////
// Sale Cleaner
//////////////////////

    $saleItems = getSaleItems(); // get product on sale from db

    foreach($saleItems as $saleItem){

        $saleStart = new DateTime($saleItem['saleStart']);
        $saleStart->format('Y-m-d H:i:s');

        $interval = [date_diff($today, $saleStart)];

        // the number of days since start of sale months + days
        $daysElapsed = ($interval[0]->m*30+$interval[0]->d);   

        if($daysElapsed > $saleItem['salePeriod']){

            deleteSale($saleItem['saleId']);

        }

    }

//////////////////////
// End Sale Cleaner
///////////////////

// the number of days since start of sale months + days
$days = ($interval[0]->m*30+$interval[0]->d); 