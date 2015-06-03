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
            success: function(){
              window.location.reload(true);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    $('.navbar-nav li:not(:last-child)').on('click', function(event){
        var itemId = event.target.id;
        var offsets = $('#'+itemId).offset();
        var top = offsets.top;
        var left = offsets.left;
        var pageId = $('#'+itemId).attr('data-pageId');
        var url = Routing.generate('cgg_conference_adminConference', {'idConference':$("#idConference").val(), 'idPage':$("#"+itemId).attr('data-pageId')});
        var menuItemId = $('#'+itemId).attr('data-menuItemId');
        $('#menuItemOptions').css({'top':(top+50),'left':(left-100),'position':'absolute'}).fadeIn('slow');
        $('#menuItemOptions').removeClass('hidden');
        $("#pagePath").attr('href', url);
        $("#editMenuItem").on('click', editMenuItem(itemId));
        $("#addSubItem").attr('data-menuItemId', menuItemId);
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

        if (typeof $(this).parent().find('div:first').attr('id') !== 'undefined' && $(this).parent().find('div:first').attr('id').substring(0, 7) === 'content') {
            $('#idContent').val($(this).parent().find('div:first').attr('id').replace('content', ''));
        }

        CKEDITOR.instances['cgg_conferencebundle_content_content'].setData($(this).parent().html().replace('<i id="' + $(this).attr('id') + '" class="btn-edit-content fa fa-pencil fa-2x"></i>', ''));

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
        var idContent = $('#idContent').val();

        var url= Routing.generate('cgg_conference_admin_saveChangeContent');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idConference': idConference,
                'idPage': idPage,
                'content': content,
                'entity': entity,
                'idContent': idContent
            },
            dataType: "html",
            success:function() {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + xhr.status);
            }
        });
    });

    $('#editModal').on('bs.modal.hidden', function () {
        $('iframe').find('body').html('<p></p>');
        $('#idContent').val(0);
    });


    $("#addSubItem").on('click', function(event){
        var url = Routing.generate('cgg_conference_admin_add_sub_item');
        Routing.generate('cgg_conference_admin_add_sub_item');
        var idConference = $("#idConference").val();
        var itemId = event.target.id;
        var idParent = $("#"+itemId).attr('data-menuItemId');
        alert(url + ", " + idConference + ", " + idParent);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idConference': idConference,
                'idParent': idParent
            },
            dataType: "html",
            success: function(){
                window.location.reload(true);
            }
        });
    });

    $("#btnAddPages").on('click', function(){
        $("#addPages").removeClass('hidden');
    });

    $("#addInput").on('click', function(){
        var lastDiv = $("#addPages form div:last");
        lastDiv.after("<div class='form-group'>" + lastDiv.html() + "</div>");
        if($("#removeInput").hasClass('disabled')){
            $("#removeInput").removeClass('disabled');
        }
    })

    $("#removeInput").on('click', function(){
        var countInput = $("#addPages form div").length;
        if(countInput === 3){
            $("#removeInput").addClass('disabled');
        }
        $("#addPages form div:last").remove();
    });

    $("#btnUpdateBackground").on('click', function(){
        $("#updateBackground").removeClass('hidden');
    });

    $('.demo-auto').colorpicker();

    $.fn.modal.Constructor.prototype.enforceFocus = function () {
        var $modalElement = this.$element;
        $(document).on('focusin.modal', function (e) {
            var $parent = $(e.target.parentNode);
            if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
                    // add whatever conditions you need here:
                &&
                !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
                $modalElement.focus()
            }
        })
    };
});