<?php

function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);

 return $valEmail;
}

// Check the password for a minimum of 8 characters,
 // at least one 1 capital letter, at least 1 number and
 // at least 1 special character
function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

//CHeck that the price is entered as a float
function checkPrice($invPrice){
    $pattern = '/\d+(\.\d{2})?/';
    return preg_match($pattern, $invPrice);
}

//  Build Admin Side Nav display
function buildAdminSideNav(){

    $adminSideNav = "<ul class='dashboard-side-nav'>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/admin' class='dashboard-side-nav-links dashboard-main-link'>DASHBOARD</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/admin/?action=account' class='dashboard-side-nav-links'>My Account</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/admin/?action=users' class='dashboard-side-nav-links'>Accounts</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/products/?action=product' class='dashboard-side-nav-links'>Products</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a href='/zalisting/upload/' class='dashboard-side-nav-links'>Images</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Orders</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Reviews</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Sales</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Reports</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links'>Logs</a></li>";
    $adminSideNav .= "<li class='dashboard-side-nav-items'><a class='dashboard-side-nav-links' href='/zalisting/accounts/index.php?action=logout'>Logout</a></li>";
    $adminSideNav .= "</ul>";

    return $adminSideNav;
}


// Build a multi user display view
function buildUsersDisplay($users){

    $userRows = [];

    foreach($users as $user){

        $userRows[] = "<tr class='user-display-info'> <td><a class='button account-button' href='/zalisting/admin/?action=user&userId=$user[userId]'>update</a> </td>  <td>$user[userFirstName] $user[userLastName]</td> <td>$user[userEmail]</td> <td>0$user[userPhone]</td> </tr>";
    }

   return $userRows;
  }

// Build a cart view display view
function buildCartDisplay($cartDetails, $shippingInfo){

    $cartDisplay = "<div id='cart' class='cart-display-table'><div class='cart-display-table-row'><div>Product</div><div>Name</div><div>Colour</div><div>Size</div><div>Price</div><div>Quantity</div><div>Total</div><div>Remove Item</div></div>";

    $grandTotal = 0;

    $_SESSION['order'] = "";

    foreach($cartDetails as $cartItem){

        if($_SESSION['order'] == ""){

            $_SESSION['order'] .= $cartItem['product_entryId'].",".$cartItem['productName'].",".$cartItem['colour'].",".$cartItem['price'].",".$cartItem['cart_item_qty'];
        
        }else{

            $_SESSION['order'] .= ",".$cartItem['product_entryId'].",".$cartItem['productName'].",".$cartItem['colour'].",".$cartItem['price'].",".$cartItem['cart_item_qty'];

        }
        
        $lineTotal = $cartItem['price']*$cartItem['cart_item_qty'];
        $grandTotal += $lineTotal;

        $cartDisplay .= "<div class='seperator'></div><div class='cart-display-table-rows'> ";
        $cartDisplay .= "<div><a href='/zalisting/shop?action=product&productId=$cartItem[productId]&product_entryId=$cartItem[product_entryId]&colour=$cartItem[colour]' ><img src='$cartItem[imagePath_tn]'></a></div>"; 
        $cartDisplay .= "<div>$cartItem[productName]</div>"; 
        $cartDisplay .= "<div>$cartItem[colour]</div>"; 
        $cartDisplay .= "<div>$cartItem[sizeValue]</div>"; 
        $cartDisplay .= "<div>R<span class='price'>$cartItem[price]</span></div>"; 
        $cartDisplay .= "<div class='buttoned-div'><button class='button oneDown'>-</button><input type='number' class='cart-item-qty validity' name='cart_item_qty' value='$cartItem[cart_item_qty]' min=1 /><button class='button oneUp'>+</button></div>"; 
        $cartDisplay .= "<div>R<span class='line-total'>$lineTotal</span></div>"; 
        $cartDisplay .= "<div class='cart-item-remove-button remove-cart-item'><a href='/zalisting/cart/index.php?action=remove-cart-item&product_entryId=$cartItem[product_entryId]'><i class='remove-item-x fa fa-times'></i></a></div></div>";         

    }

    $cartDisplay .= '</div>';
    $cartDisplay .= "<div class='cart-display-table-row2'><div class='cart-total-container'><h4>Cart Total:   R</h4><h4 id='grand-total'>$grandTotal</h4></div>";
    $cartDisplay .= "<a id='update-cart' class='update-cart button cart-buttons'>Update Cart</a>";
    $cartDisplay .= "<a href='/zalisting/cart/index.php?action=clear-cart' class='clear-cart button cart-buttons'>Clear Cart</a></div>";

    $cartDisplay .= "<div class='cart-display-table-column'><h4 class='shipping-methods'>Select Shipping Method:</h4>";
    $cartDisplay .= "<form class='cart-checkout-form' action='/zalisting/shop/checkout/' method='post'>";
    $cartDisplay .= "<div class='shipping-methods-container'>"; 

    foreach($shippingInfo as $shippingMethod){

        $cartDisplay .= "<label class='checkout-to-label'><input type='radio' class='shippingId' name='shippingId' value='$shippingMethod[shippingId]' /> $shippingMethod[name]($shippingMethod[period]): R$shippingMethod[price] </label>";
        $cartDisplay .= "<input id='shippingId$shippingMethod[shippingId]' type='hidden' value='$shippingMethod[price]' />";
    }
    
    $cartDisplay .= "<h4 id='grand-ship-total'><div class='strong'>Grand Total:</div> R$grandTotal</h4>";
    $cartDisplay .= "</div><input type='submit' class='clear-cart button wishlist-buttons' value='Checkout' /> </form></div>";



   return $cartDisplay;
  }

  // Build a cart view display view
function buildWishlistDisplay($wishlistDetails){

    $wishlistDisplay = "<div id='cart' class='cart-display-table'><div class='cart-display-table-row'><div>Product</div><div>Name</div><div>Colour</div><div>Size</div><div>Price</div><div>Remove Item</div></div>";

    foreach($wishlistDetails as $wishlistItem){

        $wishlistDisplay .= "<div class='seperator'></div><div class='cart-display-table-rows'> ";
        $wishlistDisplay .= "<div><a href='/zalisting/shop?action=product&productId=$wishlistItem[productId]' ><img src='$wishlistItem[imagePath_tn]' alt='product image'></a></div>"; 
        $wishlistDisplay .= "<div>$wishlistItem[productName]</div>"; 
        $wishlistDisplay .= "<div>$wishlistItem[colour]</div>"; 
        $wishlistDisplay .= "<div>$wishlistItem[sizeValue]</div>"; 
        $wishlistDisplay .= "<div>R$wishlistItem[price]</div>"; 
        $wishlistDisplay .= "<div class='cart-item-remove-button remove-cart-item'><a href='/zalisting/wishlist/index.php?action=remove-wishlist-item&product_entryId=$wishlistItem[product_entryId]'><i class='remove-item-x fa fa-times'></i></a></div></div>";         

    }

    $wishlistDisplay .= "<div class='seperator'></div></div>";
    $wishlistDisplay .= "<a href='/zalisting/wishlist/index.php?action=clear-wishlist' class='clear-cart button wishlist-buttons'>Clear Wish List</a>";

    return $wishlistDisplay;

  }

