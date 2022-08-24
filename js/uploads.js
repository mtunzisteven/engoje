
var form = document.forms; // array of all forms

for(let i = 0; i<form.length; i++){ // loop through them all and add the event Listener.


    form[i].addEventListener('submit', function(event) {
        event.preventDefault();
        //alert();
    
        let responseContainer = document.querySelector('#ajaxResponse');
        let product_entryId = parseInt(event.target['product_entryId'].value); // Be specific to the firing form using target
        let imagePrimary = parseInt(event.target['imagePrimary'].value); // Be specific to the firing form using target
        let data = new FormData();

    
        data.append('product_entryId', product_entryId);
        data.append('imagePrimary', imagePrimary);


        if(imagePrimary == 1){

            data.append('file', event.target['file'].files[0]); // Be specific to the firing form using target
            data.append('action', 'new-upload');

        }else{
            for(let j = 0; j <  event.target['file'].files.length; j++){  // 6 for a maximum of 5 gallery images

                data.append('file[]', event.target['file'].files[j]); // upload entire array of images

            }

            data.append('action', 'multi-upload');


        }


       

        // Send data
        var request = new XMLHttpRequest();
        request.open("POST", "https://engoje.co.za/upload/index.php", false);
        request.onload = function() {
            if (request.status == 200) {
                responseContainer.innerHTML = this.responseText;
            } else {
                responseContainer.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";
            }
        };
    
        request.send(data);
    }, false);

}