$(document).ready(function(){
    $("#saveChangesAdminConference").click(function (){
        $.ajax({
            type: "GET",
            url: "{{ path('cgg_conference_admin_saveChangesConference', {idConference:conference.id}) }}",
            data: {
                'headbandTitle': $('#headbandTitle').val()
                /*'headbandText' : $('#headbandText').val(),
                'menuItemTitle': $('#menuItemTitle').val(),
                'contentText'  : $('#contentText').val(),
                'footerText'   : $('#footerText').val()*/
            },
            dataType: 'html',
            success: function(data){
                alert('ok');
            }
        });
    });
});