// Build a cart view display view
function buildCheckoutDisplay($checkoutDetails, $userDetails, $orderId, $order, $shippingInfo){

    //var_dump($userDetails); exit;

    $grandTotal = $shippingInfo['price'];

    $checkoutDisplay = "<div id='checkout' class='checkout-display-form' >";
    $checkoutDisplay .= "<div class='address-column'>";

    // manually sort address using concartination
    $addresses1 = '';
    $addresses2 = '';


    foreach($userDetails as $user){
        
        if($user['addressType'] == 2){

            $addresses2 .= "<h2 class='address-column-title'>Shipping Address:</h2>";
            $addresses2 .= "<div class='checkout-label'>$user[addressName]</div>"; 
            $addresses2 .= "<div class='checkout-label'>$user[addressNumber]</div>"; 
            $addresses2 .= "<div class='checkout-label'>$user[addressEmail]</div>"; 
            $addresses2 .= "<div class='checkout-label'>$user[addressLineOne]</div>"; 
            $addresses2 .= "<div class='checkout-label'>$user[addressLineTwo]</div>"; 
            $addresses2 .= "<div class='checkout-label'>$user[addressCity]</div>";         
            $addresses2 .= "<div class='checkout-label'>$user[addressZipCode]</div>";             
        }
        
        if($user['addressType'] == 1){

            $addresses1 .= "<h2 class='address-column-title'>Billing Address:</h2>";
            $addresses1 .= "<div class='checkout-label'>$user[addressName]</div>"; 
            $addresses1 .= "<div class='checkout-label'>$user[addressNumber]</div>"; 
            $addresses1 .= "<div class='checkout-label'>$user[addressEmail]</div>"; 
            $addresses1 .= "<div class='checkout-label'>$user[addressLineOne]</div>"; 
            $addresses1 .= "<div class='checkout-label'>$user[addressLineTwo]</div>"; 
            $addresses1 .= "<div class='checkout-label'>$user[addressCity]</div>";         
            $addresses1 .= "<div class='checkout-label'>$user[addressZipCode]</div>";  

        }
    }

    // concartinate addresses in the correct order
    $checkoutDisplay .= $addresses1.$addresses2;      

    $checkoutDisplay .= "<div id='new-address' class='button new-address'>Change Shipping Address</div>";  

    $checkoutDisplay .= "</div>";      
        
    $checkoutDisplay .= "<div class='cart-summary-column'><div class='cart-items-summary'>";  
    
    // labels
    $checkoutDisplay .= "<div class='cart-item cart-item-summary-label'><div class='summary-product-names header-labels'>Product</div>"; 
    $checkoutDisplay .= "<div class='summary-product-qty header-labels'>Quantity</div>"; 
    $checkoutDisplay .= "<div class='summary-product-price header-labels'>Price</div></div>"; 

    foreach($checkoutDetails as $cartItem){

        $lineTotal = $cartItem['price']*$cartItem['cart_item_qty'];
        $grandTotal += $lineTotal;



        $checkoutDisplay .= "<div class='cart-item'><div class='summary-product-names'>$cartItem[productName]</div>"; 
        $checkoutDisplay .= "<div class='summary-product-qty'>$cartItem[cart_item_qty]</div>"; 
        $checkoutDisplay .= "<div class='summary-product-price'>R".$cartItem['price']*$cartItem['cart_item_qty']."</div></div>"; 

    }

    $checkoutDisplay .= "<div class='seperator'></div>"; 
    $checkoutDisplay .= "<div class='summary-product-shipping'><div>Shipping  </div><div>$shippingInfo[period]: R$shippingInfo[price]</div></div>"; 
    $checkoutDisplay .= "<div class='seperator'></div>"; 
    $checkoutDisplay .= "<div class='summary-product-total'><h2>Total:  </h2><h2 id='grand-total-display' class='cart-total'>R$grandTotal</h2></div>"; 
    $checkoutDisplay .= "<input type='hidden' id='shipping-fee' value='$shippingInfo[price]' />"; 



    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                            Payfatst                                                //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Construct variables
        $cartTotal = $grandTotal;// This amount needs to be sourced from your application

        // get name from billing address and split it into first and last name
        $fullName = explode(" ",$userDetails[0]['addressName']);

        $firstName = $fullName[0];
        $lastName = $fullName[1];

        $data = array(
            // Merchant details
            'merchant_id' => '13258122',
            'merchant_key' => 'bcdu5x8q91980',
            'return_url' => 'http://www.zalisting.com/return.php',
            'cancel_url' => 'http://www.zalisting.com/cancel.php',
            'notify_url' => 'http://www.zalisting.com/notify.php',
            // Buyer details
            'name_first' => $firstName,
            'name_last'  => $lastName,
            'email_address'=> $userDetails[0]['addressEmail'],
            // Transaction details
            'm_payment_id' => $orderId, //Unique payment ID to pass through to notify_url
            'amount' => number_format( sprintf( '%.2f', $cartTotal ), 2, '.', '' ),
            'item_name' => "Order#$orderId"
        );
    
        $signature = generateSignature($data);
        $data['signature'] = $signature;
    
        // If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
        $testingMode = true;
        $pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
        $htmlForm = '<form id="payfastForm" class="payfast-form" action="https://'.$pfHost.'/eng/process" method="post">'; 
        foreach($data as $name=> $value)
        {
            $htmlForm .= '<input name="'.$name.'" type="hidden" value=\''.$value.'\' />';
        }
        $htmlForm .= "<input id='order' type='hidden' name='order' value='$order' />";
        // this is not for payfast, but for internal use.
        $htmlForm .= "<input id='orderTotal' type='hidden' name='orderTotal' value='$grandTotal' />";
        $htmlForm .= '<input id="payfastButton" type="button" class="button" value="Pay Now" /></form>';

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                         Payfatst   End                                             //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////

    $checkoutDisplay .= "</div>$htmlForm</div></div>";
    $checkoutDisplay .= "<a href='/zalisting/cart/?action=cart' class='button checkout-back'>Back to Cart</a>"; 
    $checkoutDisplay .= "<a id='redirect' class='hidden' href='/zalisting/checkout/' class='button checkout-back'>redirect</a>"; 


    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                           Pop up forms                                             //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    $checkoutDisplay .= "<div id='HidenformC' class='hidden'><form class=' new-address-form' action='/zalisting/checkout/?action=new-shipping-address' method='POST'>";
    $checkoutDisplay .= "<div class='cancel-container'> <div> </div><i id='cancelNewAddress' class='fa fa-times cancelNewAddress' aria-hidden='true'></i></div>"; 

    $checkoutDisplay .= "<div class='label'> Name of Person Receiving Shipment: </div> <input type='text' name='addressName' required />"; 

    $checkoutDisplay .= "<div class='label'> Contact Phone Number: </div> <input type='tel' name='addressNumber' required />"; 
    $checkoutDisplay .= "<div class='label'> Contact Email: </div> <input type='email' name='addressEmail' required />";  
    $checkoutDisplay .= "<div class='label'> Address Line 1: </div> <input type='text' name='addressLineOne' required />"; 
    $checkoutDisplay .= "<div class='label'> Address Line 2: </div> <input type='text' name='addressLineTwo' required />"; 
    $checkoutDisplay .= "<div class='label'> City: </div> <input type='text' name='addressCity' required />";  
    $checkoutDisplay .= "<div class='label'> Zip Code: </div> <input type='text' name='addressZipCode' required />"; 

    $checkoutDisplay .= "<input type='hidden' name='orderNumber' value='$orderId' />"; 
    $checkoutDisplay .= "<input type='hidden' name='userId' value='".$userDetails[0]['userId']."' />"; 
    $checkoutDisplay .= "<input type='hidden' name='addressType' value='2' />";   
    $checkoutDisplay .= "<input type='button' class='button' id='newAddress' value='Submit' />";  
    $checkoutDisplay .= "</form></div>"; 

    // confirm adjusted order pop up
    $checkoutDisplay .= "<div id='popupCard' class='hidden'><form class=' new-address-form' >";
    $checkoutDisplay .= "<div class='cancel-container'> <div> </div><i id='cancelPayfastConfirm' class='fa fa-times cancelNewAddress' aria-hidden='true'></i></div>"; 

    $checkoutDisplay .= "<div id='popupCardtext'> </div>"; 


    $checkoutDisplay .= "<div class='confirmConfirm'> <input type='button' class='button' id='popupCardNo' value='Cancel' /> <input type='button' class='button' id='popupCardYes' value='Proceed' /> </div>";  
    $checkoutDisplay .= "</form></div>"; 

    return $checkoutDisplay;

  }

  // Build a cart view display view
