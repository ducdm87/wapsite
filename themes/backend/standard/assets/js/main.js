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

function resumeFieldShowBox(field_id)
{
    data = obj_data_sub_client[field_id];
    $("#add-sub-field").attr("rel", field_id);
    $("#data_name").val(data.name);
    $("#valid_data").val(data.valid_data);
    $("#default_value").val(data.default_value);
    $("#space_before").val(data.space_before);
    $("#data_size").val(data.size);
    $("#data_type").val(data.data_type);
    if(parseInt(data.required) == 1)
    {
        $("#data_required").prop('checked', true);
    }
    else $("#data_required").removeAttr('checked');

    $('#list-data-sub-field').empty();
    $("#list-data-sub-field").hide();
    if (data.data_type == 4)
    {
        field_sub_select = data.field_sub_select;
        stt = 1;
        for (var key in field_sub_select)
        {
            sub_select = field_sub_select[key];
            addFieldSelect(key, sub_select);
            stt = 0;
        }
        if (stt == 1)
            addFieldSelect("", "");
        $("#list-data-sub-field").show();
    } else if (data.data_type == 7) {
        field_sub_select = data.field_sub_select;
        stt = 1;
        for (var key in field_sub_select)
        {
            sub_select = field_sub_select[key];
            addFieldSelect(key, sub_select, 1);
            stt = 0;
        }
        if (stt == 1)
            addFieldSelect("", "", 1);
        $("#list-data-sub-field").show();
    }

    $('#display-field-sub tr').css({color: '#666666'});
    $('#display-field-sub tr[rel=' + field_id + ']').css({color: 'red'});
}

function addFieldSelect(_name, _value, hidebtn)
{
    div = jQuery('<div/>', {class: 'item input-box'}).appendTo('#list-data-sub-field');
    jQuery('<input/>', {class: 'inputbox input-text medium', name: _name, type: "text", value: _value}).appendTo(div);

    if (hidebtn == undefined)
    {
        if ($('#list-data-sub-field').find('.item').length > 1)
            jQuery('<img/>', {src: '/admin/templates/standard/assets/images/delete-icon.png', class: "delete-item"}).appendTo(div);
        else
            jQuery('<img/>', {src: '/admin/templates/standard/assets/images/add-icon.png', class: "add-item"}).appendTo(div);
    }
}

function resumeFieldDisplay()
{
    $("#display-field-sub tbody").empty();
    tbody = $("#display-field-sub tbody");

    k = 0;
    stt = 1;
    for (var key in obj_data_sub_order_client)
    {
        field_id = obj_data_sub_order_client[key];
        data = obj_data_sub_client[field_id];
        _class = 'row' + k + " ui-state-default";
        tr = jQuery('<tr/>', {rel: field_id, class: _class}).appendTo(tbody);
        jQuery('<td/>', {align: 'center', html: stt}).appendTo(tr);
        action = '<div style="width: 60px;"> <a class="btn-field-delete btn-delete btn-controls" rel="' + field_id + '"></a> <a class="btn-field-edit btn-edit btn-controls" rel="' + field_id + '"></a> </div>';
        jQuery('<td/>', {align: 'center', html: action}).appendTo(tr);
        jQuery('<td/>', {html: data.name}).appendTo(tr);
        jQuery('<td/>', {align: 'center', html: data.size}).appendTo(tr);
        jQuery('<td/>', {align: 'center', html: data.required?"true":false}).appendTo(tr);        
        jQuery('<td/>', {align: 'center', html: obj_data_type_client[data.data_type]}).appendTo(tr);
        k = 1 - k;
        stt++;
    }
}


