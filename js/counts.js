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
var oneUpm = document.querySelectorAll('.oneUpm');
var oneDownm = document.querySelectorAll('.oneDownm');
var cartItemQty = document.querySelectorAll('.cart-item-qty');
var cartItemQtym = document.querySelectorAll('.cart-item-qtym');

let countMQueries = window.matchMedia("(min-width: 1080px)")
myFunction(countMQueries) // Call listener function at run time
countMQueries.addEventListener("change",myFunction) // Attach listener function on state changes


function myFunction(mediaQuery) {
    if (mediaQuery.matches) { // If media query matches
      
        for(let i = 0; i < cartItemQty.length; i++){

            // make sure the qty is the same as previous media query
            cartItemQty[i].value = cartItemQtym[i].value; 

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
        
    } else {

        for(let i = 0; i < cartItemQtym.length; i++){

            // make sure the qty is the same as previous media query
            cartItemQtym[i].value = cartItemQty[i].value; 

            oneDownm[i].addEventListener('click', function(event){
        
                
                if(parseInt(cartItemQtym[i].value) > 0){
                    // only carry out the following operation when the value is greater than zero
        
                    cartItemQtym[i].value = parseInt(cartItemQtym[i].value) - 1;

                }
        
            }, false);
        
                
            oneUpm[i].addEventListener('click', function(event){
            
                cartItemQtym[i].value = parseInt(cartItemQtym[i].value) + 1;
        
            }, false);
        }

    }
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