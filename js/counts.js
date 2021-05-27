// ----------------------------------------------------------
//                 Cart Icon count updating                 |
//-----------------------------------------------------------
var cartCount = document.querySelector('#cart-count');

let data = new FormData();                              // create a new formData object to send data aysnchronously to the controller
data.append('action', 'cart-count');                    // add the action that will be used by the case selection in the controller

// Send data
var request = new XMLHttpRequest();
request.open("POST", "http://localhost/zalisting/shop/index.php", false);
request.onload = function() {
    if (request.status == 200) {

        cartCount.innerHTML = this.responseText;
        //alert(this.responseText);

    } else {

        addToCartRespose.innerHTML = "";

    }
};

request.send(data); 
 

// ----------------------------------------------------------
//                 Cart page count updating                 |
//-----------------------------------------------------------
var oneUp = document.querySelectorAll('.oneUp');
var oneDown = document.querySelectorAll('.oneDown');
var cartItemQty = document.querySelectorAll('.cart-item-qty');

for(let i = 0; i < cartItemQty.length; i++){


    oneDown[i].addEventListener('click', function(event){

        
        if(parseInt(cartItemQty[i].value) > 0){
            // only carry out the following operation when the value is greater than zero

            cartItemQty[i].value = parseInt(cartItemQty[i].value) - 1;

        }

    }, false);

        
    oneUp[i].addEventListener('click', function(event){
    
        cartItemQty[i].value = parseInt(cartItemQty[i].value) + 1;

    }, false);
}


// ----------------------------------------------------------
//               Wishlist Icon count updating                |
//-----------------------------------------------------------
var wishlistCount = document.querySelector('#wishlist-count');

let data2 = new FormData();                              // create a new formData object to send data aysnchronously to the controller
data2.append('action', 'wishlist-count');                    // add the action that will be used by the case selection in the controller

// Send data
var request = new XMLHttpRequest();
request.open("POST", "http://localhost/zalisting/shop/index.php", false);
request.onload = function() {
    if (request.status == 200) {

        wishlistCount.innerHTML = this.responseText;
        //alert(this.responseText);

    } else {

        addToCartRespose.innerHTML = "";

    }
};

request.send(data2); 