function buildCheckoutAddressDisplay(){

    $checkoutAddressDisplay = "<form class='checkout-address' action='/zalisting/shop/checkout/?action=addressed' method='POST' ><div id='checkout' class='checkout-display-form address' >";
    $checkoutAddressDisplay .= "<div class='address-column'>";

    $checkoutAddressDisplay .= "<h2 class='address-column-title'>Billing Address:</h2>";
    $checkoutAddressDisplay .= "<div class='checkout-label'> Name<input type='text' name='bname' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'>Phone<input type='tel' name='bphone' required /></div>";         
    $checkoutAddressDisplay .= "<div class='checkout-label'>Email<input type='email' name='bemail' required /></div>";     
    $checkoutAddressDisplay .= "<div class='checkout-label'> Address Line 1<input type='text' name='baddressLine1' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'> Address Line 2<input type='text' name='baddressLine2' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'> City<input type='text' name='bcity' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'>Zip Code<input type='number' name='bzipCode' required /></div>"; 
        
   
    $checkoutAddressDisplay .= "</div>";      
        
    $checkoutAddressDisplay .= "<div class='address-column'>"; 

    $checkoutAddressDisplay .= "<h2 class='address-column-title'>Shipping Address:</h2>";
    $checkoutAddressDisplay .= "<div class='checkout-label'> Name<input type='text' name='sname' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'>Phone<input type='tel' name='sphone' required /></div>";         
    $checkoutAddressDisplay .= "<div class='checkout-label'>Email<input type='email' name='semail' required /></div>";     
    $checkoutAddressDisplay .= "<div class='checkout-label'> Address Line 1<input type='text' name='saddressLine1' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'> Address Line 2<input type='text' name='saddressLine2' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'> City<input type='text' name='scity' required /></div>"; 
    $checkoutAddressDisplay .= "<div class='checkout-label'>Zip Code<input type='number' name='szipCode' required /></div>"; 

    $checkoutAddressDisplay .= "</div></div>";     
    $checkoutAddressDisplay .= "<input class='button' type='submit' value='Next' /></form>";     

    $checkoutAddressDisplay .= "<a href='/zalisting/cart/?action=cart' class='button checkout-back'>Back to Cart</a>";

    return $checkoutAddressDisplay;

  }
  

// Build a multi product display table on admin dashboard
function buildAdminProductsDisplay($allProducts, $nonImgedProducts){

    $productRows = [];

    foreach($allProducts as $product){

        for($i = 0; $i < count($nonImgedProducts); $i++){

            $path = $i + 1;    // The actual path for the same colour image
            $productId = $i+2; // products table productId which is shred by all product_entries from that product

            // Match colour and shared productId from products table
            if($nonImgedProducts[$i] == $product['colour'] && $nonImgedProducts[$productId] == $product['productId']){


                $productRows[] = "<tr class='user-display-info'> <td class=td-buttons ><a class='button account-button' href='/zalisting/products/?action=update&product_entryId=$product[product_entryId]'>update</a> <a class='button account-button' href='/zalisting/products/?action=delete&product_entryId=$product[product_entryId]'>delete</a> </td><td><img class=image-tn src='$nonImgedProducts[$path]' /></td>  <td>$product[productName] </td> <td>$product[price] </td> <td>$product[amount] </td> <td>$product[sizeValue]</td> <td>$product[colour]</td> <td>$product[sku]</td> </tr>";
        
            }
        }
    }

   return $productRows;
  }

