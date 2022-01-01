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
require_once '../model/orders-model.php';

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

////////////////////
// Order Cleaner
//////////////////////

    $orders = getOrders(); // get all orders from db

    foreach($orders as $order){

        $orderDate = new DateTime($order['orderDate']);
        $orderDate->format('Y-m-d H:i:s');

        $interval = [date_diff($today, $orderDate)];

        // the number of hours since order placed
        $hoursElapsed = ($interval[0]->m*30*24+$interval[0]->d*24+$interval[0]->h);  

        // if it's morethan 2 hours and order is still not paid
        // replace item amounts in the db if order had already been checked out:
        if($hoursElapsed >= 2 && $order['orderStatus'] == 'checked-out'){

            $order_items = explode(",", $order['order_items']);

            for($i = 0; $i < count($order_items); $i+=5){


                // id for the item in the db
                $product_entryId = $order_items[$i];
                // amount of this item to be purchased
                $purchaseAmount = intval($order_items[$i+4]);

                // amount available in the db
                $amount = getProduct_entryAmount($product_entryId);

                $amount = intval($amount['amount']);

                $reversedAmount = $amount + $purchaseAmount;


                // updatge done in the model within 
                // the function used below: updateQty().
                updateQty($product_entryId, $reversedAmount);
            }
            // delete the order from the db
            deleteOrder($order['orderId']);

        }else if($hoursElapsed >= 48 && $order['orderStatus'] == 'processing'){

            // delete the order from the db
            deleteOrder($order['orderId']);

        }

    }

//////////////////////
// End Order Cleaner
///////////////////
