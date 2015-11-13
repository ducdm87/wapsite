/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ("undefined" == typeof (JSCookie)) {
    var JSCookie = {};
}
;

JSCookie = {
    arr_data: [],
    ck_name: "json_data_resume",
    expires: 365,
    init: function()
    {
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++)
        {
            var c = ca[i].trim();
            if (c.indexOf(JSCookie.ck_name) == 0)
            {
                string_data = c.substring(JSCookie.ck_name.length + 1, c.length);
                JSCookie.arr_data = JSON.parse((string_data));
            }
        }
    },
    set: function(_name, _value)
    {
        old_value = "";
        index = JSCookie.arr_data.length;
        for (var j = 0; j < JSCookie.arr_data.length; j++)
        {
            obj = JSCookie.arr_data[j];
            if (obj.name == _name) {
                old_value = obj.value;
                index = j;
                break;
            }
        }
        JSCookie.arr_data[index] = {name: _name, value: _value};
        JSCookie.save();
        return old_value;
    },
    get: function(_name, _value)
    {
        for (var j = 0; j < JSCookie.arr_data.length; j++)
        {
            obj = JSCookie.arr_data[j];
            if (obj.name == _name) {
                return obj.value;
            }
        }
        return _value;
    },
    remove: function(_name)
    {
        for (var j = 0; j < JSCookie.arr_data.length; j++)
        {
            obj = JSCookie.arr_data[j];
            old_value = obj.value;
            if (obj.name == _name) {
                JSCookie.arr_data[j] = null;
                JSCookie.save();
                return old_value;
            }
        }
        return "";
    },
    save: function()
    {
        arr_data_new = [];
        for (var j = 0; j < JSCookie.arr_data.length; j++)
        {
            obj = JSCookie.arr_data[j];
            if (obj !== null)
                arr_data_new[arr_data_new.length] = obj;
        }
        JSCookie.arr_data = arr_data_new;
        str_content = JSON.stringify(JSCookie.arr_data);
        var d = new Date();
        d.setTime(d.getTime() + (JSCookie.expires * 86400 * 1000));
        var expires = "expires=" + d.toGMTString();
        str_ck = JSCookie.ck_name + "=" + str_content + "; " + expires + "; path=/";
        document.cookie = str_ck;
    }
}

JSCookie.init();


