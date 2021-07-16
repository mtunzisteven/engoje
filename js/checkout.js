// this is the java script code for the checkout page

////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                       New Address   form                                           //
////////////////////////////////////////////////////////////////////////////////////////////////////////

let newAddressButton = document.querySelector('#new-address');
let hiddenFormContainer = document.querySelector('#HidenformC');
let newAddress = document.querySelector('#newAddress');
let newaddressform = document.querySelector('.new-address-form');
let cancel = document.querySelector('.cancelNewAddress');


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



// process order and submit payfast form
payfastButton.addEventListener('click', function(){

    let url = "/zalisting/checkout/?action=paynow";

    let orderData = new FormData();                              // create a new formData object to send data aysnchronously to the controller
    
    orderData.append('order', payfastForm['order'].value);  // add the product_entryId to data
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
    .then(response=>response.text())
    .then(text=>{

        alert(text);

        /*countEl.innerHTML = response;
        mcountEl.innerHTML = response;

        responseEl.innerHTML = data[responseStr];*/

    }) 
    .catch(error=> console.log(error))
    
    //payfastForm.submit();

}, false)