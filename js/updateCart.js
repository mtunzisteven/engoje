
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


    let url = "http://localhost/zalisting/cart/index.php";

    fetch(url, {
        method: 'POST',
        body: cartUpdateData
    })
    .then(response=>{
        if(response.ok){
            return response;
        }
        throw Error(response.statusText);
    })
    .then(response=>response.text())
    .then(text=> {
        
        alert(text);

        cartCount.innerHTML = text;
        mcartCount.innerHTML = text;
    })



}, false);