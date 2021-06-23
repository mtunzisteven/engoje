
//----------------variables for elements that will be bechanged by swatch selection------|
let primaryImage = document.querySelector('#single-product');//                          |
var gallery = document.querySelectorAll('.product-gallery-image');//               |
let product_entryId = document.querySelector('#product_entryId');//                      |
let productPrice = document.querySelector('#productPrice');//                            |
let colourLabel = document.querySelector('#label-colour');//                             |
let sizeLabel = document.querySelector('#label-size');//                                 |
let cartQty = document.querySelector('#add-to-cart-qty');//                              |
//---------------------------------------------------------------------------------------|
let sizeSwatches = document.querySelectorAll('.size');     // get all divs with class:size
let colourSwatches = document.querySelectorAll('.colour'); // get all divs with class:colour

//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
//                              Colour Swatches Code                                    //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

for(let i = 0; i<colourSwatches.length; i++){ // loop through them all and add the event Listener.

        let swatchColour = colourSwatches[i].getAttribute("name"); // get text area name | all swatches are textarea elements

        colourSwatches[i].style.backgroundColor = swatchColour; // apply the corresponding colour to each swatch
        colourSwatches[i].style.color = swatchColour;           // also hide the text by making it the same colour as the background

        colourSwatches[i].addEventListener('click', function(event) { // add an even listener for when any swatch is clicked.

            colourLabel.innerHTML = swatchColour; // Label on swatch

            for(let j = 0; j<colourSwatches.length; j++){             
                colourSwatches[j].style.borderColor = '#d8d5d5';      // go through each colour swatch and make sure it has the default border colour
            }

            cartQty.value = 0;                                        // return the cart amount to zero

            for(let j = 0; j<sizeSwatches.length; j++){             
                sizeSwatches[j].style.borderColor = '#d8d5d5';      // go through each size swatch and make sure it has the default border colour
            }

            document.querySelector('#label-size').innerHTML = '';   // remove the size on the size label

            event.target.style.borderColor = '#fa9595';               // change the border colour of the clicked swatch

            let data = new FormData();                                // create a new formData object to send data aysnchronously to the controller

            let productId = document.querySelector('#productId');// 
        
            data.append('productId', productId.value);  // add productId for the item we are looking at, not the product_entryId
            data.append('colour', swatchColour);        // add the colour for the item as well
            data.append('action', 'colour-swatch');        // add the action that will be used by the case selection in the controller
        
            // Send data
            var request = new XMLHttpRequest();
            request.open("POST", "http://localhost/zalisting/shop/index.php", false);
            request.onload = function() {
                if (request.status == 200) {

                    let assocArr = JSON.parse(this.responseText);

                    for(let j = 0; j < gallery.length; j++){

                        gallery[j].setAttribute('src', assocArr['galleryPaths_tn'][j]);    
                        gallery[j].setAttribute('id', assocArr['galleryPaths'][j]);            

                    }

                    primaryImage.setAttribute('src', assocArr['imagePath']);

                    product_entryId.value = assocArr['product_entryId'];

                    productPrice.innerHTML = 'R'+assocArr['price'];

                    //alert(assocArr['imagePath']);
                } else {
                    responseContainer.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";
                }
            };
        
            request.send(data);
            //event.preventDefault();
        }, false);

        // When loading the page, always auto click the first colour
        if(i == 0){
            colourSwatches[i].click();
        }
}

//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
//                                  Size Swatches Code                                  //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

for(let i = 0; i<sizeSwatches.length; i++){ // loop through them all and add the event Listener.

    let swatchSize = sizeSwatches[i].getAttribute("name"); // get text area name | all swatches are textarea elements

    sizeSwatches[i].addEventListener('click', function(event) { // add an even listener for when any swatch is clicked.

        // Convert all the sizes to textual format
        switch(swatchSize){
            case 'XXS':

                sizeLabel.innerHTML = 'extra extra small'; 

                break;

            case 'XS':

                sizeLabel.innerHTML = 'extra small'; 

                break;

            case 'S':

                sizeLabel.innerHTML = 'small'; 
    
                break;

            case 'M':

                sizeLabel.innerHTML = 'medium'; 

                break;

            case 'L':

                sizeLabel.innerHTML = 'large'; 

                break;
            case 'XXL':

                sizeLabel.innerHTML = 'extra extra large'; 

                break;

            case 'XL':

                sizeLabel.innerHTML = 'extra large'; 

                break;

            default:

                sizeLabel.innerHTML = swatchSize; 

        }

        for(let j = 0; j<sizeSwatches.length; j++){             
            sizeSwatches[j].style.borderColor = '#d8d5d5';      // go through each swatch and make sure it has the default border colour
        }

        cartQty.value = 0;                                      // return the cart amount to zero

        event.target.style.borderColor = '#fa9595';               // change the border colour of the clicked swatch

        let data = new FormData();                                // create a new formData object to send data aysnchronously to the controller

        let productId = document.querySelector('#productId');// The common product id for all product_entries

        let colour = document.querySelector('#label-colour');// The product colour label: will have the colour selected

        data.append('productId', productId.value);  // add productId for the item we are looking at, not the product_entryId
        data.append('size', swatchSize);            // add the size for the item as well
        data.append('colour', colour.textContent);  // add the colour for the item as well
        data.append('action', 'size-swatch');       // add the action that will be used by the case selection in the controller

        // Send data
        var request = new XMLHttpRequest();
        request.open("POST", "http://localhost/zalisting/shop/index.php", false);
        request.onload = function() {
            if (request.status == 200) {

                let assocArr = JSON.parse(this.responseText);           // convert json object to a js string

                product_entryId.value = assocArr['product_entryId'];    // load the product_entryId from the db

                productPrice.innerHTML = 'R'+assocArr['price'];         // load the price fro  the db

            } else {
                responseContainer.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";
            }
        };

        request.send(data);
    }, false);

    // When loading the product page, als=ways auto click the first size
    if(i == 0){
        sizeSwatches[i].click();
    }

}