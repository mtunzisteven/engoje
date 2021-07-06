
let colourSwatches = document.querySelectorAll('.colour');          // get all divs with class:colour
let colourForm = document.querySelector('#colourform');
let colourChosen = colourForm['colour'];

let sizeSwatches = document.querySelectorAll('.size');              // get all divs with class:size
let sizeForm = document.querySelector('#sizeform');
let sizeChosen = sizeForm['size'];

sidebarSwatcher(colourSwatches, colourForm,  colourChosen);

sidebarSwatcher(sizeSwatches, sizeForm,  sizeChosen);


//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
//                              Colour Swatches Code                                    //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

function sidebarSwatcher(swatches, form,  choice){
        
    for(let i = 0; i<swatches.length; i++){ // loop through them all and add the event Listener.

        swatches[i].style.backgroundColor = swatches[i].getAttribute("name"); // apply the corresponding colour to each swatch
        swatches[i].style.color = swatches[i].getAttribute("name");           // also hide the text by making it the same colour as the background

        swatches[i].addEventListener('click', function(event) { // add an even listener for when any swatch is clicked.

            choice.value = swatches[i].getAttribute("name"); // get text area name | all swatches are textarea elements

            for(let j = 0; j<swatches.length; j++){             
                swatches[j].style.borderColor = '#d8d5d5';      // go through each colour swatch and make sure it has the default border colour
            }

            event.target.style.borderColor = '#fa9595';        // change the border colour of the clicked swatch

            form.submit();  // submit form

        }, false);
    }
}
