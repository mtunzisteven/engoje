// declare the variables needed to add items asynchronously to theb cart
// we don't need to declare product_entryId because it is defined in the 
// swatches.js which is above this file in the html document
let addToCart = document.querySelector('#add-to-cart-button'); 
let cartQty = document.querySelector('#add-to-cart-qty');
let addToCartRespose = document.querySelector('#add-to-cart-response');
var cartCount = document.querySelector('#cart-count');

addToCart.addEventListener('click', function(){

    let data = new FormData();                              // create a new formData object to send data aysnchronously to the controller

    data.append('product_entryId', product_entryId.value);  // add the product_entryId to data
    data.append('cart_item_qty', cartQty.value);                      // add the quantity of products to the data
    data.append('action', 'add-to-cart');                   // add the action that will be used by the case selection in the controller

    // Send data
    var request = new XMLHttpRequest();
    request.open("POST", "http://localhost/zalisting/shop/index.php", false);
    request.onload = function() {
        if (request.status == 200) {

            //alert(this.responseText);

            let assocArr = JSON.parse(this.responseText);
            
            cartCount.innerHTML = assocArr['cartTotal'];

            addToCartRespose.innerHTML = assocArr['add-to-cart-response'];


        } else {

            addToCartRespose.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";

        }
    };

    request.send(data);    
}, false);