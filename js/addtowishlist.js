import {jsonRequest} from "./jsonrequests.js";

export function wlisten(addtowishlist, url, product_entryId, wishlistCount, mwishlistCount, addToWishlistResponse, wishlistTotal, response){

    addtowishlist.addEventListener('click', function(){

        let addtowishlistData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
    
        addtowishlistData.append('product_entryId', product_entryId.value);  // add the product_entryId to data
        addtowishlistData.append('action', 'add-to-wishlist');                   // add the action that will be used by the case selection in the controller
    
        // Send data
        // Use fetch request from module.
        jsonRequest(url, addtowishlistData, wishlistCount, mwishlistCount, wishlistTotal, addToWishlistResponse, response);
        
    }, false);
}