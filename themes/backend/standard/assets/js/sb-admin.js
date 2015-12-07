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



function BrowseServer()
{
    // You can use the "CKFinder" class to render CKFinder in a page:
    var finder = new CKFinder();
    finder.basePath = '../';	// The path for the installation of CKFinder (default = "/ckfinder/").
    finder.selectActionFunction = SetFileField;
    finder.popup();
}
function SetFileField(fileUrl)
{
    console.log(fileUrl);
    document.getElementById('image_hiden').value = fileUrl;
    document.getElementById('image_src').src = BASE_URL + fileUrl;
    document.getElementById('video-src').src = BASE_URL + fileUrl;
}

function BrowseServerVideo() {

    var finder = new CKFinder();
    finder.basePath = '../';	// The path for the installation of CKFinder (default = "/ckfinder/").
    finder.selectActionFunction = SetFileFieldVideo;
    finder.popup();
}

function SetFileFieldVideo(fileUrl)
{
    $("#video-src").attr('disabled', true);
    $('#checkYoutube').attr('checked', false);
    console.log(fileUrl);
    document.getElementById('videourl').value = fileUrl;
//    document.getElementById('video_src').src = BASE_URL + fileUrl;
}


$(function () {
    $('select[name="type"]').change(function (e) {
        e.preventDefault();
        var value = $(this).val();
        if (value ==0) {
            $('.catalog').hide();
            $('.control-area').hide();
            $('.control-year').hide();
            $('.control-actor').hide();
            $('.control-duration').hide();
            $('.control-director').hide();
            $('.episode-control').hide();
            $('.video-control').hide();
        } else {
            $('.catalog').show();
            $('.control-area').show();
            $('.control-year').show();
            $('.control-actor').show();
            $('.control-duration').show();
            $('.control-director').show();
            $('.episode-control').show;
            $('.video-control').show();
        }

    });

    $('#checkYoutube').click(function () {
        $("#video-src").removeAttr('disabled');
//        $('#video_hiden').hide();
    });


});


function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

$(function () {  
    
    $(".panel-items-app .panel-item .panel-heading").click(function(){
        var cur_btn = $(this).find(".btn-arrow");
        if($(cur_btn).hasClass("fa-chevron-up") == true){ // dong cai hien tai
            $(this).find("~ .panel-body").slideUp();
            $(cur_btn).removeClass("fa-chevron-up");
            $(cur_btn).addClass("fa-chevron-down");
            $(this).removeClass("active");
        }else{ // dong cai khac va mo cai hien tai            
            $(".panel-items-app .panel-item .panel-body").slideUp();
            $(".panel-items-app .panel-item .panel-heading .btn-arrow").addClass("fa-chevron-down");
            $(".panel-items-app .panel-item .panel-heading .btn-arrow").removeClass("fa-chevron-up");
            $(this).find("~ .panel-body").slideDown();
            $(cur_btn).removeClass("fa-chevron-down");
            $(cur_btn).addClass("fa-chevron-up");
            $(this).addClass("active");
        }
    });
    
    $(".model-blind").click(function(){
         $(".modal-dialog .close").click();
    });
    
    $("#changePermission .apply-form").click(function(){
        var per_ck = {};
        per_ck.allow = [];
        per_ck.deny = [];
        $(".btn-group-action").each(function(stt,el){
            var v_for = $(el).attr('for');
            key = v_for.replace('btnform_resource-',"");
            var v_value = parseInt($("#"+v_for).val());
            if(v_value == 1) per_ck.allow.push(key);
            else if(v_value == 0) per_ck.deny.push(key);
        });         
         $("#formPsermission").val(JSON.stringify(per_ck));
          $("#changePermission").modal('hide');
    });
    
     $(document).delegate(".user-tree ul li.folder .folder-btn", "click", function() {
         var parent_group = $(this).parent();
         if($(this).hasClass('btn-close')){
            $(this).removeClass('btn-close');
            $(this).addClass('btn-open');
            var rel = $(this).attr('rel');
            $(this).attr('rel', "");            
            if(rel != undefined && rel != "" ){
                $.ajax({
                    type: "POST",
                    url: rel,
                    data:{"tmpl":"app"},
                    complete: function(event){                        
                        $(parent_group).html($(parent_group).html() + event.responseText);
                    }
                }).done(function() {  });
            }
            $(parent_group).removeClass('hide-sub');
         }else{
             $(parent_group).addClass('hide-sub');
            $(this).removeClass('btn-open'); 
            $(this).addClass('btn-close');
         }
    });
    
});

function setmenutype(app_name, view_name, layout_name){
    $("#params_app").val(app_name);    
    document.adminForm.menu_type.value = app_name;
    if(app_name == "System"){
        $("#field_link").attr('readonly', false)
        $("#type").val("url");
    }else{
        $("#field_link").attr('readonly', true)
        var link = "/index.php?app="+app_name
        if(view_name != undefined && view_name != "" && view_name != "home"){
            link = link + "&view="+view_name;
            $("#params_view").val(view_name);
        }
        if(layout_name != undefined && layout_name != "" && layout_name != "display"){
            link = link + "&layout="+layout_name;
            $("#params_layout").val(layout_name);
        }
        $("#field_link").val(link);
        $("#type").val("app");
    }
    loadConfigFile(app_name, view_name);
    $(".modal-dialog .close").click();
}

function loadConfigFile(app_name, view_name){
    menuID = document.adminForm.id.value;
    $.ajax({
        type: "POST",
        url: link_load_config_menu,
        data:{"menuID":menuID,"pr_app":app_name, "pr_view":view_name},
        complete: function(event){
            var data = JSON.parse(event.responseText);
            $(".nav-tabs #title-param-custome").html(data[0]);
            $("#param-advance").html(data[1]);
        }
    }).done(function() {  });
}


// form-resource-edit: hien thi chu thich huong dan tung truong 1
$(function () {
    $(".form-resource-edit .node_introduct_fields .node_introduct_field").hide();
    $(".form-resource-edit .node_introduct_fields .node_introduct_field:first").show();
    $(".form-resource-edit .field-introduct").click(function(){
        var name = $(this).attr('name');
        var el = $(".form-resource-edit .node_introduct_fields .node_"+name);
        if($(el).hasClass("node_introduct_field")){
            $(".form-resource-edit .node_introduct_fields .node_introduct_field").hide();
            $(el).show();
        }
    });
});

$(function(){
    $(".btn-group-action .btn").click(function(){
        var v_for = $(this).attr('for');
        var v_type = $(this).attr('aria-checked');
        var v_value = $(this).attr('aria-value');
        $(this).parent().find(".btn").each(function(stt,el){
            $(el).removeClass("btn-"+ $(el).attr('aria-checked'));
        });
        $(this).addClass("btn-"+v_type);
        $("#"+v_for).val(v_value);
    });
});