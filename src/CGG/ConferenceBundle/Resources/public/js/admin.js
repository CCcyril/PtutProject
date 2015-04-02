$(document).ready(function(){
    $("#saveChangesAdminConference").click(function (){
        var data = [];
        var url = Routing.generate('cgg_conference_admin_saveChangesConference', {'idConference':10});
        var nbMenuItemTitle = $(".navbar-nav a").length;
        var nbContent = $(".container div").length;
        for(var i=1; i<=nbMenuItemTitle ; i++){
            data.push({name: 'menuItemTitle'+i, value:$("#menuItemTitle"+i).text()});
        }
        for(i=1; i<=nbContent; i++){
            data.push({name: 'content'+i, value: $("#content"+i).text()});
        }
        data.push({name: 'headbandTitle', value: $('#headbandTitle').text()});
        data.push({name: 'headbandText', value: $('#headbandText').text()});
        data.push({name: 'footerText', value: $('#footerText').text()});
        alert(url);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'html',
            success: function(data){

            }
        });
    });
});