//  Build User Update Admin Nav display
function buildUserUpdateNav(){

    $accountUser = "";

    if(isset($_SESSION['updatinguserId'])){
        $accountUser = $_SESSION['updatinguserId'];
    }

    $updateNav ="<ul class='user-update'>";    
    $updateNav .="<li class='user-update-item' ><a href='/zalisting/admin/?action=user&userId=$accountUser'>Personal</a></li>";
    $updateNav .="<li class='user-update-item' ><a href='/zalisting/admin/?action=address'>Addresses</a></li>";
    $updateNav .="<li class='user-update-item' ><a href=''>Orders</a></li>";
    $updateNav .="<li class='user-update-item' ><a href=''>Returns</a></li>";
    $updateNav .="</ul>";

    return $updateNav;
}


// Build a single user display view
function buildUserDisplay($userInfo){

    $userDisplay = "<form method='POST' action='/zalisting/admin/'>";

    $userDisplay .= "<label>First Name</label><input type='text' name='userFirstName' value='$userInfo[userFirstName]' />";
    $userDisplay .= "<label>Last Name</label><input type='text' name='userLastName' value='$userInfo[userLastName]' />";
    $userDisplay .= "<label>Email</label><input type='text' name='userEmail' value='$userInfo[userEmail]' />";
    $userDisplay .= "<label>Phone Number</label><input type='tel' name='userPhone' value='0$userInfo[userPhone]' />";
    $userDisplay .= "<input class='button account-button' type='submit' value='submit' />";
    $userDisplay .= "<input type='hidden' name='action' value='update-user' />";
    $userDisplay .= "<input type='hidden' name='userId' value='$userInfo[userId]' />";

    $userDisplay .= "</form>";

   return $userDisplay;
  }

// Build a Address adding or update form view
function buildAddressForm($address, $addressFound){

    //var_dump($addresses); exit;

    // This will potentially have 2 addresses but is an array none the less
    // So we must loop through regardless how many addresses exist, 
    // the if statements will give us the variable value we want for action

    // When no address exists
    if($addressFound==false){

        $action = 'new-address';
        
        // Set address type to be able to make readonly value of 1
        $addressType = 1;

        // Set address db variables to empty strings
        $addressLineOne = "";
        $addressLineTwo = "";
        $addressCity = "";
        $addressZipCode = "";


    }else if($addressFound==true){//When there is atleast one address found

        $action = 'update-address';

        // Set actual address db variables to their valules

        $addressLineOne = $address['addressLineOne'];
        $addressLineTwo = $address['addressLineTwo'];
        $addressCity = $address['addressCity'];
        $addressZipCode = $address['addressZipCode'];
        $addressType = $address['addressType'];

    }

    //echo $action; exit;
    $form = "<form method='POST' action='/zalisting/admin/?action=$action'>";
    $form .= "<label>Address Line 1</label><input type=text name=addressLineOne value='$addressLineOne' />";
    $form .= "<label>Address Line 2</label><input type=text name=addressLineTwo value='$addressLineTwo' />";
    $form .= "<label>City</label><input type=text name=addressCity value='$addressCity' />";
    $form .= "<label>Zip Code</label><input type=text name=addressZipCode value='$addressZipCode' />";
    $form .= "<input type=hidden name=addressType value='$addressType' />";
    $form .= "<input class=button account-button type=submit value=submit />";
    $form .= "</form>";

    //var_dump($addressType); exit;

    return $form;
  }

//  Build Address display
function buildAddresses($addresses, $addressFound){

    //var_dump($addresses); exit;
    
    $address ="<div class='dashboard-details-addresses'>";

    if($addressFound==false){
        $address .="<div class='dashboard-details-address'>"; 
        $address .="<p class='detail-span-bold'><strong>Billing Address</strong></p>"; 
        $address .="<p class='detail-span-bold' >No address added...</p>";
        $address .="</div>";
        $address .="<div class='dashboard-details-address'>"; 
        $address .="<p class='detail-span-bold'><strong>Shipping Address</strong></p>"; 
        $address .="<p class='detail-span-bold' >No address added...</p>";
        $address .="</div>";
    }else{ 

        foreach($addresses as $eachAddress){

            if($eachAddress['addressType']==1){
                $address .="<div class='dashboard-details-address'>"; 
                $address .="<p class='detail-span-bold'><strong>Billing Address</strong></p>"; 
                $address .="<p class='detail-span-bold' >".$eachAddress['addressLineOne']."</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressLineTwo]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressCity]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressZipCode]</p>";
                $address .="<a class='button account-button center' href='/zalisting/admin/?action=replace-address&addressType=1'>update</a>";
                $address .="</div>";
            }

            else if($eachAddress['addressType']==2){

                //var_dump($eachAddress['addressType']); exit;

                $address .="<div class='dashboard-details-address'>"; 
                $address .="<p class='detail-span-bold'><strong>Shipping Address</strong></p>"; 
                $address .="<p class='detail-span-bold' >$eachAddress[addressLineOne]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressLineTwo]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressCity]</p>";
                $address .="<p class='detail-span-bold' >$eachAddress[addressZipCode]</p>";
                $address .="<a class='button account-button center' href='/zalisting/admin/?action=replace-address&addressType=2'>update</a>";
                $address .="</div>";
            }
        }
    }


    $address .="</div>";

    //var_dump($address); exit;

    return $address;
}

// Build a product update display form for admin dashboard
function buildProductUpdateDisplay($product, $colours, $sizes, $categories){
    $productUpdate = "<form method='POST' action='/zalisting/product/'><div class='swatch-row small-width-swatches'>";

    $productUpdate .= "<div class='swatch-item'><label>Change Colour</label>".buildDropDownList($colours, 'colourId', 'colour' )."</div>";
    $productUpdate .= "<div class='swatch-item'><label>Change Size</label>".buildDropDownList($sizes, 'sizeId', 'sizeValue' )."</div>";
    $productUpdate .= "<div class='swatch-item'><label>Change Category</label>".buildDropDownList($categories, 'categoryId', 'categoryName' )."</div></div>";
    $productUpdate .= "<label>Quantity</label><input type='number' name='amount' value='$product[amount]' />";

    $productUpdate .= "<input type='submit' class='button' value='Submit' />";

    $productUpdate .= "<input type='hidden' name='action' value='update-product' />";
    $productUpdate .= "<input type='hidden' name='product_entryId' value='$product[product_entryId]' />";

    $productUpdate .= "</form>";

   return $productUpdate;
}

