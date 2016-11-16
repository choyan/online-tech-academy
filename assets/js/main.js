$(".add-course #category_id" ).change(function () {
    $( "#category_id option:selected" ).each(function() {
        var categorytVal = $(this).val();
        console.log(categorytVal);
        $.ajax({
            type: 'post',
            url: 'get/get-subcategory.php',
            data: {
               get_option: categorytVal
            },
            success: function (response) {
                document.getElementById("sub-category").innerHTML=response;
            }
       });
    });
})
$(document).ready(function() {
    $( "#category_id option:selected" ).each(function() {
        var categorytVal = $(this).val();
        console.log(categorytVal);
        $.ajax({
            type: 'post',
            url: 'get/get-subcategory.php',
            data: {
               get_option: categorytVal
            },
            success: function (response) {
                document.getElementById("sub-category").innerHTML=response;
            }
       });
    });
})

// To Do asynchronized removed;
// $('.accept').click(function(e){
//     console.log($(this).parent().parent());
//     $(this).parent().parent().remove();
// })

$('.expander').simpleexpand();
