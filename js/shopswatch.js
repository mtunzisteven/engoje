//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
//                                   Swatches Code                                      //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////
// get all divs with class:colour
let colourSwatches = document.querySelectorAll('.colour');          
let colourForm = document.querySelector('#colourform');
let colourChosen = colourForm['colour'];

// set colour swatch event listener
sidebarSwatcher(colourSwatches, colourForm,  colourChosen);


// get all divs with class:size
let sizeSwatches = document.querySelectorAll('.size');              
let sizeForm = document.querySelector('#sizeform');
let sizeChosen = sizeForm['size'];

// set size swatch event listener
sidebarSwatcher(sizeSwatches, sizeForm,  sizeChosen);


//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
//                                 Categories Code                                      //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////

let formCat =  document.querySelector('.category-form');
let selectCat = document.querySelector('#category');

sidebarCategories(selectCat,  formCat);

//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
//                                  functions Code                                      //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////


// color and size swatches event listener function
function sidebarCategories(selectCat,  formCat){

    selectCat.addEventListener('change', function(event) { // add an even listener for when any swatch is clicked.

        formCat.submit();  // submit form
    
    }, false);

}


// color and size swatches event listener function
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
