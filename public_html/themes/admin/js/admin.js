/********************************
 * Created by GoldenEye.
 * ICQ 285652 / email : slims@ukr.net
 * copyright 2010 - 2015 SCRIPTS WEB
 * http://scriptsweb.ru
 ********************************/
jQuery(document).ready(function($) {

// site preloader -- also uncomment the div in the header and the css style for #preloader
    $(window).ready(function(){
        $('#preloader').fadeOut('slow',function(){$(this).remove();});
    });

    // var url=document.location.href;
    // $.each($("nav a"),function(){
    //
    //
    //     console.log(this.href, url);
    //     //
    //     //
    //     // if(url.indexOf(this.href)>=0){
    //     if( url == this.href){
    //     //     $(this).children('li').addClass('open');
    //         $(this).parent().parent().parent().addClass('open');
    //         $(this).parent().show();
    //
    //
    //         $(this).removeAttr('href').css('cursor', 'default');
    //     }
    // });

    // Override summernotes image manager
    $('button[data-event="showImageDialog"]').attr('data-toggle', 'image').removeAttr('data-event');

    $(document).delegate('button[data-toggle="image"]', 'click', function() {
        $('#modal-image').remove();

        $(this).parents('.note-editor').find('.note-editable').focus();

        $.ajax({
            url: 'index.php?route=common/filemanager&token=' + getURLVar('token'),
            dataType: 'html',
            beforeSend: function() {
                $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                $('#button-image').prop('disabled', true);
            },
            complete: function() {
                $('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
                $('#button-image').prop('disabled', false);
            },
            success: function(html) {
                $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                $('#modal-image').modal('show');
            }
        });
    });

    // Image Manager
    $(document).delegate('a[data-toggle="image"]', 'click', function(e) {
        e.preventDefault();

        $('.popover').popover('hide', function() {
            $('.popover').remove();
        });

        var element = this;

        $(element).popover({
            html: true,
            placement: 'right',
            trigger: 'manual',
            content: function() {
                return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
            }
        });

        $(element).popover('show');

        $('#button-image').on('click', function() {
            $('#modal-image').remove();
            $.ajax({
                url: '/filemanager/index?target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
                dataType: 'html',
                beforeSend: function() {
                    $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                    $('#button-image').prop('disabled', true);
                },
                complete: function() {
                    $('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
                    $('#button-image').prop('disabled', false);
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });

            $(element).popover('hide', function() {
                $('.popover').remove();
            });
        });

        $('#button-clear').on('click', function() {
            $(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

            $(element).parent().find('input').attr('value', '');

            $(element).popover('hide', function() {
                $('.popover').remove();
            });
        });
    });

});

var Admin = {
    AjaxFormValidate: function (form, attribute, data, hasError) {
        if (hasError)
            $("#" + attribute.id).parent().addClass("state-error");
        else
            $("#" + attribute.id).parent().removeClass("state-error");
    },

    AjaxFormSend: function (form, data, hasError) {
        if (hasError)
        {
            for (var i in data) $("#" + i).parent().removeClass("state-success").addClass("state-error");
        }
        else
        {
            $(form).find('label, input').each(function () {
                $(this).removeClass('state-error');
            });
            $.ajax({
                type: 'POST',
                url: form[0].action,
                dataType: 'json',
                data: $(form).serialize(),
                success: function (result) {
                    Admin.smallBox(result);
                    Admin.defaultActions(result);

                },
                error: function (xhr) {
                    Admin.smallBox(xhr.responseText);
                }
            });
        }

        return false;
    },
    defaultActions: function (response) {

        if('redirect' in response)
        {
            window.history.pushState(null, null, response.redirect), App.checkURL();

        }

        if('validateForm' in response)
        {
            console.log('run validation form');
            $.each(response.keys, function(key, val) {
                $('[name='+key+']').parent().append('<div class="error">'+val+'</div> ');
            });
        }


    },
    smallBox: function (response) {
        try {
            if (response.status == 'success') {
                $.smallBox({
                    //title: 'Success',
                    content: response.message,
                    color: "#739E73",
                    iconSmall: "fa fa-check tada animated",
                    timeout: 15000
                });
            } else if (response.status == 'error') {

                var reason = '';
                if(response.keys){
                    $.each(response.keys, function(key, val) {
                        reason += val+'<br>';
                    });
                }

                $.smallBox({
                    content: response.message + (reason!='' ? '<br>'+reason : ''),
                    color: "#A65858",
                    iconSmall: "fa fa-times flip animated",
                    timeout: 15000
                });
            }
        }
        catch (e) {
            $.smallBox({
                title: "Answer from server isn't JSON format!",
                content: e,
                color: "#C46A69",
                iconSmall: "fa fa-support"
            });
        }
    }
};