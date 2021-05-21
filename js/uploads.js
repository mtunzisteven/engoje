
var form = document.forms; // array of all forms

for(let i = 0; i<form.length; i++){ // loop through them all and add the event Listener.


    form[i].addEventListener('submit', function(event) {

        //alert();
    
        let responseContainer = document.querySelector('#ajaxResponse');
        let product_entryId = event.target['product_entryId'].value; // Be specific to the firing form using target
        let imagePrimary = event.target['imagePrimary'].value; // Be specific to the firing form using target
        let data = new FormData();
    
        data.append('product_entryId', product_entryId);
        data.append('imagePrimary', imagePrimary);
        data.append('file', event.target['file'].files[0]); // Be specific to the firing form using target
        data.append('action', 'new-upload');

        // Send data
        var request = new XMLHttpRequest();
        request.open("POST", "http://localhost/zalisting/upload/index.php", false);
        request.onload = function() {
            if (request.status == 200) {
                responseContainer.innerHTML = this.responseText;
            } else {
                responseContainer.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";
            }
        };
    
        request.send(data);
        event.preventDefault();
    }, false);

}