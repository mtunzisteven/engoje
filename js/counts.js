// ----------------------------------------------------------
//                 Cart Icon count updating                 |
//-----------------------------------------------------------
var cartCount = document.querySelector('#cart-count');
var mcartCount = document.querySelector('#mobile-cart-count');

let cartCountData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
cartCountData.append('action', 'cart-count');                    // add the action that will be used by the case selection in the controller

let curl = "http://localhost/engoje/cart/index.php";

fetch(curl, {
    method: 'POST',
    body: cartCountData
})
.then(response=>{
    if(response.ok){
        return response;
    }
    throw Error(response.statusText);
})
.then(response=>response.text())
.then(text=> {

    isNumber(cartCount, mcartCount, text);


})
 

// ----------------------------------------------------------
//                 Cart page count updating                  |
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
var mwishlistCount = document.querySelector('#mobile-wishlist-count');

let wishlistCountData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
wishlistCountData.append('action', 'wishlist-count');                    // add the action that will be used by the case selection in the controller

let wurl = "http://localhost/engoje/wishlist/index.php";

fetch(wurl, {
    method: 'POST',
    body: wishlistCountData
})
.then(response=>{
    if(response.ok){
        return response;
    }
    throw Error(response.statusText);
})
.then(response=>response.text())
.then(text=> {

    isNumber(wishlistCount, mwishlistCount, text);
})


function isNumber(mainCount, mobileCount, text){


    if(text.length <= 3){
        if(text > 9){

            mainCount.innerHTML = "9+";
            mobileCount.innerHTML = "9+";

        }else{

            mainCount.innerHTML = text;
            mobileCount.innerHTML =text;
        }

    }else{
        mainCount.innerHTML = "!";
        mobileCount.innerHTML = "!";
    }

}