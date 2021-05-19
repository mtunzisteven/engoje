
//----------------variables for elements that will be bechanged by swatch selection------|
let primaryImage = document.querySelector('#single-product');//                       |
let product_entryId = document.querySelector('#product_entryId');//                   |
let productPrice = document.querySelector('#productPrice');//                         |
//---------------------------------------------------------------------------------------|

let colourSwatches = document.querySelectorAll('.colour'); // get all divs with class:colour

for(let i = 0; i<colourSwatches.length; i++){ // loop through them all and add the event Listener.

        let swatchColour = colourSwatches[i].getAttribute("name"); // get text area name | all swatches are textarea elements

        colourSwatches[i].style.backgroundColor = swatchColour; // apply the corresponding colour to each swatch
        colourSwatches[i].style.color = swatchColour;           // also hide the text by making it the same colour as the background

        colourSwatches[i].addEventListener('click', function(event) { // add an even listener for when any swatch is clicked.

            for(let j = 0; j<colourSwatches.length; j++){             
                colourSwatches[j].style.borderColor = '#d8d5d5';      // go through each swatch and make sure it has the default border colour
            }

            event.target.style.borderColor = '#000000';               // change the border colour of the clicked swatch

            let data = new FormData();         // create a new formData object to send data aysnchronously to the controller

            let productId = document.querySelector('#productId');// 
        
            data.append('productId', productId.value);  // add productId for the item we are looking at, not the product_entryId
            data.append('colour', swatchColour);  // add the colour for the item as well
            data.append('action', 'new-swatch');  // add the action that will be used by the case selection in the controller
        
            // Send data
            var request = new XMLHttpRequest();
            request.open("POST", "http://localhost/zalisting/shop/index.php", false);
            request.onload = function() {
                if (request.status == 200) {
                    primaryImage.setAttribute('src', this.responseText);
                    //alert(this.responseText);
                } else {
                    responseContainer.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";
                }
            };
        
            request.send(data);
            //event.preventDefault();
        }, false);
}