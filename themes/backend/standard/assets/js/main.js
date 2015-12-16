/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function listItemTask( id, task ) {
    var f = document.adminForm;
    cb = eval( 'f.' + id );
    if (cb) {
        for (i = 0; true; i++) {
            cbx = eval('f.cb'+i);
            if (!cbx) break;
            cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        submitbutton(task,0);
    }
    return false;
} 


function submitbutton(pressbutton, type) {
    submitform(pressbutton, type);
}

function submitform(pressbutton, type) {
    // thay doi task
    if (type == 0 || type == undefined)
        document.adminForm.task.value = pressbutton;

    // thay doi action form
    if (type == 1)
        document.adminForm.action = pressbutton;

    if (typeof document.adminForm.onsubmit == "function") {
        document.adminForm.onsubmit();
    }
    document.adminForm.submit();
}

function hideMainMenu() {
    if (document.adminForm.hidemainmenu) {
        document.adminForm.hidemainmenu.value = 1;
    }
}

function checkAll(n, fldName) {
    if (!fldName) {
        fldName = 'cb';
    }
    var f = document.adminForm;
    var c = f.toggle.checked;
    var n2 = 0;
    for (i = 0; i < n; i++) {
        cb = eval('f.' + fldName + '' + i);
        if (cb) {
            cb.checked = c;
            n2++;
        }
    }
    if (c) {
        document.adminForm.boxchecked.value = n2;
    } else {
        document.adminForm.boxchecked.value = 0;
    }
    return true;
}

function isChecked(isitchecked) {
    if (isitchecked == true) {
        document.adminForm.boxchecked.value++;
    }
    else {
        document.adminForm.boxchecked.value--;
    }
}  

$(window).ready(function($) {
    $(function() {
        $(".JQsortable").sortable({update: successOrder});
        $(".JQsortable").disableSelection();
        $(".JQsortable").sortable("enable");
    });

    $('.JQtabs li').removeClass('active');
    $('.JQtabs li:first').addClass('active');
    $("#" + $('.JQtabs').attr('rel')).find("." + $('.JQtabs').attr('reldetail')).hide();
    $("#" + $('.JQtabs').attr('rel')).find("." + $('.JQtabs').attr('reldetail') + ":first").show();
    $('.JQtabs li').click(function() {
        $('.JQtabs li').removeClass('active');
        $("#" + $('.JQtabs').attr('rel')).find("." + $('.JQtabs').attr('reldetail')).hide();
        stt = $(this).attr('rel');
        $(this).addClass('active');
        $($("#" + $('.JQtabs').attr('rel')).find("." + $('.JQtabs').attr('reldetail'))[stt]).show();
    });

});

function successOrder(event, ui)
{
    fn = $(this).attr('rel');
    eval(fn + '()');
}  
// needed for Table Column ordering
function tableOrdering(order, dir, task) {
    var form = document.adminForm;
    form.filter_order.value = order;
    form.filter_order_Dir.value = dir;
    document.adminForm.submit();
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
         $("#changePermission").modal('hide');      
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
    $("#params_view").val(view_name);
    $("#params_layout").val(layout_name);
    document.adminForm.menu_type.value = app_name;
    if(app_name == "System"){
        $("#field_link").attr('readonly', false)
        $("#type").val("url");
    }else{
        $("#field_link").attr('readonly', true)
        var link = "index.php?app="+app_name+"&view="+view_name;
        if(layout_name != undefined && layout_name != "")
            link = link + "&layout="+layout_name;
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