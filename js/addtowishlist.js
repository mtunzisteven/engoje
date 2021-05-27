// ----------------------------------------------------------
//                 Add to Wishlist updating                  |
//-----------------------------------------------------------
let addToWishlist = document.querySelector('#add-to-wishlist-button');

addToWishlist.addEventListener('click', function(){

    let addtowishlistData = new FormData();                              // create a new formData object to send data aysnchronously to the controller

    addtowishlistData.append('product_entryId', product_entryId.value);  // add the product_entryId to data
    addtowishlistData.append('action', 'add-to-wishlist');                   // add the action that will be used by the case selection in the controller

    // Send data
    var request = new XMLHttpRequest();
    request.open("POST", "http://localhost/zalisting/wishlist/index.php", false);
    request.onload = function() {
        if (request.status == 200) {

            //alert('send and receive worked!');

            let assocArr = JSON.parse(this.responseText);
            
            wishlistCount.innerHTML = assocArr['wishlistTotal'];

            addToCartRespose.innerHTML = assocArr['add-to-wishlist-response'];


        } else {

            addToCartRespose.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";

        }
    };

    request.send(addtowishlistData);    

}, false);