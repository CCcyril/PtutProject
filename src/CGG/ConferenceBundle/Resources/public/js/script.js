$(document).ready(function(){
    var heightfooter = $("footer").height();
    heightfooter = heightfooter +60;
    $("body").css("margin-bottom",heightfooter+"px");
    /* Scroll top */
    $('#back-top').click(function () {
        $('body,html').animate({scrollTop:0}, 800);
        return false;
    });
    $(window).scroll(function(){
        if($(document).scrollTop() > 200){
            $("#back-top").fadeIn(500);
        }else{
            $("#back-top").fadeOut(200);
        }
    });
    var idConference = $("#idConference").val();
    var url= Routing.generate('cgg_conference_map');
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'idConference': idConference
        },
        dataType: "json",
        success: function (json) {
            var map =new GMaps({
                div: '#map',
                lat: json['latitude'],
                lng: json['longitude']
            });
            map.addMarker({
                lat: json['latitude'],
                lng: json['longitude'],
                title: 'Lima',
                infoWindow: {
                    content: '<p>'+json['infoMap']+'</p>'
                }
            });
        }
    });
    $("#envoieEmail").click(function(){
        var nom = $("#name").val();
        var prenom = $("#firstName").val();
        var mail = $("#email").val();
        var sujet = $("#sujet").val();
        var message = $("#message").val();
        var idConference = $("#idConference").val();
        var url= Routing.generate('cgg_conference_contact_conference');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'nom': nom,
                'prenom': prenom,
                'mail': mail,
                'sujet': sujet,
                'message': message,
                'idConference': idConference
            },
            dataType: "json",
            success: function (json) {
                if(json['erreur'] == true){
                    var message = '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation"></i> '+json['message']+'</div>'
                }else{
                    var message = '<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> '+json['message']+'</div>'
                }
                $("#reponseContact").empty();
                $("#reponseContact").append(message);
            }
        });
    });
});