// Build a product create display form for admin dashboard
function buildProductCreateForm($categories, $colours, $sizes){

    $productCreate = "<form class='checkboxed' method='POST' action='/zalisting/products/index.php' ><div class='row-form-content'>";



    $productCreate .= "<div class='column-form-input'><label>Product Name</label> <input type='text' name='productName' />";

    $productCreate .= "<label>Short Description</label> <textarea name='productShortDescr' rows='3' ></textarea>";

    $productCreate .= "<label>Long Description</label> <textarea name='productDescription' rows='5' ></textarea>";

    $productCreate .= "</div><div class='column-form-fieldsets'><fieldset><legend>Add a Category</legend>";

    foreach($categories as $category){// Get the category for the product
        $productCreate .= "<label class='longChoice' ><input type='radio' class='categoryId' name='categoryId' value='".$category['categoryId']."' /><span>$category[categoryName]</span></label>";
    }

    $productCreate .= "</fieldset>";

    $productCreate .= "<fieldset><legend>Add Sizes</legend>";

    foreach($sizes as $size){  // Create an array that will hold all the sizes chosen by the user
        $productCreate .= "<label class='longChoice' ><input type='checkbox' name='sizeIds[]' value='".$size['sizeId']."' /><span>$size[sizeValue]</span></label>";
    }

    $productCreate .= "</fieldset>";


    $productCreate .= "<fieldset><legend>Add Colours</legend>";

    foreach($colours as $colour){// Create an array that will hold all the colours chosen by the user
        $productCreate .= "<label class='longChoice' ><input type='checkbox' name='colourIds[]' value='$colour[colourId]' /><span>$colour[colour]</span></label>";
    }

    $productCreate .= "</fieldset></div></div>";

    $productCreate .= "<input type='hidden' name='action' value='core' />";

    $productCreate .= "<input type='submit' class='button' value='Next' />";

    $productCreate .= "</form>";

   return $productCreate;
}


// Create a dropdown list for the size variations form
function buildDropDownList($array, $id, $name){

    $placeholder = '';
    if($name == 'sizeValue'){ 
        $placeholder = 'size';
    }    
    else if($name == 'categoryName'){ 
        $placeholder = 'category';
    }else{
        $placeholder = $name; }

    // Build a navigation bar using the $classifications array
    $DropDownList = "<input list='$id' name='".$name."[]' placeholder='$placeholder' />";
    $DropDownList .= "<datalist id='$id'>";
    foreach ($array as $item) {
        //var_dump($item); exit;
    $DropDownList .= "<option value='$item[$name]' ></option>";
    }
    $DropDownList .= '</datalist>';

    return $DropDownList;

}

// Build the inner portion of the variation form
function buildCreateVariationFormRows($colours, $sizes){

    //var_dump($colours); exit;

    $productCreate = "<div class='swatch-row'>";

    $productCreate .= "<label>Choose Colour".buildDropDownList($colours, 'colourId', 'colour')."</label>";

    $productCreate .= "<label>Choose Size".buildDropDownList($sizes, 'sizeId', 'sizeValue')."</label>";

    $productCreate .= "<label>Enter Price<input type='number' name='price[]' placeholder='Price' /></label>";

    $productCreate .= "<label>Enter SKU<input type='text' name='sku[]' placeholder='sku code' /></label>";

    $productCreate .= "<label>Enter Quantity<input type='number' name='qty[]' placeholder='number of items' /></label></div>";

   return $productCreate;
}

// Build the form for uploading product images
function buildImageUploadForm($productSelect){

    $imageUploadForm = "<form class='db-entry-form form-image-upload' action='/zalisting/upload/' method='post' enctype='multipart/form-data'>";
    $imageUploadForm .= "<label for='product_entryId'>Products</label>";

    if(isset($productSelect)){ 
        $imageUploadForm .= $productSelect;
    }

    $imageUploadForm .= "<label class='radio'>Is this the main image for the product?</label>";

    $imageUploadForm .= "<div class='pImage-container'>";
    $imageUploadForm .= "<label for='priYes' class='pImage'>Yes</label><input type='radio' name='imagePrimary' id='priYes' value='1' />";
    $imageUploadForm .= "</div>";

    $imageUploadForm .= "<div class='pImage-container'>";
    $imageUploadForm .= "<label for='priNo' class='pImage'>No</label><input type='radio' name='imagePrimary' id='priNo'  checked value='0' />";
    $imageUploadForm .= "</div>";

    $imageUploadForm .= "<label>Upload Image:</label>";
    $imageUploadForm .= "<input type='file' name='file1'>";
    $imageUploadForm .= "<input type='submit' class='button' value='Upload'>";
    $imageUploadForm .= "<input type='hidden' name='action' value='upload'>";
    $imageUploadForm .= "</form>";

    return $imageUploadForm;

}


// Build the form for uploading product images
function buildProductImageUploadForm($product){

    $imageUploadForm = "<form class='db-entry-form form-image-upload' action='' method='post' enctype='multipart/form-data'>";
    $imageUploadForm .= "<label for='product_entryId'>$product[colour]: Primary Image</label>";
    $imageUploadForm .= "<input type='hidden' value='$product[product_entryId]' name='product_entryId' />";
    $imageUploadForm .= "<input type='hidden' name='imagePrimary' id='priYes' value='1' />";
    $imageUploadForm .= "<label>Upload Image:</label>";
    $imageUploadForm .= "<input type='file' name='file' >";
    $imageUploadForm .= "<input type='submit' class='button' value='Upload'>";
    $imageUploadForm .= "<input type='hidden' name='action' value='upload'>";
    $imageUploadForm .= "</form>";

    return $imageUploadForm;

}

// Build the form for uploading product images
function buildSecondaryImageUploadForm($product){

    $imageUploadForm = "<form class='db-entry-form form-image-upload' action='' method='post' enctype='multipart/form-data'>";
    $imageUploadForm .= "<label for='product_entryId'>$product[colour]: Galarry Images</label>";
    $imageUploadForm .= "<input type='hidden' value='$product[product_entryId]' name='product_entryId' />";
    $imageUploadForm .= "<input type='hidden' name='imagePrimary' id='priNo' value='0' />";
    $imageUploadForm .= "<label>Upload Images:</label>";
    $imageUploadForm .= "<input type='file' name='file' multiple />";
    $imageUploadForm .= "<input type='submit' class='button' value='Upload'>";
    $imageUploadForm .= "<input type='hidden' name='action' value='upload'>";
    $imageUploadForm .= "</form>";

    return $imageUploadForm;

}


