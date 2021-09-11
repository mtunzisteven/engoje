
//----------------variables for elements that will be bechanged by swatch selection------|
let primaryImage = document.querySelector('#single-product');//                          |
var gallery = document.querySelectorAll('.product-gallery-image');//                     |
let product_entryId = document.querySelector('#product_entryId');//                      |
let productPrice = document.querySelector('#productPrice');//                            |
let colourLabel = document.querySelector('#label-colour');//                             |
let colorLabel_container = document.querySelector('#color-swatch-label');//                 |
let sizeLabel = document.querySelector('#label-size');//                                 |
let sizeLabel_container = document.querySelector('#size-swatch-label');//                 |
let cartQty = document.querySelector('#add-to-cart-qty');//                              |
//---------------------------------------------------------------------------------------|
let sizeSwatches = document.querySelectorAll('.size');     // get all divs with class:size
let colourSwatches = document.querySelectorAll('.colour'); // get all divs with class:colour
let colourChoice = document.querySelector('#colourChoice'); // get the colour choice from input

let url = "http://localhost/engoje/shop/index.php";

//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
//                              Colour Swatches Code                                    //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

if(colourChoice.value != "N/A"){

    colorLabel_container.classList.remove('hidden');//reveal label 


    for(let i = 0; i<colourSwatches.length; i++){ // loop through them all and add the event Listener.

    let swatchColour = colourSwatches[i].getAttribute("name"); // get text area name | all swatches are textarea elements

        colourSwatches[i].style.backgroundColor = swatchColour; // apply the corresponding colour to each swatch
        colourSwatches[i].style.color = swatchColour;           // also hide the text by making it the same colour as the background

        colourSwatches[i].addEventListener('click', function(event) { // add an even listener for when any swatch is clicked.

            colourLabel.innerHTML = swatchColour; // Label on swatch

            for(let j = 0; j<colourSwatches.length; j++){             
                colourSwatches[j].style.borderColor = '#d8d5d5';      // go through each colour swatch and make sure it has the default border colour
            }

            if(cartQty != null){cartQty.value = 0};                                        // return the cart amount to zero

            for(let j = 0; j<sizeSwatches.length; j++){             
                sizeSwatches[j].style.borderColor = '#d8d5d5';      // go through each size swatch and make sure it has the default border colour
            }

            document.querySelector('#label-size').innerHTML = '';   // remove the size on the size label

            event.target.style.borderColor = '#fa9595';               // change the border colour of the clicked swatch

            let colorData = new FormData();                                // create a new formData object to send data aysnchronously to the controller

            let productId = document.querySelector('#productId');// 
        
            colorData.append('productId', productId.value);  // add productId for the item we are looking at, not the product_entryId
            colorData.append('colour', swatchColour);        // add the colour for the item as well
            colorData.append('action', 'colour-swatch');        // add the action that will be used by the case selection in the controller

            fetch(url, {
                method: 'POST',
                body: colorData
            })
            .then(response=>{
                if(response.ok){
                    return response;
                }
                throw Error(response.statusText);
            })
            .then(response=>response.json())
            .then(data=>{
            
                for(let j = 0; j < gallery.length; j++){

                    gallery[j].setAttribute('src', data['galleryPaths_tn'][j]);    
                    gallery[j].setAttribute('id', data['galleryPaths'][j]);            

                }

                primaryImage.setAttribute('src', data['imagePath']);

                product_entryId.value = data['product_entryId'];

                productPrice.innerHTML = 'R'+data['price'];
        
            }) 
            .catch(error => console.log(error))
        
        }, false);

        // When loading the page, always auto click the respective colour
        if(swatchColour == colourChoice.getAttribute("name")){

            colourSwatches[i].click();
        }
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

        // size label gets value from size element's data sttribute 
        sizeLabel.innerHTML = sizeSwatches[i].dataset.size;

        for(let j = 0; j<sizeSwatches.length; j++){             
            sizeSwatches[j].style.borderColor = '#d8d5d5';      // go through each swatch and make sure it has the default border colour
        }

        if(cartQty != null){cartQty.value = 0};                                      // return the cart amount to zero

        event.target.style.borderColor = '#fa9595';               // change the border colour of the clicked swatch

        let SizeData = new FormData();                                // create a new formData object to send data aysnchronously to the controller

        let productId = document.querySelector('#productId');// The common product id for all product_entries

        let colour = document.querySelector('#label-colour');// The product colour label: will have the colour selected

        SizeData.append('productId', productId.value);  // add productId for the item we are looking at, not the product_entryId
        SizeData.append('size', swatchSize);            // add the size for the item as well
        SizeData.append('colour', colour.textContent);  // add the colour for the item as well
        SizeData.append('action', 'size-swatch');       // add the action that will be used by the case selection in the controller

        fetch(url, {
            method: 'POST',
            body: SizeData
        })
        .then(response=>{
            if(response.ok){
                return response;
            }
            throw Error(response.statusText);
        })
        .then(response=>response.json())
        .then(data=>{
        
            product_entryId.value = data['product_entryId'];    // load the product_entryId from the db

            productPrice.innerHTML = 'R'+data['price'];         // load the price fro  the db
    
        }) 
        .catch(error => console.log(error))

    }, false);

    // When loading the product page, als=ways auto click the first size
    if(i == 0){
        sizeSwatches[i].click();
    }

}