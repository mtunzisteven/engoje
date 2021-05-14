
var form = document.forms; // array of all forms

for(let i = 0; i<form.length; i++){ // loop through them all and add the event Listener.


    form[i].addEventListener('submit', function(event) {

        //alert();
    
        let responseContainer = document.querySelector('#ajaxResponse');
        //let product_entryId = this['product_entryId'].value;
        let product_entryId = event.target['product_entryId'].value; // Be specific to the firing form using target
        //let imagePrimary = this['imagePrimary'].value;
        let imagePrimary = event.target['imagePrimary'].value; // Be specific to the firing form using target
        let data = new FormData();
    
        data.append('product_entryId', product_entryId);
        data.append('imagePrimary', imagePrimary);
        //data.append('file', this['file'].files[0]);
        data.append('file', event.target['file'].files[0]); // Be specific to the firing form using target
    
        // Send data
        var request = new XMLHttpRequest();
        request.open("POST", "http://localhost/zalisting/new/index.php", false);
        request.onload = function() {
            if (request.status == 200) {
                responseContainer.innerHTML = this.responseText;
                console.log(this.responseText);
            } else {
                responseContainer.innerHTML = "Error " + request.status + " occurred when trying to upload your file.<br \/>";
            }
        };
    
        request.send(data);
        event.preventDefault();
    }, false);

}