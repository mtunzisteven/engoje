/*$(document).ready(function () {

    var data = {};

    $('#variations').on('click', function(){

        var categories = $('.categoryId').val();
        var colours = $('.colourId').val();
        var sizes = $('.sizeId').val();

        data['categoryIds']= categories;
        data['colourIds']= colours;
        data['sizeIds']= sizes;

        // The actual ajax data transfer method. Data gathered above will now be used.
        $.ajax({
            type: 'POST', 
            url: "/zalisting/products/index.php?action='variations'",
            data: data,
            success: function (response) {
                console.log(response);
            }
            
        });
    });
});*/

function ajaxing(){

    var categoryIds = document.getElementsByClassName('categoryId').value;
    /*var colourIds = parseInt(document.getElementsByClassName('colourId').value);
    var sizeIds = parseInt(document.getElementsByClassName('sizeId').value);*/

    var stringOut = "";

    for(var category in categoryIds){
        stringOut += category;
    }
    alert(stringOut);


    return;
}