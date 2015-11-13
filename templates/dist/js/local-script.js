/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var isftclpv = 1;
jwplayer().onDisplayClick(function(event) {
    jwplayer().play();
    if (isftclpv == 1) {
        var tag_script = $('<script/>', {src: "<?php echo $item['link_view']; ?>"});
        $("head").append(tag_script);
    }
    isftclpv = 0;
});


$('.info-social').hide();
function share_vide() {
    $('.info-social').toggle(200);
}

function share_facebook(title, caption, link, picture, description, redirect_uri) {
    var app_id = '1509847969331328';
    if (link == null)
        link = document.location.href;
    if (picture == null) {
        var all_img = $(".img-share-slide");
        if (all_img !== null && all_img.length !== 0)
            picture = $(".img-share-slide")[0].src;
        else
            picture = "";
    }
    if (title == null)
        title = document.title;
    if (caption == null)
        caption = $("meta[name='description']").attr("content");
    if (description == null)
        description = document.location.hostname;
    if (redirect_uri == null)
        redirect_uri = "http://" + document.location.hostname + '/simplecode/socialclosing.html';

    var linkshare = 'https://www.facebook.com/dialog/feed?';
    linkshare = linkshare + '&app_id=' + app_id;
    linkshare = linkshare + '&link=' + link;
    linkshare = linkshare + '&picture=' + picture;
    linkshare = linkshare + '&name=' + title;
    linkshare = linkshare + '&caption=' + caption;
    linkshare = linkshare + '&description=' + description;
    linkshare = linkshare + '&redirect_uri=' + redirect_uri;

    window.open(linkshare, "CM_OpenID", "width=" + 900 + ",height=" + 600 + ",resizable,scrollbars=yes,status=1");

//    var winTop = (screen.height / 2) - (window.innerHeight / 2);
//    var winLeft = (screen.width / 2) - (window.innerWidth / 2);
}

function sharingTweet(caption, picture, link) {

    if (caption == null)
        caption = $("meta[name='description']").attr("content");
    if (link == null)
        link = document.location.href;
    if (picture == null) {
        picture = "";
    }

    var linkshare = 'https://twitter.com/intent/tweet?';
    linkshare = linkshare + "text=" + caption;
    if (picture != '')
        linkshare = linkshare + " " + picture + " --@" + document.location.hostname;
    else
        linkshare = linkshare + " " + link + " --@" + document.location.hostname;

    window.open(linkshare, "CM_OpenID", "width=" + 900 + ",height=" + 600 + ",resizable,scrollbars=yes,status=1");
}

var isftcllv = 1;

function like_video(link_like) {
    if (isftcllv == 0)
        return;
    var tag_script = $('<script/>', {src: link_like});
    $("head").append(tag_script)
    isftcllv = 0;
    /*
     $.post(link_like, {s: Math.random() }, function (data) {
     if (data == 'false') {
     $.growl.warning({title: "Thông báo", message: "Bạn phải đăng nhập"});
     } else {
     $.growl.notice({title: "Thông báo", message: "Bạn đã thích video này"});
     }
     }); */
}