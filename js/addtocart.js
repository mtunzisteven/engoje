// declare the variables needed to add items asynchronously to theb cart
// we don't need to declare product_entryId because it is defined in the 
// swatches.js which is above this file in the html document
let addToCart = document.querySelector('#add-to-cart-button'); 
var mcartCount = document.querySelector('#mobile-cart-count');
let addToCartRespose = document.querySelector('#add-to-cart-response');
let galleryImages = document.querySelectorAll('.product-gallery-image');

addToCart.addEventListener('click', function(){

    let addtocartData = new FormData();                              // create a new formData object to send data aysnchronously to the controller

    addtocartData.append('product_entryId', product_entryId.value);  // add the product_entryId to data
    addtocartData.append('cart_item_qty', cartQty.value);                      // add the quantity of products to the data
    addtocartData.append('action', 'add-to-cart');                   // add the action that will be used by the case selection in the controller

    // Send data
    var request = new XMLHttpRequest();
    request.open("POST", "http://localhost/zalisting/cart/index.php", false);
    request.onload = function() {
        if (request.status == 200) {

            let assocArr = JSON.parse(this.responseText);
            
            cartCount.innerHTML = assocArr['cartTotal'];
            mcartCount.innerHTML = assocArr['cartTotal'];

            addToCartRespose.innerHTML = assocArr['add-to-cart-response'];


        } else {

            addToCartRespose.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";

        }
    };

    request.send(addtocartData);    

}, false);

// update main dispolay image when the gallary image is clicked
for(let j = 0; j < galleryImages.length; j++){

    galleryImages[j].addEventListener('click', function(event){

        primaryImage.setAttribute('src', event.target.getAttribute('id'));        

    }, false);

}