// Build product swatches display for product details view
function buildProductSwatchesDisplay($products, $swatch){

    if($swatch == 'sizeValue'){
        $label = 'size';
        $swatchClass = '';
    }else{
        $label = $swatch;
        $swatchClass = $swatch;
    }

    $swatchDisplay = "<label class='swatch-label'>$label: <strong id='label-$label'></strong></label><div class='swatch-container'>";

    foreach($products as $product){

        // When substring:$product[$swatch] is not found in the string: $swatchString, execute block
        if(!strpos($swatchDisplay, ' '.$product[$swatch].' ') && $product[$swatch]!='N/A'){ 
            
            if($label == 'size'){

                $swatchDisplay .= "<textarea class='swatch-single-item $label' readonly name='$product[$swatch]' > $product[$swatch] </textarea>"; //spaces help avoid reding XS from XXS or S from XS 

            }else if($label == $swatch){

                $swatchDisplay .= "<textarea class='swatch-single-item $swatchClass' name='$product[$swatch]' > $product[$swatch] </textarea>"; //spaces help avoid reding XS from XXS or S from XS 

            }
        }
    }

    $swatchDisplay .= "</div>";

    //var_dump($swatchDisplay); exit;

    return $swatchDisplay;

}

// Build a product display card for shop views
function buildproductDisplay($product, $hidden, $saleItems){

    if(isset($product['imagePath'])){
        $path = $product['imagePath'];
    }else{
        $path = '/zalisting/images/no-image';
        
    }


    // if the is not product in sale table
    if(!empty($saleItems)){


        foreach($saleItems as $saleItem){

            if($product['product_entryId'] == $saleItem['product_entryId']){ // if there is a product in the sale table and it is the product urrently being accessed
        
                $dv  = "<div  class='product'><a href='/zalisting/shop?action=product&productId=$product[productId]&product_entryId=$product[product_entryId]&colour=$product[colour]' ><div id='sale$product[product_entryId]' class='$hidden sale-circle'>sale</div><img class='sale' src='$path' alt='".$product['productName']."' /></a>";
                $dv .= "<a href='/zalisting/shop?action=product&productId=$product[productId]&product_entryId=$product[product_entryId]&colour=$product[colour]' class='productName-link'><h4 class='productName'>$product[productName]</h4></a>";
                $dv .= "<p  class='productCategory'>$product[categoryName]</p>";
                $dv .= "<div class='sale-prices-container'><h4 class='productPrice strike-through' >R$product[price]</h4><h4 class='productPrice' >R$saleItem[salePrice]</h4></div></div>";

            }else{
        
                $dv  = "<div  class='product'><a href='/zalisting/shop?action=product&productId=$product[productId]&product_entryId=$product[product_entryId]&colour=$product[colour]' ><div id='sale$product[product_entryId]' class='hidden sale-circle'>sale</div><img  src='$path' alt='".$product['productName']."' /></a>";
                $dv .= "<a href='/zalisting/shop?action=product&productId=$product[productId]&product_entryId=$product[product_entryId]&colour=$product[colour]' class='productName-link'><h4 class='productName'>$product[productName]</h4></a>";
                $dv .= "<p  class='productCategory'>$product[categoryName]</p>";
                $dv .= "<div class='sale-prices-container'><h4 class='productPrice' >R$product[price]</h4><h4 class='hidden productPrice' >R$product[price]</h4></div></div>";

            }
        }

        return $dv;


    }else{ // if there is a product in the sale table and it is the product urrently being accessed

        $dv  = "<div  class='product'><a href='/zalisting/shop?action=product&productId=$product[productId]&product_entryId=$product[product_entryId]&colour=$product[colour]' ><div id='sale$product[product_entryId]' class='$hidden sale-circle'>sale</div><img src='$path' alt='".$product['productName']."' /></a>";
        $dv .= "<a href='/zalisting/shop?action=product&productId=$product[productId]&product_entryId=$product[product_entryId]&colour=$product[colour]' class='productName-link'><h4 class='productName'>$product[productName]</h4></a>";
        $dv .= "<p  class='productCategory'>$product[categoryName]</p>";

        $dv .= "<div class='sale-prices-container'><h4 class='productPrice strike-through' >R$product[price]</h4><h4 class='$hidden productPrice' >R$product[price]</h4></div></div>";
        
        return $dv;

    }
}

// Build a product block
function buildproductsDisplay($products, $offset, $lim, $productsQty, $hidden, $saleItems){

    // The page number 
    $pageNum = ($offset+$lim)/$lim;

    // get the total amount of pages to display all products
    $possiblePages = ceil($productsQty/$lim); 

    $dv  ="";

    if(isset( $_SESSION['sizeFilter']) || isset( $_SESSION['categoryFilter'])  || isset( $_SESSION['colourFilter']) || (isset( $_SESSION['minPriceFilter'])  && isset( $_SESSION['maxPriceFilter']))){

        $dv .= "<div class='seperator'>&nbsp;</div>";

        $dv .="<div class='shop-products-filtersOrder'>";

        $dv .="<div class='shop-products-filters'>";

        if(isset( $_SESSION['sizeFilter'])){

            $dv .= "<div class='filter'> Size: <div class='filter-value'> $_SESSION[sizeFilter] </div><a href='/zalisting/sidebar/?filter=deleteSizeFilter'><i class='fa fa-times'></i></a></div>";

        }
        if(isset( $_SESSION['colourFilter'])){

            $dv .= "<div class='filter'> Colour: <div class='filter-value'> $_SESSION[colourFilter]</div> <a href='/zalisting/sidebar/?filter=deleteColourFilter'><i class='fa fa-times'></i></a></div>";

        }        
        if(isset( $_SESSION['categoryFilter'])){

            $dv .= "<div class='filter'> Category: <div class='filter-value'> $_SESSION[categoryFilter] </div><a href='/zalisting/sidebar/?filter=deleteCategoryFilter'><i class='fa fa-times'></i></a></div>";

        }
        if(isset( $_SESSION['minPriceFilter']) && isset( $_SESSION['maxPriceFilter'])){

            $dv .= "<div class='filter'> Price Range: <div class='filter-value'> $_SESSION[minPriceFilter] - $_SESSION[maxPriceFilter] </div><a href='/zalisting/sidebar/?filter=deletePriceFilter'><i class='fa fa-times'></i></a></div>";

        }

        $dv .="</div>"; // Filters

        $dv .="<div class='shop-products-orderby'>";

        $dv .="</div>"; // orderBy

        $dv .="</div>"; // orderBy and Filters

        $dv .= "<div class='seperator'>&nbsp;</div>";

    }

    $dv .="<div class='shop-products'>";

    if(isset($products)){
                        
        foreach($products as $product){

            $dv .= buildproductDisplay($product, $hidden, $saleItems);

        }
    }

    $noborderPaginationP = '';
    $p = '&#8592; Previous';
    $prevLink = "/zalisting/shop/?action=prev&offset=$offset";

    $n = 'Next &#8594;';
    $noborderPaginationN = '';
    $nextLink = "/zalisting/shop/?action=next&offset=$offset";


    if($pageNum == $possiblePages){

        $noborderPaginationN = 'no-border';
        $n = '';
        $nextLink = "#";


    }else if($pageNum == 1){

        $noborderPaginationP = 'no-border';
        $p = '';
        $prevLink = "#";

    }

    $dv .="</div>";

    $dv .= "<div class='pagination-container'> <a href='$prevLink' class='pagination $noborderPaginationP prev'>$p </a>";

    if($pageNum >= 3){

        $dv .= "<a href='/zalisting/shop/?action=prev&offset=$lim' class='pagination pagination-number'> 1 </a>";
        $dv .= "<h2>...&nbsp</h2>";

    }

    for($i = $pageNum; $i < $pageNum+4; $i++){

        $focus = '';

        $numOffset = (($i+1)*$lim)-$lim;

        //echo $possiblePages; exit;

        if($pageNum == $i){

            $focus = 'active-pagination';   

        }
        
        if($i <= $possiblePages){

            $dv .= "<a href='/zalisting/shop/?action=prev&offset=$numOffset' class='pagination pagination-number $focus'> $i </a>";

        }
    }

    if($possiblePages > $pageNum){

        $dv .= "<h2>... &nbsp</h2>";

    }

    $dv .= "<a href='$nextLink' class='pagination $noborderPaginationN next'> $n </a> </div>";

return $dv;

}

