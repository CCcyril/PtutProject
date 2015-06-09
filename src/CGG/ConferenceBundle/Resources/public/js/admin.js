$(document).ready(function() {

    $('.btn-edit-content').hide();
    $('.btn-delete-content').hide();
    $('.btn-edit-content-image').hide();

    $('#menuItemModal').on('hidden.bs.modal', function () {
        $('#menuItemModalErrors').addClass('hidden');
    });

    $('#menuItemModalValidate').on('click', function (e) {
        e.preventDefault();

        var buttonName = $('#buttonNameInput').val();
        var idMenuItem = $('#menuItemIdModalInput').val();

        if (buttonName === '') {
            $('#menuItemModalErrors').removeClass('hidden');
        } else {
            var url = Routing.generate('cgg_conference_admin_saveButtonName');
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    'buttonName': buttonName,
                    'idMenuItem': idMenuItem
                },
                dataType: "html",
                success: function () {
                    $('#spanMenuItem' + idMenuItem).html(buttonName);
                    $('#menuItemModal').modal('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + xhr.status);
                }
            });
        }
    });

    $("#saveChangesAdminConference").click(function () {
        var data = [];
        var url = Routing.generate('cgg_conference_admin_saveChangesConference', {
            'idConference': $("#idConference").val(),
            'idPage': $("#idPage").val()
        });
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
            success: function () {
                window.location.reload(true);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    $('#navbar li:not(:last-child) span').on('click', function () {
        var itemId = $(this).parent().attr('id');
        var idMenuItem = $('#' + itemId).attr('data-menuItemId');
        var idCurrentPage = $(this).attr('data-pageId');
        $("#addSubItem").attr('data-menuItemId', idMenuItem);
        $("#btnRemovePage").attr('data-menuItemId', idMenuItem);
        $("#btnRemovePage").attr('data-idCurrentPage', idCurrentPage);
        $("#pagePath").attr('data-menuItemId', itemId);
    });

    $('.menu-edit-content span').on('click', function () {
        $('#buttonNameInput').val($(this).html().trim());
        $('#menuItemIdModalInput').val($(this).parent().attr('data-menuItemId'));

    })

    $(".container-edit-content, .menu-edit-content").mouseover(function () {
        $(this).find('.btn-edit-content').show();
        $(this).find('.btn-delete-content').show();
        $(this).find('.btn-edit-content-image').show();
    });

    $(".container-edit-content, .menu-edit-content").mouseleave(function () {
        $(this).find('.btn-edit-content').hide();
        $(this).find('.btn-delete-content').hide();
        $(this).find('.btn-edit-content-image').hide();
    });

    $('.btn-edit-content-image').on('click', function () {
        $('#imageModal').modal('show');
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

        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();

        var content = $('#cgg_conferencebundle_content_content').val();
        var idConference = $("#idConference").val();
        var idParent = $("#addSubItem").attr('data-menuItemId');
        var idPage = $("#idPage").val();
        var entity = $('#entity').val();
        var idContent = $('#idContent').val();

        var url = Routing.generate('cgg_conference_admin_saveChangeContent');
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
            success: function () {
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


    $("#addSubItem").on('click', function (event) {
        var url = Routing.generate('cgg_conference_admin_add_sub_item');
        var idConference = $("#idConference").val();
        var itemId = event.target.id;
        var idParent = $("#" + itemId).attr('data-menuItemId');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idConference': idConference,
                'idParent': idParent
            },
            dataType: "html",
            success: function () {
                window.location.reload(true);
            }
        });
    });

    /* Referme les nouvelles pages à la fermeture de la modale*/

    $('#myModal').on('hidden.bs.modal', function () {
        $("#reponseValidation").empty();
    });

    $("#saveSetting").on('click', function () {
        var idConference = $("#conference_id").attr("data-id");
        var mainColor = $("#mainColor").val();
        var secondaryColor = $("#secondaryColor").val();
        var emailContact = $("#emailContact").val();
        var longitude = $("#longitude").val();
        var latitude = $("#latitude").val();
        var info = $("#info").val();
        var url = Routing.generate('cgg_conference_admin_save_setting');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idConference': idConference,
                'mainColor': mainColor,
                'secondaryColor': secondaryColor,
                'emailContact': emailContact,
                'longitude': longitude,
                'latitude': latitude,
                'info': info
            },
            dataType: "json",
            success: function (json) {
                if(json['erreur'] == true){
                    $("#reponseValidation").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation"></i> '+json['message']+'</div>');
                }else {
                    $('#myModal').modal('hide');
                    window.location.reload(true);
                }
            }
        });
    });
    $.fn.modal.Constructor.prototype.enforceFocus = function () {
        var $modalElement = this.$element;
        $(document).on('focusin.modal', function (e) {
            var $parent = $(e.target.parentNode);
            if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
                    // add whatever conditions you need here:
                && !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
                $modalElement.focus()
            }
        })
    };

    $('#addContentButton').on('click', function () {
        var idPage = $("#idPage").val();
        var url = Routing.generate('cgg_conference_admin_addContent');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idPage': idPage
            },
            dataType: "html",
            success: function () {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + xhr.status);
            }
        });

    });

    $('.btn-delete-content').on('click', function () {
        var idContent = $(this).attr('id').replace('deleteContent', '');
        var url = Routing.generate('cgg_conference_admin_deleteContent');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idContent': idContent
            },
            dataType: "html",
            success: function () {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + xhr.status);
            }
        });

    });

    $("#btnRemovePage").on('click', function () {
        var url = Routing.generate('cgg_conference_admin_remove_page');
        var idPage = $("#idPage").val();
        var idConference = $("#idConference").val();
        var idMenuItem = $("#btnRemovePage").attr('data-menuItemId');
        var currentUrl =  window.location.pathname;
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idPage': idPage,
                'idMenuItem': idMenuItem,
                'idConference': idConference,
                'currentUrl': currentUrl
            },
            dataType: "json",
            success: function (json) {
                var idHomePage = json['idHomePage'];
                redirectUrl = currentUrl.replace(idPage, idHomePage);
                window.location.href = redirectUrl;
            }
        });
    });

    /* TOUT CE QUI EST NÉCESSAIRE À L'UPLOAD D'IMAGE */

    var files;

    $('input[type=file]').on('change', prepareUpload);

    function prepareUpload(event)
    {
        files = event.target.files;
    }

    $('#imageModalValidate').on('click', function (e) {
        e.preventDefault();
        $(this).parent().parent().find('form').submit();
    });

    $("#pagePath").on('click', function(){
        var menuItemId = $("#pagePath").attr('data-menuItemId');
        var pageId = $("#"+menuItemId).attr('data-pageId');
        var currentPageId = $("#idPage").val();
        var currentUrl = window.location.pathname;
        var url = currentUrl.replace(currentPageId, pageId);
        $("#pagePath").attr('href', url);
    });
});