$(window).ready(function($) {

// sua field
    $(document).delegate("#edit-field .btn-controls", "click", function() {
        field_id = $(this).attr('rel');
        if ($(this).hasClass('btn-field-edit')) {
            resumeFieldShowBox(field_id);
            $("#add-sub-field").attr("rel", field_id);
            return false;
        } else if ($(this).hasClass('btn-field-delete')) {
            link_call = link_removesubfield;
            _data_type = obj_data_sub_client[field_id].data_type;
            $.ajax({
                url: link_call,
                type: "POST", // can GET
                'data': {subfield_id: field_id, data_type: _data_type, action: 'removesubfield'},
                dataType: "html",
                complete: (function(event) {
                    result = JSON.parse(event.responseText);
                    if (result.result == false)
                    {
                        alert(result.str_error);
                    }
                })
            }).done(function(html) {
            });
            parent = $("#display-field-sub").find('tr[rel=' + field_id + ']');
            parent.animate({"opacity": "0", "height": 0, "width": 0}, 300, function() {
                parent.remove();
            });
        }
        return false;
    });

// them moi
    $(document).delegate("#add-record", "click", function() {
        $("#data_name").val("");
        $("#data_size").val("");
        $("#default_value").val("");
        $("#data_type").val(1);
        $("#add-sub-field").attr("rel", "N");
        $('#list-data-sub-field').empty();
        return false;
    });

// them, luu
    $(document).delegate("#add-sub-field", "click", function() {
        data_name = $("#data_name").val();
        _valid_data = $("#valid_data").val();
        _default_value = $("#default_value").val();
        _space_before = $("#space_before").val();
        data_size = $("#data_size").val();
        data_required = $('#data_required').is(':checked')?1:0;
        data_type = $("#data_type").val();
//        if (data_name == "") {
//            alert("Please input field name ");
//            $("#data_name").focus();
//            return false;
//        }
        if (data_size == "") {
            alert("Please input field size");
            $("#data_size").focus();
            return false;
        }


        field_id = $(this).attr('rel');
        if (field_id == "N") {
            field_id = "N" + obj_data_sub_order_client.length;
            obj_data_sub_order_client[obj_data_sub_order_client.length] = field_id;
        }
        field_sub_select = {};
        if (data_type == 4 || data_type == 7) {
            arr = $('#list-data-sub-field input.inputbox');
            stt = 1;
            for (var i = 0; i < arr.length; i++)
            {
                obj = arr[i];
                name = $(obj).attr('name');
                val = $(obj).val();
                if (name == "")
                    name = "N" + stt;
                field_sub_select[name] = val;
                stt++;
            }
        }
        obj_data_sub_client[field_id] = {name: data_name, size: data_size, valid_data: _valid_data, default_value: _default_value, space_before: _space_before, required :data_required, "data_type": data_type, "field_sub_select": field_sub_select};
        resumeFieldDisplay();
        $("#obj_data_sub_client").val(JSON.stringify(obj_data_sub_client));
        $("#obj_data_sub_order_client").val(JSON.stringify(obj_data_sub_order_client));

        $('#status-order-field').show();
        $('#status-order-field').html("Successfully change field sub to " + data_name);
        setTimeout(function() {
            $('#status-order-field').hide()
        }, 5000);
        return false;
    });

    $(document).delegate("#list-data-sub-field .add-item", "click", function() {
        addFieldSelect("", "");
        return false;
    });
    $(document).delegate("#list-data-sub-field .delete-item", "click", function() {
        $(this).parent().remove();
        return false;
    });

    $(document).delegate("#data_type", "change", function() {
        data_type = $("#data_type").val();
        if (data_type == 4) {
            $('#list-data-sub-field').show();
            if ($('#list-data-sub-field').find('.item').length < 1)
                addFieldSelect("", "");
        } else if (data_type == 7) {
            $('#list-data-sub-field').show();
            $('#list-data-sub-field').empty();
            if ($('#list-data-sub-field').find('.item').length < 1)
            {
                addFieldSelect("", "", 1);
                addFieldSelect("", "", 1);
            }
        }
        else {
            $('#list-data-sub-field').hide();
        }
        return false;
    });


    $(document).delegate("#edit-template .listfield li .btn-edit", "click", function() {
        parent = $(this).parent().parent();
        $("#edit-template .listfield li .field-detail").hide();
        $("#edit-template .listfield li").removeClass('hover');
        $("#edit-template .listfield li .arrow").hide();
        $(parent).find('.field-detail').show();
        $(parent).addClass('hover');
        $(parent).find('.arrow').show();
        return false;
    });

    $(document).delegate("#edit-template .btn-close-edit-box", "click", function() {
        $("#edit-template .listfield li .field-detail").hide();
        $("#edit-template .listfield li").removeClass('hover');
        $("#edit-template .listfield li .arrow").hide();
        return false;
    });

    $(document).delegate(".preview-template", "click", function() {
        $("#sbox-window").show();
        $("#sbox-overlay").show();
        href = $(this).attr('href');
        showPreview(href);
        return false;
    });

    $(document).delegate("#sbox-overlay", "click", function() {
        $("#sbox-window").hide();
        $("#sbox-overlay").hide();
        return false;
    });
    $(document).delegate("#sbox-btn-close", "click", function() {
        $("#sbox-window").hide();
        $("#sbox-overlay").hide();
        $('#control-slide').hide();
        return false;
    });
    $(document).delegate(".form-resumes .btn-controls-16", "click", function() {
        if ($(this).hasClass('btn-preview-16')) {
            $(this).addClass('showing-preview');
            $("#sbox-window").show();
            $("#sbox-overlay").show();
            href = $(this).attr('href');
            h = $('#sbox-window').height()/2 + 60;
            h = h*-1;
            $('#control-slide .buttun').css({top: h+'px'});
//            $('#control-slide').show();
            showPreview(href);
            return false;
        } else if ($(this).hasClass('btn-trash-16')) {
            $(this).parent().parent().addClass('resume-moveing');
            link_call = $(this).attr('href');
            $.ajax({
                url: link_call,
                type: "POST", // can GET               
                dataType: "html",
                complete: (function(event) {
                    $('.resume-moveing').animate({opacity: 0}, 500, function() {
                        $('.resume-moveing').remove();
                    });
                })
            }).done(function(html) {
            });
        }
        return false;
    });

    $(document).delegate("#list-trash .btn-controls-16", "click", function() {
        if ($(this).hasClass('btn-preview-16')) {
            $("#sbox-window").show();
            $("#sbox-overlay").show();
            href = $(this).attr('href');
            showPreview(href);
            return false;
        } else if ($(this).hasClass('btn-revert-16') || $(this).hasClass('btn-delete-16')) {
            var bool = confirm("Are you sure?");
            if(bool == false) return false;
            link_call = $(this).attr('href');
            $(this).parent().parent().addClass('resume-processing');
            $.ajax({
                url: link_call,
                type: "POST", // can GET               
                dataType: "html",
                complete: (function(event) {
                    $('.resume-processing').animate({opacity: 0}, 500, function() {
                        $('.resume-processing').remove();
                    });
                })
            }).done(function(html) {
            });
        }
        return false;
    });

});

