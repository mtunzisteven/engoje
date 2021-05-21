var wishlistCount = document.querySelector('#wishlist-count');
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