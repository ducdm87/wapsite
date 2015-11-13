$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
$("#menu-toggle-2").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled-2");
    $('#menu ul').hide();
});

function initMenu() {
    $('#menu ul').hide();
    $('#menu ul').children('.current').parent().show();
    //$('#menu ul:first').show();
    $('#menu li a').click(
            function () {
                var checkElement = $(this).next();
                if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                    return false;
                }
                if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                    $('#menu ul:visible').slideUp('normal');
                    checkElement.slideDown('normal');
                    return false;
                }
            }
    );
}
$(document).ready(function () {
    initMenu();
});


$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});
$(document).ready(function () {
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) {
                //console.log(log);
            }
        }
    });
});


/*
 * 
 *Ajax Process 
 **/

$(function () {
    $('#progress').css('display', 'none');
    var bar = $('.progress-bar');
    $('#ajaxUploadExtention').ajaxForm({
        beforeSend: function () {
            $('#progress').css('display', 'block');
            var percentVal = '0%';
            bar.css('width', percentVal);
            bar.html(percentVal);
        }, uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.css('width', percentVal);
            bar.html(percentVal);
        },
        complete: function (xhr) {
            window.location.reload(true);
        }
    });

});

$( document ).ready(function( $ ) {
    $('.title-generate').keyup( function(e) {
            title = $('.title-generate').val().trim();
            alias = convertAliasUtf8(title);
            $(".alias-generate").val(alias);
    });
});

function convertAliasUtf8(string)
{
    var array = {"đ":"d","ă":"a","â":"a","á":"a","à":"a","ả":"a","ã":"a","ạ":"a","ấ":"a","ầ":"a","ẩ":"a","ẫ":"a","ậ":"a","ắ":"a","ằ":"a","ẳ":"a","ẵ":"a","ặ":"a","é":"e","è":"e","ẻ":"e","ẽ":"e","ẹ":"e","ế":"e","ề":"e","ể":"e","ễ":"e","ệ":"e","í":"i","ì":"i","ỉ":"i","ĩ":"i","ị":"i","ư":"u","ô":"o","ơ":"o","ê":"e","Ư":"u","Ô":"o","Ơ":"o","Ê":"e","ú":"u","ù":"u","ủ":"u","ũ":"u","ụ":"u","ứ":"u","ừ":"u","ử":"u","ữ":"u","ự":"u","ó":"o","ò":"o","ỏ":"o","õ":"o","ọ":"o","ớ":"o","ờ":"o","ở":"o","ỡ":"o","ợ":"o","ố":"o","ồ":"o","ổ":"o","ỗ":"o","ộ":"o","ú":"u","ù":"u","ủ":"u","ũ":"u","ụ":"u","ứ":"u","ừ":"u","ử":"u","ữ":"u","ự":"u",'ý':'y','ỳ':'y','ỷ':'y','ỹ':'y','ỵ':'y', 'Ý':'Y','Ỳ':'Y','Ỷ':'Y','Ỹ':'Y','Ỵ':'Y',"Đ":"D","Ă":"A","Â":"A","Á":"A","À":"A","Ả":"A","Ã":"A","Ạ":"A","Ấ":"A","Ầ":"A","Ẩ":"A","Ẫ":"A","Ậ":"A","Ắ":"A","Ằ":"A","Ẳ":"A","Ẵ":"A","Ặ":"A","É":"E","È":"E","Ẻ":"E","Ẽ":"E","Ẹ":"E","Ế":"E","Ề":"E","Ể":"E","Ễ":"E","Ệ":"E","Í":"I","Ì":"I","Ỉ":"I","Ĩ":"I","Ị":"I","Ư":"U","Ô":"O","Ơ":"O","Ê":"E","Ư":"U","Ô":"O","Ơ":"O","Ê":"E","Ú":"U","Ù":"U","Ủ":"U","Ũ":"U","Ụ":"U","Ứ":"U","Ừ":"U","Ử":"U","Ữ":"U","Ự":"U","Ó":"O","Ò":"O","Ỏ":"O","Õ":"O","Ọ":"O","Ớ":"O","Ờ":"O","Ở":"O","Ỡ":"O","Ợ":"O","Ố":"O","Ồ":"O","Ổ":"O","Ỗ":"O","Ộ":"O","Ú":"U","Ù":"U","Ủ":"U","Ũ":"U","Ụ":"U","Ứ":"U","Ừ":"U","Ử":"U","Ữ":"U","Ự":"U"};
    for (var val in array)
    string = string.replace(new RegExp(val, "g"), array[val]);
    string = string.toLowerCase();
    re = /[^a-zA-Z0-9-.]/gim;
    string = string.replace(re,'-');
    re = /^[-]+/gim;
    string = string.replace(re, '');
    re = /[-]+$/gim;
    string = string.replace(re, '');
    re = /[-]{2,}/gim;
    string = string.replace(re, '-');
    return string;
}