call_times = 0;

function showPreview(href)
{
    if (call_times == 0) {
        call_times = 1;
        $(window).resize(function() {
            showPreview();
        });
    }
    h = $(window).height();
    w = $(window).width();
//    console.log(Math.random() + ' aaaaa');
    sbw_h = h - 80;
    sbw_w = w - 400;
    $("#sbox-window").height(sbw_h);
    $("#sbox-window").width(sbw_w);
    $("#sbox-window").css({top: '50px', left: '200px', margin: '0'});
    ifr_h = sbw_h - 30;
    ifr_w = sbw_w - 10;
    if (href != undefined)
    {
        $("#sbox-content").empty();
        iframe = jQuery('<iframe/>', {src: href, width: ifr_w + "px", height: ifr_h + "px", frameborder: "0"}).appendTo("#sbox-content");
    }
    else {
        iframe = $("#sbox-content").find('iframe');
        iframe.attr({width: ifr_w + "px", height: ifr_h + "px"});
        iframe.css({width: ifr_w + "px", height: ifr_h + "px"});
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
/**
 * Comment
 */
function saveOrderSubField() {
    arr_state = $('.tablesubfield').find('.ui-state-default');
    obj_data_sub_order_client = [];
    for (i = 0; i < arr_state.length; i++)
    {
        state = $(arr_state[i]).attr('rel');
        obj_data_sub_order_client[obj_data_sub_order_client.length] = state;
    }
    $("#obj_data_sub_order_client").val(JSON.stringify(obj_data_sub_order_client));
    resumeFieldDisplay();
    link_call = document.location;
}

function saveOrderFields() {
    arr_state = $('.tablefields').find('.ui-state-default');
    arr_order = [];
    for (i = 0; i < arr_state.length; i++)
    {
        state = $(arr_state[i]).attr('rel');
        arr_order[arr_order.length] = state;
    }

    link_call = document.location;
    $.ajax({
        url: link_call,
        type: "POST", // can GET   
        data: {cids: arr_order, action: 'order_fields'},
        dataType: "html",
        complete: (function(event) {
//            $('#status-order-field').show();
//            $('#status-order-field').html("Successfully order sub field");
//            setTimeout(function(){ $('#status-order-field').hide()}, 5000);
        })
    }).done(function(html) {
    });
}

function saveOrderTemplates() {
    arr_state = $('.tabletemplate').find('.ui-state-default');
    arr_order = [];
    for (i = 0; i < arr_state.length; i++)
    {
        state = $(arr_state[i]).attr('rel');
        arr_order[arr_order.length] = state;
    }

    link_call = document.location;
    $.ajax({
        url: link_call,
        type: "POST", // can GET   
        data: {cids: arr_order, action: 'order_template'},
        dataType: "html",
        complete: (function(event) {
//            $('#status-order-field').show();
//            $('#status-order-field').html("Successfully order sub field");
//            setTimeout(function(){ $('#status-order-field').hide()}, 5000);
        })
    }).done(function(html) {
    });
}

// needed for Table Column ordering
function tableOrdering(order, dir, task) {
    var form = document.adminForm;
    form.filter_order.value = order;
    form.filter_order_Dir.value = dir;
    document.adminForm.submit();
} 