// build a shop side bar display
function buildShopSidebarCategory($categories){

    // category section
    $sidebar  = "<h5 class='filter-titles'>Filter by Categories</h5>";
    $sidebar .= "<div class='seperator'>&nbsp;</div>";
    $sidebar .= "<form class='sidebar-section category-form' action='/zalisting/sidebar'>";

    foreach ($categories as $category) {

        $sidebar .= "<label for='$category[categoryName]'><input type='radio' name='category' class='radioCategories' id='$category[categoryName]' value='$category[categoryName]' />$category[categoryName]</label>";

    }
    $sidebar .= "<input type='hidden' name='filter' value='category-filter' >";
    $sidebar .= "</form>";    


    return $sidebar;

}

// build a shop side bar display
function buildShopSidebarPrice($minPrice, $maxPrice){

    $sidebar = '';
    // price section
    $sidebar .= "<h5 class='filter-titles price'>Filter by Price</h5>";
    $sidebar .= "<div class='seperator'>&nbsp;</div>";
    $sidebar .= "<form class='sidebar-section' action='/zalisting/sidebar'>";
    $sidebar .= "<label> min:<input type='number' name='minPrice' value='$minPrice' min=0 class='sidebar-price validity' /></label>";
    $sidebar .= "<label> max:<input type='number' name='maxPrice' value='$maxPrice' min=0 class='sidebar-price validity' /></label>";
    $sidebar .= "<input type='submit' value='filter'  class='button'>";
    $sidebar .= "<input type='hidden' name='filter' value='price-filter' >";
    $sidebar .= "</form>";

    return $sidebar;

}

function buildShopSidebarColour($products, $colour){

    // colour section
    $sidebar  = "<h5 class='filter-titles'>Filter by Colour</h5>";
    $sidebar .= "<div class='seperator'>&nbsp;</div>";
    $sidebar .= "<form id='colourform' class='sidebar-section' action='/zalisting/sidebar'>";
    $sidebar .= buildProductSwatchesDisplay($products, $colour);
    $sidebar .= "<input type='hidden' name='colour' value=''>";
    $sidebar .= "<input type='hidden' name='filter' value='colour-filter' >";
    $sidebar .= "</form>";

    return $sidebar;

}

function buildShopSidebarSize($products, $size){

    // colour section
    $sidebar  = "<h5 class='filter-titles'>Filter by Size</h5>";
    $sidebar .= "<div class='seperator'>&nbsp;</div>";
    $sidebar .= "<form id='sizeform' class='sidebar-section' action='/zalisting/sidebar'>";
    $sidebar .= buildProductSwatchesDisplay($products, $size);
    $sidebar .= "<input type='hidden' name='size' value=''>";
    $sidebar .= "<input type='hidden' name='filter' value='size-filter' >";
    $sidebar .= "</form>";

    return $sidebar;

}
/*

    // size section
    $sidebar .= "<div class='seperator'>&nbsp;</div>";
    $sidebar .= "<h5 class='filter-titles'>Filter by Size</h5>";
    $sidebar .= buildProductSwatchesDisplay($products, $sizes);

    return $sidebar;
}*/


/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {

    // split image name at the period and add string parts into array $i.
    $i = strrpos($image, '.');

    // assign first array element to $image_name and leave only the second item remaining in the array
    $image_name = substr($image, 0, $i);

    // assign remaining substring in array $i to $ext
    $ext = substr($image, $i);

    // Create a new string and assign it to $image
    $image = $image_name . '-tn' . $ext;

    // return the thumbnail image name
    return $image;
   }

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-library">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img class='library-images' src='$image[imagePath]' title='image on zalisting.com' alt=' $image[imageName] image on zalisting.com'>";
     $id .= "<p><a class='media-delete-button button' href='/zalisting/upload?action=delete&imageId=$image[imageId]&filename=$image[imageName]' title='Delete the image'>Delete</a></p>";
     $id .= '</li>';
   }
    $id .= '</ul>';
    return $id;
   }

