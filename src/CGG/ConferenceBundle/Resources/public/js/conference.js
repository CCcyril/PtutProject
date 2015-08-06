$(document).ready(function () {

    $(".container-edit-content").mouseover(function(){
        $(this).find('input').show();
    });

    $(".container-edit-content").mouseleave(function(){
        $(this).find('input').hide();
    });

});