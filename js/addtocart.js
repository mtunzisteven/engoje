let addToCart = document.querySelector('#add-to-cart-button'); 

let cartQty = document.querySelector('#add-to-cart-qty');

let addToCartRespose = document.querySelector('#add-to-cart-response');



addToCart.addEventListener('click', function(){

    let data = new FormData();                                // create a new formData object to send data aysnchronously to the controller

    data.append('product_entryId', product_entryId.value);  // add productId for the item we are looking at, not the product_entryId
    data.append('qty', cartQty.value);                      // add the colour for the item as well
    data.append('action', 'add-to-cart');        // add the action that will be used by the case selection in the controller

    // Send data
    var request = new XMLHttpRequest();
    request.open("POST", "http://localhost/zalisting/shop/index.php", false);
    request.onload = function() {
        if (request.status == 200) {

            addToCartRespose.innerHTML = this.responseText;

            //alert(assocArr['imagePath']);

        } else {

            addToCartRespose.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";

        }
    };

    request.send(data);    
}, false);


/*if(addToCartRespose.value != ''){

    document.body.addEventListener('click', function(){

        addToCartRespose.innerHTML = '';

    }, false);

}*/