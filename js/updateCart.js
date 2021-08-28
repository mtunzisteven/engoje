
// ----------------------------------------------------------
//                Cart Items count updating                  |
//-----------------------------------------------------------
let updateCart = document.querySelector('#update-cart');
let lineTotals = document.querySelectorAll('.line-total');
let prices = document.querySelectorAll('.price');
let grandTotal = document.querySelector('#grand-total');

// cart ship + total Payment calculation vars
let grandShipTotalText = document.querySelector('#grand-ship-total');
let shipRadioOptions = document.querySelectorAll('.shippingId');

updateCart.addEventListener('click', function(event){

    const checkedRadio = [...document.querySelectorAll('.shippingId')].filter(button => button.checked).map(button => button.value);

    let totalHolder = 0;

    const cartUpdateArr = [];

    for(let i = 0; i < cartItemQty.length; i++){

        cartUpdateArr.push(parseInt(cartItemQty[i].value));

        lineTotals[i].innerHTML = parseInt(cartItemQty[i].value)*parseInt(prices[i].textContent);

        totalHolder += parseInt(cartItemQty[i].value)*parseInt(prices[i].textContent);
    }

    grandTotal.innerHTML = totalHolder;


    let cartUpdateData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
    cartUpdateData.append('action', 'update-cart');                    // add the action that will be used by the case selection in the controller
    cartUpdateData.append('cartUpdateArr', cartUpdateArr);                    // add the action that will be used by the case selection in the controller


    let url = "http://localhost/engoje/cart/index.php";

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
        
        cartCount.innerHTML = text;
        mcartCount.innerHTML = text;

        if(checkedRadio > 0){

            // get the innerText in grand total defined above and sum it with the value of the hidden input element with
            // the same shipping id as the shipping method selected. id name of the input is a combination of 'shipppingId' and the actual id.
            let total = parseInt(grandTotal.innerHTML) + parseInt(document.querySelector('#shippingId'+checkedRadio).value);

            // set the inner text axactly as it is in the html with a new total calculated above.
            grandShipTotalText.innerHTML = `<div class='strong'>Grand Total:</div> R${total}`;

        }

    })
    .catch(error => console.log(error))


}, false);

// do this for each shipping method
shipRadioOptions.forEach(shipoption => {

    // listen out for when it is clicked 
    shipoption.addEventListener('click', function(){

        // get the innerText in grand total defined above and sum it with the value of the hidden input element with
        // the same shipping id as the shipping method selected. id name of the input is a combination of 'shipppingId' and the actual id.
        let total = parseInt(grandTotal.innerHTML) + parseInt(document.querySelector('#shippingId'+shipoption.value).value);

        // set the inner text axactly as it is in the html with a new total calculated above.
        grandShipTotalText.innerHTML = `<div class='strong'>Grand Total:</div> R${total}`;

    }, false)
    
});