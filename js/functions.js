var form = document.forms['uploadform'];

form.addEventListener('submit', function(event) {

    let responseContainer = document.querySelector('#ajaxResponse');
    let product_entryId = this['product_entryId'].value;
    let imagePrimary = this['imagePrimary'].value;
    let data = new FormData();

    data.append('product_entryId', product_entryId);
    data.append('imagePrimary', imagePrimary);
    data.append('file', this['file'].files[0]);

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