//function getnew_code(){$("#color_title_bg").css('background','#'+$("#color_title_bg").val());$("#color_title_cl").css('color','#'+$("#color_title_cl").val());$("#color_db_cl").css('color','#'+$("#color_db_cl").val());$("#manhung").val('<script type="text/javascript" src="'+uri_root+'public/client/js/jquery-1.7.2.js"></script><link rel="stylesheet" type="text/css" href="'+uri_root+'public/client/css/demo.css"/><div id="box_kqxs"><script type="text/javascript">bgcolor="#'+$("#color_title_bg").val()+'";titlecolor="#'+$("#color_title_cl").val()+'";dbcolor="#'+$("#color_db_cl").val()+'";fsize="'+$("#color_size").val()+'";kqwidth="'+$("#color_crong").val()+'";tt="'+$("#color_tt").is(":checked")+'";</script><script type="text/javascript" src="'+uri_root+'getkqxs-'+$("#box_kqxs_tinhx").val()+'.js"></script><a href="'+uri_root+'">Kết quả xổ số tại Xổ Số.Com</a></div>');$("#xemtruoc").html('<div id="box_kqxs"><script type="text/javascript">bgcolor="#'+$("#color_title_bg").val()+'";titlecolor="#'+$("#color_title_cl").val()+'";dbcolor="#'+$("#color_db_cl").val()+'";fsize="'+$("#color_size").val()+'";kqwidth="'+$("#color_crong").val()+'";tt="'+$("#color_tt").is(":checked")+'";</script ><script type="text/javascript" src="'+uri_root+'getkqxs-'+$("#box_kqxs_tinhx").val()+'.js">'+"</script>"+'<a href="'+uri_root+'">Kết quả xổ số tại Xổ Số.Com</a></div>')}$('#color_title_bg, #color_title_cl, #color_db_cl').ColorPicker({onSubmit:function(hsb,hex,rgb,el){$(el).val(hex);$(el).ColorPickerHide();getnew_code()},onBeforeShow:function(){$(this).ColorPickerSetColor(this.value)}}).bind('keyup',function(){$(this).ColorPickerSetColor(this.value)});

function getnew_code() {
    $("#color_title_bg").css('background', '#' + $("#color_title_bg").val());
    $("#color_title_cl").css('color', '#' + $("#color_title_cl").val());
    $("#color_db_cl").css('color', '#' + $("#color_db_cl").val());
    $("#manhung").val('<script type="text/javascript" src="' + uri_root + 'public/client/js/jquery-1.7.2.js"></script><link rel="stylesheet" type="text/css" href="' + uri_root + 'public/client/css/demo.css"/><div id="box_kqxs"><script type="text/javascript">bgcolor="#' + $("#color_title_bg").val() + '";titlecolor="#' + $("#color_title_cl").val() + '";dbcolor="#' + $("#color_db_cl").val() + '";fsize="' + $("#color_size").val() + '";kqwidth="' + $("#color_crong").val() + '";tt="' + $("#color_tt").is(":checked") + '";</script><script type="text/javascript" src="' + uri_root + 'getkqxs-' + $("#box_kqxs_tinhx").val() + '.js"></script><a href="' + uri_root + '">Kết quả xổ số tại Xổ Số.Com</a></div>');
    $("#xemtruoc").html('<div id="box_kqxs"><script type="text/javascript">bgcolor="#' + $("#color_title_bg").val() + '";titlecolor="#' + $("#color_title_cl").val() + '";dbcolor="#' + $("#color_db_cl").val() + '";fsize="' + $("#color_size").val() + '";kqwidth="' + $("#color_crong").val() + '";tt="' + $("#color_tt").is(":checked") + '";</script ><script type="text/javascript" src="' + uri_root + 'getkqxs-' + $("#box_kqxs_tinhx").val() + '.js">' + "</script>" + '<a href="' + uri_root + '">Kết quả xổ số tại Xổ Số.Com</a></div>');
}
$('#color_title_bg, #color_title_cl, #color_db_cl').ColorPicker( {
    onSubmit : function (hsb, hex, rgb, el) {
        $(el).val(hex);
        $(el).ColorPickerHide();
        getnew_code();
    }
    , onBeforeShow : function () {
        $(this).ColorPickerSetColor(this.value);
    }
}
).bind('keyup', function () {
    $(this).ColorPickerSetColor(this.value);
}
);