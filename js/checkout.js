// this is the java script code for the checkout page

////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                       New Address   form                                           //
////////////////////////////////////////////////////////////////////////////////////////////////////////

let newAddressButton = document.querySelector('#new-address');
let hiddenFormContainer = document.querySelector('#HidenformC');
let newAddress = document.querySelector('#newAddress');
let newaddressform = document.querySelector('.new-address-form');
let cancel = document.querySelector('#cancelNewAddress');


// open new address form
newAddressButton.addEventListener('click', function(){

    hiddenFormContainer.setAttribute('class', 'address-form-container');

}, false)

// close and submit new address form
newAddress.addEventListener('click', function(){

    hiddenFormContainer.setAttribute('class', 'hidden');

    newaddressform.submit();

}, false)

// close new address form

cancel.addEventListener('click', function(){

    hiddenFormContainer.setAttribute('class', 'hidden');

}, false)


////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                        Payfatast   form                                            //
////////////////////////////////////////////////////////////////////////////////////////////////////////

let payfastForm = document.querySelector('#payfastForm');
let payfastButton = document.querySelector('#payfastButton');
let popupCard = document.querySelector('#popupCard');
let popupCardtext = document.querySelector('#popupCardtext');
let popupCardNo = document.querySelector('#popupCardNo');
let popupCardYes = document.querySelector('#popupCardYes');
let cancelPayfastConfirm = document.querySelector('#cancelPayfastConfirm');
let shippingFee = document.querySelector('#shipping-fee').value;

// process order and submit payfast form
payfastButton.addEventListener('click', function(){

    let url = "/zalisting/checkout/";

    let orderData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
    
    orderData.append('orderTotal', payfastForm['amount'].value);             // add the payment total to data
    orderData.append('action', 'paynow');                   // add the action that will be used by the case selection in the controller


    fetch(url, {
        method: 'POST',
        body: orderData
    })
    .then(response=>{
        if(response.ok){
            return response;
        }
        throw Error(response.statusText);
    })
    .then(response=>response.json())
    .then(data=>{

        if(data['message'] == 1){

            payfastForm.submit();

        }else{

            popupCard.setAttribute('class', 'address-form-container');
            popupCardtext.innerHTML = data['message'];

            // close and submit new address form
            popupCardYes.addEventListener('click', function(){

                popupCard.setAttribute('class', 'hidden');
                
                // update cart total to pay on form
                payfastForm['amount'].value = data['orderTotal'];

                // make payment if there's anything to pay for.
                if(payfastForm['amount'].value != shippingFee){

                    // submit form
                    payfastForm.submit();

                }else{

                    // close pop up
                    popupCard.setAttribute('class', 'hidden');
                    
                }


            }, false)

            let reverseData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
            reverseData.append('action', 'reverse-qty-deduction');                   // add the action that will be used by the case selection in the controller


            // close new form
            popupCardNo.addEventListener('click', function(){

                popupCard.setAttribute('class', 'hidden');

                fetch(url, {
                    method: 'POST',
                    body: reverseData
                })
                .then(response=>{
                    if(response.ok){
                        return response;
                    }
                    throw Error(response.statusText);
                })

            }, false)

            // close new address form
            cancelPayfastConfirm.addEventListener('click', function(){

                popupCard.setAttribute('class', 'hidden');

                fetch(url, {
                    method: 'POST',
                    body: reverseData
                })
                .then(response=>{
                    if(response.ok){
                        return response;
                    }
                    throw Error(response.statusText);
                })

            }, false)

        }
    }) 
    .catch(error=> console.log(error))
    
}, false)