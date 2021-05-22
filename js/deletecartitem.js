// declare the variables needed to remove items asynchronously from the cart
let product_entryId = document.querySelectorAll('.product_entryId');
let deleteItem = document.querySelectorAll('.remove-cart-item');
let cartParent = document.querySelector('#cart');



for(let i = 0; i<deleteItem.length; i++){ // loop through them all and add the event Listener.

    deleteItem[i].addEventListener('click', function(){

        let data = new FormData();                              // create a new formData object to send data aysnchronously to the controller

        data.append('product_entryId', product_entryId[i].value);  // add the product_entryId to data
        data.append('action', 'remove-cart-item');                   // add the action that will be used by the case selection in the controller

        // Send data
        var request = new XMLHttpRequest();
        request.open("POST", "http://localhost/zalisting/shop/index.php", false);
        request.onload = function() {
            if (request.status == 200) {

                alert(this.responseText);

                document.querySelector(this.responseText)='';

            } else {

                addToCartRespose.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";

            }
        };

        request.send(data);    
    }, false);

}