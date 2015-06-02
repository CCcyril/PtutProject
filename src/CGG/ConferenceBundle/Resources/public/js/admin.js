$(document).ready(function(){

    $('.btn-edit-content').hide();

    $("#saveChangesAdminConference").click(function () {
        var data = [];
        var url = Routing.generate('cgg_conference_admin_saveChangesConference', {'idConference':$("#idConference").val(), 'idPage':$("#idPage").val()});
        var nbMenuItemTitle = $(".navbar-nav button").length;
        var nbContent = $(".container div").length;
        for (var i = 1; i <= nbMenuItemTitle; i++) {
            data.push({name: 'menuItemTitle' + i, value: $("#menuItemTitle" + i).text()});
        }
        for (i = 1; i <= nbContent; i++) {
            data.push({name: 'content' + i, value: $("#content" + i).text()});
        }
        data.push({name: 'headbandTitle', value: $('#headbandTitle').text()});
        data.push({name: 'headbandText', value: $('#headbandText').text()});
        data.push({name: 'footerText', value: $('#footerText').text()});

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'html',
            success: function (data) {
            }
        });
    });

    $('.navbar-nav li:not(:last-child)').on('click', function(event){
        var itemId = event.target.id;
        var offsets = $('#'+itemId).offset();
        var top = offsets.top;
        var left = offsets.left;
        var pageId = $('#'+itemId).attr('data-pageId')
        var url = Routing.generate('cgg_conference_adminConference', {'idConference':$("#idConference").val(), 'idPage':$("#"+itemId).attr('data-pageId')});
        $('#menuItemOptions').css({'top':(top+50),'left':(left-100),'position':'absolute'}).fadeIn('slow');
        $('#menuItemOptions').removeClass('hidden');
        $("#pagePath").attr('href', url);
        $("#editMenuItem").on('click', editMenuItem(itemId));
    })

    function editMenuItem (idMenuItem){
        $("#"+idMenuItem).attr('contenteditable', 'true');
    };

    $(".navbar-nav, #menuItemOptions").mouseleave(function(){
       timer = setTimeout(hideMenuItemOptions, 300);
    }).mouseenter(function(){
       clearTimeout(timer);
    });

    function hideMenuItemOptions(){
        $("#menuItemOptions").hide();
    }

    $(".container-edit-content").mouseover(function(){
        $(this).find('.btn-edit-content').show();
    });

    $(".container-edit-content").mouseleave(function(){
        $(this).find('.btn-edit-content').hide();
    });

    $('.btn-edit-content').on('click', function () {

        $('#entity').val($(this).attr('id'));

        $('#editModal').modal('show');
    });

    $('#editModalValidate').on('click', function (e) {
        e.preventDefault();

        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();

        var content = $('#cgg_conferencebundle_content_content').val();
        var idConference = $("#idConference").val();
        var idPage = $("#idPage").val();
        var entity = $('#entity').val();

        alert(entity);

        /* TODO : ouvrir la modale => mettre le type d'entity dans l'input caché */
        /* TODO : valider la modale => appeler en AJAX la foncion saveHeadBand en la mutualisant pour prendre tous les types d'entité */
        /* TODO : En param on aura idPage, idConference, entity, content => switch sur entity puis update en base avec le content et les id */
        /* TODO : mdr ale a + */
    })

});