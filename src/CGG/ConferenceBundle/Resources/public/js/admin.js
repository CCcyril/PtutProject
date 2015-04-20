$(document).ready(function(){
    $("#saveChangesAdminConference").click(function (){
        $.ajax({
            type: "POST",
            url: "{{ path('cgg_conference_admin_saveChangesConference') }}",
            data: {
                'headbandTitle': $('#headbandTitle').val(),
                'headbandText' : $('#headbandText').val(),
                'menuItemTitle': $('#menuItemTitle').val(),
                'contentText'  : $('#contentText').val(),
                'footerText'   : $('#footerText').val()
            },
            dataType: 'html',
            success: function(data){
                alert('ok');
            }
        });
    });
});