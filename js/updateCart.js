
// ----------------------------------------------------------
//                Cart Items count updating                  |
//-----------------------------------------------------------
var updateCart = document.querySelector('#update-cart');
var lineTotals = document.querySelectorAll('.line-total');
var prices = document.querySelectorAll('.price');
var grandTotal = document.querySelector('#grand-total');

updateCart.addEventListener('click', function(event){
    let totalHolder = 0;

    var cartUpdateArr = [];

    for(let i = 0; i < cartItemQty.length; i++){

        cartUpdateArr.push(parseInt(cartItemQty[i].value));

        lineTotals[i].innerHTML = parseInt(cartItemQty[i].value)*parseInt(prices[i].textContent);

        totalHolder += parseInt(cartItemQty[i].value)*parseInt(prices[i].textContent);
    }

    grandTotal.innerHTML = totalHolder;


    let cartUpdateData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
    cartUpdateData.append('action', 'update-cart');                    // add the action that will be used by the case selection in the controller
    cartUpdateData.append('cartUpdateArr', cartUpdateArr);                    // add the action that will be used by the case selection in the controller


    // Send data
    var request = new XMLHttpRequest();
    request.open("POST", "http://localhost/zalisting/cart/index.php", false);
    request.onload = function() {
        if (request.status == 200) {

            //alert(this.responseText);

            cartCount.innerHTML = this.responseText;

        } 
    };

    request.send(cartUpdateData); 

}, false);