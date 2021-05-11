$(document).ready(function () {

    $(".uploadform").on("submit" ,function(e){
        e.preventDefault();

        let check = 0;


        //$(this).ajaxForm({url: 'http://localhost/zalisting/upload/index.php', type: 'post'});
        
        $.post('http://localhost/zalisting/upload/index.php', $(this).serialize())

        /*
        let product_entryId = parseInt(document.querySelector('#activeForm #product_entryId').value); // The id of the product entry
        let primaryImages = document.querySelectorAll('#activeForm .primary');        // The primary image radio input
        let file = document.querySelector('#activeForm #file').value;                       // The file uploaded
        let actionAttr = document.querySelector('#activeForm #action').value;                       // The file uploaded
    
    
    
        let primaryImage = loopIds(primaryImages);                             // Get the checked radio button
    
        let form_data = {product_entryId:product_entryId, primaryImage:primaryImage, file1:file, action:actionAttr}; // Format the data to send to the controller

        // The actual ajax data transfer method. Data gathered above will now be used.
        $.ajax({
            type: 'POST', 
            url: 'http://localhost/zalisting/upload/index.php',
            data: form_data,
            success: function (response) {
                $('#ajax-response').text(response);
            }
            
        });*/

        check +=1;

        //$('#activeForm').removeAttr('id');

        return false;

    });

});



// Select only checked checkboxes and radio buttons
function loopIds(elements){

    // I don't expecct that this loop will ever reach 50. Thus the setting to 50
    for(let i=0; i<50; i++){
        if(elements[i].checked){
            //alert(elements[i].value);
            return elements[i].value;
        }
    }
}