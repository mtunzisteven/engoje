import {jsonRequest} from "./jsonrequests.js";

addToWishlist.addEventListener('click', function(){

    let addtowishlistData = new FormData();                              // create a new formData object to send data aysnchronously to the controller

    addtowishlistData.append('product_entryId', product_entryId.value);  // add the product_entryId to data
    addtowishlistData.append('action', 'add-to-wishlist');                   // add the action that will be used by the case selection in the controller


    let url = "http://localhost/zalisting/wishlist/index.php";

    // Send data
    // Use fetch request from module.
    jsonRequest(url, addtowishlistData, wishlistCount, mwishlistCount, 'wishlistTotal', addToCartRespose, 'add-to-wishlist-response');

}, false);