function dlg(c,a,b){
    if(!a){
        a="auto";
    }
    if(!b){
        b="auto";
    }
    $("#"+c).dialog("close");
    $("#"+c).dialog({
        height:b,
        width:a,
        dialogClass:"dialogWithDropShadow"
    }).height("auto");
    return false;
}
function printSelection(c,d){
    var b=c.innerHTML;
    var a=window.open("","_blank","width=500,height=500");
    a.document.open();
    a.document.write("<html><head><title>"+d+'</title><link type="text/css" href="'+uri_root+'public/client/css/print.css" rel="stylesheet" /></head><body onload="window.print();window.close()">'+b+"</body></html>");
    a.document.close();
}
function selectText(b){
    if(document.selection){
        var a=document.body.createTextRange();
        a.moveToElementText(document.getElementById(b));
        a.select()
    }else{
        if(window.getSelection){
            var a=document.createRange();
            a.selectNode(document.getElementById(b));
            window.getSelection().addRange(a)
        }
    }
}
function showcau(g,b,a,f,c,d){
    $("#showcauarea").html("<img src=\""+uri_root+"public/client/images/icon-xs/007.gif\" width=\"145\" height=\"15\" alt=\"\" />");
    var e="showcau&ngay="+b+"&limit="+a+"&lon="+f+"&db="+c+"&vt="+g+"&nhay="+d;
    $.ajax({
        url:uri_root+"soicau_sendhtml?"+e,
        success:function(h){
            if(h){
                $("#showcauarea").html(h)
            }
        }
    });
    location.hash = e;
}
function cau_link_set_active(a){
    $("a.a_cau").removeClass("a_cau_active");
    $('a.a_cau[title$="'+a+'"]').addClass("a_cau_active");
}
function showcaufromhash(){
    if(location.hash){
        var e,a=/\+/g,r=/([^&=]+)=?([^&]*)/g,d=function(s){
            return decodeURIComponent(s.replace(a," "))
        },str=window.location.hash.substring(1);
        var hash_showcau,hash_ngay,hash_vt,hash_limit,hash_lon,hash_db=0,hash_nhay=1;
        while(e=r.exec(str)){
            if(e[1]=="showcau"){
                var hash_showcau=1
            }else{
                if(e[1]&&e[2]){
                    eval("hash_"+d(e[1])+'="'+d(e[2])+'";')
                }
            }
        }
        if(hash_showcau&&hash_vt){
            cau_link_set_active(hash_vt);
            showcau(hash_vt,hash_ngay,hash_limit,hash_lon,hash_db,hash_nhay)
        }
    }
}
function vt_unselect(){
    $('span.vt_selecting').removeClass('vt_selecting');
    $("span.vt_connect_click").removeClass("vt_connect_click");
    $("span.vt_connect").removeClass('vt_connect');
}
function matrancaudlg(id){
    $("div.matrancau_dlg").dialog('close');
    $("#"+id).dialog({
        height: 520, 
        width: 450, 
        dialogClass: 'dialogWithDropShadow'
    }).height("auto");
    return false;
}
$("span.cocau").hover(function(){
    $(this).addClass("vt_hover")
},function(){
    $(this).removeClass("vt_hover")
});
$('a.a_cau').click(function(){
    cauclick(this);
    return false;
});