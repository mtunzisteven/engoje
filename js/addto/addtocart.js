import {jsonRequest} from "./jsonrequests.js";

export function plisten(addToCart, url, product_entryId, cartQty, cartCount, mcartCount, addToCartRespose, cartTotal, response){

    addToCart.addEventListener('click', function(){

        if(cartQty.value > 0){
            
            let addtocartData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
    
            addtocartData.append('product_entryId', product_entryId.value);  // add the product_entryId to data
            addtocartData.append('cart_item_qty', cartQty.value);                      // add the quantity of products to the data
            addtocartData.append('action', 'add-to-cart');                   // add the action that will be used by the case selection in the controller
            
            // Send data
            // Use fetch request from module.
            jsonRequest(url, addtocartData, cartCount, mcartCount, cartTotal, addToCartRespose, response);
    
        }
        
        else if(cartQty.value < 1){
    
            addToCartRespose.innerHTML = "<p class='adding-alert'>Error: Cart amount less than 1.</p>";
    
        }
    
    }, false);
}