// Build the product select list
function buildProductSelect($products) {
    $prodList = '<select name="product_entryId" id="product_entryId">';
    $prodList .= "<option>Choose a Product</option>";
    foreach ($products as $product) {
     $prodList .= "<option value='$product[product_entryId]'>$product[productName] in $product[colour]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    
    if (isset($_FILES[$name])) {
        // Gets the actual file name- e.g: example.png, example.jpg, example.gif
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }

        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];

        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;

        //echo $filename; exit;

        // Moves the file to the target folder : This is a built-in function
        // $target is the file path ending with the file name. 
        move_uploaded_file($source, $target);

        // Send file for further processing
        processImage($image_dir_path, $filename);

        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        
        // Returns the path where the file is stored
        return $filepath;
    }

   }

   // Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFiles($name, $i) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    
    if (isset($_FILES[$name])) {
        // Gets the actual file name- e.g: example.png, example.jpg, example.gif
        $filename = $_FILES[$name]['name'][$i];
        if (empty($filename)) {
            return;
        }

        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'][$i];

        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;

        //echo $filename; exit;

        // Moves the file to the target folder : This is a built-in function
        // $target is the file path ending with the file name. 
        move_uploaded_file($source, $target);

        // Send file for further processing
        processImage($image_dir_path, $filename);

        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        
        // Returns the path where the file is stored
        return $filepath;
    }

   }

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
   }

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type: built in function returns array with size, type, and dimensions
    $image_info = getimagesize($old_image_path);

    // 3rd element of the getimagesize returned array is the type represented by int value but equal to:
    // IMAGETYPE_JPEG = 2 / IMAGETYPE_GIF = 1 / IMAGETYPE_PNG = 3
    $image_type = $image_info[2];
   
    // Set up the function names for built in functions
    switch ($image_type) {
    case IMAGETYPE_JPEG:
     $image_from_file = 'imagecreatefromjpeg';
     $image_to_file = 'imagejpeg';
    break;
    case IMAGETYPE_GIF:
     $image_from_file = 'imagecreatefromgif';
     $image_to_file = 'imagegif';
    break;
    case IMAGETYPE_PNG:
     $image_from_file = 'imagecreatefrompng';
     $image_to_file = 'imagepng';
    break;
    default:
     return;
   } // ends the swith
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
        if($width_ratio === $height_ratio){

            // Calculate height and width for the new image
            $ratio = max($width_ratio, $height_ratio);
            $new_height = round($old_height / $ratio);
            $new_width = round($old_width / $ratio);
            
        }else{
            
            // Calculate height and width for the new image
            $new_height = $max_height;
            $new_width = $max_width;
            
        }

   
     // Create the new image
     $new_image = imagecreatetruecolor($new_width, $new_height);
   
     // Set transparency according to image type
     if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
     }
   
     if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
     }
   
     // Copy old image to new image - this resizes the image
     $new_x = 0;
     $new_y = 0;
     $old_x = 0;
     $old_y = 0;
     imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
   
     // Write the new image to a new file
     $image_to_file($new_image, $new_image_path);

     // Free any memory associated with the new image
     imagedestroy($new_image);
     } else {
     // Write the old image to a new file
     $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
   } // ends resizeImage function

// Build customer reviews for admin and vehicle-details views
// Only client's reviews appear in admin view while all car's
// reviews will appear in vehicle-details view
   function customerReviews($reviews){

       $loggedinClientId = 0;

       if(isset($_SESSION['clientData'])){
            $loggedinClientId= $_SESSION['clientData']['clientId'];
       }

    // Design reviews on a table to aid alignment and styling.
    $cutomerReviews = "<table class='review-table'>";
    foreach($reviews as $review){

    
        $cutomerReviews .= "<tr><td class='reviewText' >$review[reviewText]</td></tr>";

        // when a user is logged in, they will have the ability to update or delete 
        // reviews using one of the links below respectively
        // $_SESSION['clientData']['clientId'] is the clientId of a logged in user.
        // When it's not the same as the clientId of a certain review, it will
        // be a review by another user. They wont have ability to update or delete.
        if(isset($review['clientId']) && $review['clientId']!=$loggedinClientId){
            // First letter of the first name obtained using index zero.
            $cutomerReviews .= "<tr><td class='reviewerName' >Posted by: ".substr($review['clientFirstname'],0,1)."".$review['clientLastname']."</td></tr>";
            // Date must not include time for my review display.
            $cutomerReviews .= "<tr><td class='reviewDate' >Date posted: ".date('F j, Y', strtotime($review['reviewDate']))."</td></tr>";

        }
        else if(isset($_SESSION['clientData'])){
            $cutomerReviews .= "<tr><td class='reviewerName'>Posted by: ".substr($_SESSION['clientData']['clientFirstname'],0,1)."".$_SESSION['clientData']['clientLastname']."</td></tr>";
            $cutomerReviews .= "<tr><td class='reviewDate' >Date posted: ".date('F j, Y', strtotime($review['reviewDate']))."</td></tr>";
            $cutomerReviews .= "<tr><td><a href='/zalisting/reviews?action=getUpdateReview&reviewId=$review[reviewId]' title='Update Review' >Update</a>  <a href='/zalisting/reviews?action=deleteRequest&clientId=".$_SESSION['clientData']['clientId']."' title='Delete Review' >Delete</a></td></tr>";
        }

        $cutomerReviews .= "<tr><td> <hr/> </td></tr>";

    }
    $cutomerReviews .= "</table>";

    return $cutomerReviews;

   }

   // remove dupplication in cart by compounding the quantities of the same product entry
   function sumCartQuantities($duplicatedCartDetails){

    for($i = 0; $i < count($duplicatedCartDetails); $i++){
        

        for($j = 0; $j < count($duplicatedCartDetails); $j++){

            if($duplicatedCartDetails[$j]['product_entryId'] == $duplicatedCartDetails[$i]['product_entryId'] && $i!=$j){

                // sum the quantity
                $duplicatedCartDetails[$i]['cart_item_qty'] += $duplicatedCartDetails[$j]['cart_item_qty'];

                //remove the duplicate from the iteration by changing its entry id, but leave space taken
                $duplicatedCartDetails[$j]['product_entryId'] = 'Counted!'.$j;

            }

        }
    }


    for($i = 0; $i <= count($duplicatedCartDetails)+1; $i++){

        if(array_key_exists ( $i , $duplicatedCartDetails)){
        
            if($duplicatedCartDetails[$i]['product_entryId'] == 'Counted!'.$i){

                //remove duplicate completely
                unset($duplicatedCartDetails[$i]);
            }

        }
    }

    return $duplicatedCartDetails;

   }


/**
 * @param array $data
 * @param null $passPhrase
 * @return string
 */
function generateSignature($data, $passPhrase = null) {
    // Create parameter string
    $pfOutput = '';
    foreach( $data as $key => $val ) {
        if($val !== '') {
            $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
        }
    }
    // Remove last ampersand
    $getString = substr( $pfOutput, 0, -1 );
    if( $passPhrase !== null ) {
        $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
    }
    return md5( $getString );
} 