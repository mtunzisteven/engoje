$(document).ready(function () {

    $('#variations').on('click', function(){

        let data = ajaxing();

        // The actual ajax data transfer method. Data gathered above will now be used.
        $.ajax({
            type: 'POST', 
            url: "/zalisting/products/index.php?action='variations'",
            data: data,
            success: function (response) {
                alert(response);
            }
            
        });
    });
});

function ajaxing(){

    let categoryIds = document.getElementsByClassName('categoryId');
    let colourIds = document.getElementsByClassName('colourId');
    let sizeIds = document.getElementsByClassName('sizeId');


    let categoryId = loopIds(categoryIds);
    let colourId = loopIds(colourIds);
    let sizeId = loopIds(sizeIds);

    let data = {categoryId:categoryId, colourIds:colourId, sizeIds:sizeId};



    return data;
}


// Select only checked checkboxes and radio buttons
function loopIds(elements){

    let Arr = [];

    for(let i=0; i<elements.length; i++){
        if(elements[i].checked){
            //alert(elements[i].value);
            Arr.push(elements[i].value);
        }
    }

    return Arr;
}