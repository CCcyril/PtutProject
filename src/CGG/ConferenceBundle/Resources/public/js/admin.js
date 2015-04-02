$(document).ready(function(){
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
        $(this).find('input').show();
    });

    $(".container-edit-content").mouseleave(function(){
        $(this).find('input').hide();
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

    $("#saveChangeHeadband").on('click', function(){
        var url = Routing.generate('cgg_conference_admin_saveChangeHeadband');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'idConference': $("#idConference").val(),
                'idPage': $("#idPage").val(),
                'headbandTitle': $("#headbandTitle").text(),
                'headbandText': $("#headbandText").text()
            },
            dataType: "html",
            success:function() {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
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
});