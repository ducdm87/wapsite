function setCookie(a, d, b) {
    var e = new Date();
    e.setDate(e.getDate() + b);
    var c = escape(d) + ((b == null) ? "" : "; expires=" + e.toUTCString());
    document.cookie = a + "=" + c
}

function getCookie(b) {
    var c, a, e, d = document.cookie.split(";");
    for (c = 0; c < d.length; c++) {
        a = d[c].substr(0, d[c].indexOf("="));
        e = d[c].substr(d[c].indexOf("=") + 1);
        a = a.replace(/^\s+|\s+$/g, "");
        if (a == b) {
            return unescape(e)
        }
    }
}

function number_format(f, c, h, e) {
    f = (f + "").replace(/[^0-9+\-Ee.]/g, "");
    var b = !isFinite(+f) ? 0 : +f,
        a = !isFinite(+c) ? 0 : Math.abs(c),
        l = (typeof e === "undefined") ? "," : e,
        d = (typeof h === "undefined") ? "." : h,
        k = "",
        g = function(p, o) {
            var m = Math.pow(10, o);
            return "" + Math.round(p * m) / m
        };
    k = (a ? g(b, a) : "" + Math.round(b)).split(".");
    if (k[0].length > 3) {
        k[0] = k[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, l)
    }
    if ((k[1] || "").length < a) {
        k[1] = k[1] || "";
        k[1] += new Array(a - k[1].length + 1).join("0")
    }
    return k.join(d)
}

function selectText(b) {
    if (document.selection) {
        var a = document.body.createTextRange();
        a.moveToElementText(document.getElementById(b));
        a.select()
    } else {
        if (window.getSelection) {
            var a = document.createRange();
            a.selectNode(document.getElementById(b));
            window.getSelection().addRange(a)
        }
    }
}

function picker(a) {
    $("#" + a).datepicker({
        yearRange: 2007 + ":" + year,
        monthNamesShort: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        showAnim: ""
    })
}

function birthpicker(a) {
    $("#" + a).datepicker({
        yearRange: (year - 100) + ":" + (year - 15),
        monthNamesShort: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        showAnim: ""
    })
}

function loadImg(b) {
    var a = new Image();
    a.src = b;
    return a
}

function mousestick(c, g) {
    var d = 20;
    var b = 10;
    var k = g.pageX + d;
    var h = g.pageY + b;
    var f = $(c).width();
    var a = $(c).height();
    var m = $(window).width() - (k - $(window).scrollLeft() + f);
    var l = $(window).height() - (h - $(window).scrollTop() + a);
    if (m < 20) {
        k = g.pageX - f - d
    }
    if (l < 20) {
        h = g.pageY - a - b
    }
    $(c).css("top", h + "px").css("left", k + "px").fadeIn("fast")
}

function showtip(b, c, a) {
    $(".tipcontent").hide();
    $(".tiparrow").hide();
    var e = new Date().getTime();
    $(b).addClass("tip_hover");
    var f = $("<span id='tipcontent" + e + "' class=tipcontent><span class='tipcontent_inner'>" + c + "</span></span>");
    var d = $("<span id='tiparrow" + e + "' class='tiparrow'>&nbsp;</span>");
    $("body").append(f);
    $("body").append(d);
    f.css("left", $(b).offset().left);
    f.css("top", $(b).offset().top - f.height() - 7);
    d.css("left", $(b).offset().left + 2);
    d.css("top", $(b).offset().top - 9);
    if (a) {
        setTimeout("$('#tipcontent" + e + "').remove(); $('#tiparrow" + e + "').remove(); $('" + b + "').removeClass('tip_hover')", a)
    }
}

function getmaxZ() {
    var a = Math.max.apply(null, $.map($("body > *"), function(b, c) {
        if ($(b).css("position") != "static") {
            return parseInt($(b).css("z-index")) || 1
        }
    }));
    return a
}

function hovertip(c, b) {
    var a = getmaxZ();
    $(c).hover(function(g) {
        hovertipcontent = $(this).attr("rel");
        $(this).addClass("tip_hover");
        var f = $("<span class=tipcontent style='z-index:" + a + "'><span class='tipcontent_inner'>" + hovertipcontent + "</span></span>");
        var d = $("<span class='tiparrow' style='z-index:" + a + "'>&nbsp;</span>");
        $("body").append(f).append(d);
        if (b) {
            f.css("right", $(window).width() - $(this).offset().left - $(this).width());
            d.css("right", $(window).width() - $(this).offset().left - $(this).width() + 5)
        } else {
            f.css("left", $(this).offset().left);
            d.css("left", $(this).offset().left + 5)
        }
        f.css("top", $(this).offset().top - f.height() - 6);
        d.css("top", $(this).offset().top - 8)
    }, function() {
        $(this).removeClass("tip_hover");
        $(".tipcontent").remove();
        $(".tiparrow").remove()
    });
    $(c).removeClass("new")
}

function flipclass(e, a, d, b, c) {
    b = b || 500;
    if ($(e).length && (c || !$(e).hasClass("flipping"))) {
        if (!c) {
            $(e).addClass("flipping")
        }
        d--;
        if (d >= 0) {
            if ($(e).hasClass(a)) {
                $(e).removeClass(a)
            } else {
                $(e).addClass(a)
            }
            setTimeout(function() {
                flipclass(e, a, d, b, 1)
            }, b)
        } else {
            $(e).removeClass(a);
            $(e).removeClass("flipping")
        }
    } else {
        $(e).removeClass(a)
    }
}

function closable(b, a) {
    $(b).each(function() {
        $(this).css("position", "relative");
        $(this).hover(function() {
            var c = $("<a class='closebutton' href='#'>&nbsp;</a>");
            c.click(function() {
                $(this).parent().hide("fast", function() {
                    $(this).remove()
                });
                if (a) {
                    a()
                }
                return false
            });
            $(this).append(c)
        }, function() {
            $(this).find(".closebutton").remove()
        })
    })
}

function spread(b, f, c) {
    c = c || 0;
    if ($("a.spreading").length) {
        setTimeout(function() {
            spread(b, f, c)
        }, 20000)
    } else {
        var a = [];
        if (b.length) {
            var d = b.eq(Math.round(Math.random() * b.length));
            var e = d.clone();
            d.html("&nbsp;");
            d.after(e);
            d.addClass("spreading");
            d.css({
                position: "fixed",
                "z-index": "2000",
                top: "0",
                left: "0",
                background: "none",
                width: "100%",
                height: "100%",
                cursor: "default"
            });
            d.appendTo("#middle");
            d.click(function() {
                $(this).remove();
                setTimeout(function() {
                    $.ajax({
                        url: uri_root + "client/chat/logclk?chanel=" + f + "&url=" + encodeURIComponent(d.attr("href")),
                        type: "PUT"
                    })
                }, 3000)
            })
        } else {
            if (c < 10) {
                setTimeout(function() {
                    spread(b, f, c + 1)
                }, 10000)
            }
        }
    }
}

function trackdbupdate(a, b, c) {
    $.ajax({
        url: uri_root + "client/chat/trackupdate?act=" + a + "&num=" + b,
        success: function(d) {
            if (d) {
                if ((d == "ok") && c) {
                    c()
                }
            } else {}
        }
    })
}

function track_link_click(b, c) {
    if ($(b).html() == "Track") {
        trackdbupdate("add", c, function() {
            $("#" + $(b).attr("id")).html("Untrack")
        })
    } else {
        trackdbupdate("remove", c, function() {
            $("#" + $(b).attr("id")).html("Track")
        })
    }
}

function betdbupdate(c, b, a, e, d, f) {
    $.ajax({
        url: uri_root + "lol_betupdate?range=" + c + "&bet=" + b + "&ngay=" + a + "&bettype=" + e,
        cache: false,
        success: function(g) {
            if (f) {
                f(g)
            }
        }
    })
}

function lo(a) {
    a += "";
    return a.charAt(a.length - 2) + a.charAt(a.length - 1)
}

function dau(c, a) {
    var b = "";
    for (j in c) {
        if (c[j].charAt(c[j].length - 2) == a) {
            if (lo(c[j]).length) {
                b += (b ? ", " : "") + lo(c[j])
            }
        }
    }
    if (!b) {
        b = "&nbsp;"
    }
    return b
}

function updatedau(a) {
    for (i = 0; i < 10; i++) {
        $(".dau_" + i).html(dau(a, i))
    }
}

function dit(c, a) {
    var b = "";
    for (j in c) {
        if (c[j].charAt(c[j].length - 1) == a) {
            if (lo(c[j]).length) {
                b += (b ? ", " : "") + lo(c[j])
            }
        }
    }
    if (!b) {
        b = "&nbsp;"
    }
    return b
}

function updatedit(a) {
    for (i = 0; i < 10; i++) {
        $(".dit_" + i).html(dit(a, i))
    }
}

function kq_tbl(b, d, a) {
    if (a) {
        var c = "<table class=ketqua cellspacing=0 cellpadding=5>";
        c += "<tr><th colspan=2 class='kq_ngay'>Mở thưởng " + getwday(b) + " ngày " + b + "</th></tr>";
        c += "<tr class=row1><td class='leftcol'>ĐB</td><td class=kq_0>" + d[0] + "</td></tr>";
        c += "<tr class=row2><td class='leftcol'>Nhất</td><td class='kq_1'>" + d[1] + "</td></tr>";
        c += "<tr class=row1><td class='leftcol'>Nhì</td><td><span class='kq_2'>" + d[2] + "</span> - <span class='kq_3'>" + d[3] + "</span></td></tr>";
        c += "<tr class=row2><td class='leftcol'>Ba</td><td><span class='kq_4'>" + d[4] + "</span> - <span class='kq_5'>" + d[5] + "</span> - <span class='kq_6'>" + d[6] + "</span> - <span class='kq_7'>" + d[7] + "</span> - <span class='kq_8'>" + d[8] + "</span> - <span class='kq_9'>" + d[9] + "</span></td></tr>";
        c += "<tr class=row1><td class='leftcol'>Tư</td><td><span class='kq_10'>" + d[10] + "</span> - <span class='kq_11'>" + d[11] + "</span> - <span class='kq_12'>" + d[12] + "</span> - <span class='kq_13'>" + d[13] + "</span></td></tr>";
        c += "<tr class=row2><td class='leftcol'>Năm</td><td><span class='kq_14'>" + d[14] + "</span> - <span class='kq_15'>" + d[15] + "</span> - <span class='kq_16'>" + d[16] + "</span> - <span class='kq_17'>" + d[17] + "</span> - <span class='kq_18'>" + d[18] + "</span> - <span class='kq_19'>" + d[19] + "</span></td></tr>";
        c += "<tr class=row1><td class='leftcol'>Sáu</td><td><span class='kq_20'>" + d[20] + "</span> - <span class='kq_21'>" + d[21] + "</span> - <span class='kq_22'>" + d[22] + "</span></td></tr>";
        c += "<tr class=row2><td class='leftcol'>Bảy</td><td><span class='kq_23'>" + d[23] + "</span> - <span class='kq_24'>" + d[24] + "</span> - <span class='kq_25'>" + d[25] + "</span> - <span class='kq_26'>" + d[26] + "</span></td></tr>";
        c += "</table>"
    } else {
        var c = "<table class=ketqua cellspacing=1 cellpadding=9>";
        c += "<thead><tr><th colspan=13>Mở thưởng " + getwday(b) + " ngày " + normaldate(b) + "</th></tr></thead>";
        c += "<tr class=row1><td class='leftcol'>ĐB</td><td colspan=12 class=kq_0>" + d[0] + "</td></tr>";
        c += "<tr class=row2><td class='leftcol'>Nhất</td><td colspan=12>" + d[1] + "</td></tr>";
        c += "<tr class=row1><td class='leftcol'>Nhì</td><td colspan=6>" + d[2] + "</td><td colspan=6>" + d[3] + "</td></tr>";
        c += "<tr class=row2><td rowspan=2 class='leftcol'>Ba</td><td colspan=4>" + d[4] + "</td><td colspan=4>" + d[5] + "</td><td colspan=4>" + d[6] + "</td></tr>";
        c += "<tr><td colspan=4>" + d[7] + "</td><td colspan=4>" + d[8] + "</td><td colspan=4>" + d[9] + "</td></tr>";
        c += "<tr class=row1><td class='leftcol'>Tư</td><td colspan=3>" + d[10] + "</td><td colspan=3>" + d[11] + "</td><td colspan=3>" + d[12] + "</td><td colspan=3>" + d[13] + "</td></tr>";
        c += "<tr class=row2><td rowspan=2 class='leftcol'>Năm</td><td colspan=4>" + d[14] + "</td><td colspan=4>" + d[15] + "</td><td colspan=4>" + d[16] + "</td></tr>";
        c += "<tr><td colspan=4>" + d[17] + "</td><td colspan=4>" + d[18] + "</td><td colspan=4>" + d[19] + "</td></tr>";
        c += "<tr class=row1><td class='leftcol'>Sáu</td><td colspan=4>" + d[20] + "</td><td colspan=4>" + d[21] + "</td><td colspan=4>" + d[22] + "</td></tr>";
        c += "<tr class=row2><td class='leftcol'>Bảy</td><td colspan=3>" + d[23] + "</td><td colspan=3>" + d[24] + "</td><td colspan=3>" + d[25] + "</td><td colspan=3>" + d[26] + "</td></tr>";
        c += "<tr class=lastrow><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
        c += "</table>"
    }
    return c
}

function dau_tbl(b) {
    var a = "<table class=dau cellspacing=1 cellpadding=9><tr><th>Đầu</th><th>&nbsp;</th>";
    for (i = 0; i < 10; i++) {
        a += "<tr><td class='leftcol'>" + i + "</td><td>" + dau(b, i) + "</td></tr>"
    }
    a += "</table>";
    return a
}

function dit_tbl(b) {
    var a = "<table class=dit cellspacing=1 cellpadding=9><tr><th>Đít</th><th>&nbsp;</th>";
    for (i = 0; i < 10; i++) {
        a += "<tr><td class='leftcol'>" + i + "</td><td>" + dit(b, i) + "</td></tr>"
    }
    a += "</table>";
    return a
}

function solo(c, a) {
    var b = [0, 0];
    for (i in c) {
        if (lo(c[i]) == a) {
            b[0]++;
            if (i == 0) {
                b[1] = 1
            }
        }
    }
    return b
}

function sodau(c, a) {
    var b = [0, 0];
    for (i in c) {
        if (c[i].charAt(c[i].length - 2) == a) {
            b[0]++;
            if (i == 0) {
                b[1] = 1
            }
        }
    }
    return b
}

function sodit(c, a) {
    var b = [0, 0];
    for (i in c) {
        if (c[i].charAt(c[i].length - 1) == a) {
            b[0]++;
            if (i == 0) {
                b[1] = 1
            }
        }
    }
    return b
}

function msgsw(a) {
    if ($("#" + a).is(":visible")) {
        $("#" + a).hide("fast")
    } else {
        $("#" + a).show("fast")
    }
}

function printSelection(c, d) {
    var b = c.innerHTML;
    var a = window.open("", "_blank", "width=500,height=500");
    a.document.open();
    a.document.write("<html><head><title>" + d + '</title><link type="text/css" href="css/print.css" rel="stylesheet" /></head><body onload="window.print();window.close()">' + b + "</body></html>");
    a.document.close()
}

function dlg(c, a, b) {
    if (!a) {
        a = "auto"
    }
    if (!b) {
        b = "auto"
    }
    $("#" + c).dialog("close");
    $("#" + c).dialog({
        height: b,
        width: a,
        dialogClass: "dialogWithDropShadow"
    }).height("auto");
    return false
}

function pagemove(a, c, b) {
    $("span." + a).each(function(f, e) {
        var h = $(e).find("a").length;
        var g = parseInt($(e).find("a:visible:last").html()) - 1;
        var d = parseInt($(e).find("a:visible:first").html()) - 1;
        if (b && g < h - 1 || !b && d > 0) {
            $(e).find("a").each(function(l, m) {
                if (b) {
                    var k = l > g && l <= g + c
                } else {
                    var k = l < d && l >= d - c
                }
                if (k) {
                    $(m).show()
                } else {
                    $(m).hide()
                }
            })
        }
    })
}

function showcau(g, b, a, f, c, d) {
    $("#showcauarea").html("<img src='" + uri_root + "public/client/images/loading2.gif' />");
    var e = "showcau&ngay=" + b + "&limit=" + a + "&lon=" + f + "&db=" + c + "&vt=" + g + "&nhay=" + d;
    $.ajax({
        url: uri_root + "client/chat/soicau?sendhtml&" + e,
        success: function(h) {
            if (h) {
                $("#showcauarea").html(h)
            }
        }
    });
    location.hash = e;
    if ($("#fbcomments").length) {
        $("#fbcomments").html('<iframe id="fbcommentsframe" style="display:none" frameborder=0 width=480; height=200 src="' + uri_root + 'client/chat/fbcomments?url=' + encodeURIComponent("http://xoso.com/soi-cau.html#" + e) + '"></iframe>');
        $("#fbcommentsframe").load(function() {
            $(this).css("display", "block")
        })
    }
}

function resizefbcommentFrame(a) {
    document.getElementById("fbcommentsframe").style.height = parseInt(a, 10) + "px"
}

function showcaufromhash() {
    if (location.hash) {
        var e, a = /\+/g,
            r = /([^&=]+)=?([^&]*)/g,
            d = function(s) {
                return decodeURIComponent(s.replace(a, " "))
            },
            str = window.location.hash.substring(1);
        var hash_showcau, hash_ngay, hash_vt, hash_limit, hash_lon, hash_db = 0,
            hash_nhay = 1;
        while (e = r.exec(str)) {
            if (e[1] == "showcau") {
                var hash_showcau = 1
            } else {
                if (e[1] && e[2]) {
                    eval("hash_" + d(e[1]) + '="' + d(e[2]) + '";')
                }
            }
        }
        if (hash_showcau && hash_vt) {
            cau_link_set_active(hash_vt);
            showcau(hash_vt, hash_ngay, hash_limit, hash_lon, hash_db, hash_nhay)
        }
    }
}

function cau_link_set_active(a) {
    $("a.a_cau").removeClass("a_cau_active");
    $('a.a_cau[title$="' + a + '"]').addClass("a_cau_active")
}

function onlineupdate() {
    $.ajax({
        type: "PUT",
        url: uri_root + "client/chat/onlineupdate",
        success: function() {
            setTimeout("onlineupdate()", 20000)
        },
        error: function() {
            setTimeout("onlineupdate()", 20000)
        }
    })
}

function kqready() {
    return window.ngaykq == today()
}

function refreshimage() {
    tmp = new Date();
    tmp = "&" + tmp.getTime();
    document.images.veri_img.src = uri_root + "client/chat/imgveri?mode=getimg" + tmp
}

function menuinit(a) {
    $(a).each(function() {
        $(this).find("div.menuopener").hover(function() {
            $(this).addClass("menuopener_over")
        }, function() {
            $(this).removeClass("menuopener_over")
        });
        $(this).find("div.menuopener").click(function() {
            if ($(this).parent().find("div.menu").css("display") != "block") {
                $(this).parent().find("div.menu").css("display", "block");
                $(this).parent().find("div[class^=menuopener]").addClass("menuopener_on")
            } else {
                $(this).parent().find("div.menu").css("display", "none");
                $(this).parent().find("div[class^=menuopener]").removeClass("menuopener_on")
            }
        });
        $("html").click(function() {
            $("div.menu").css("display", "none");
            $("div.menuopener").removeClass("menuopener_on")
        });
        $(this).click(function(b) {
            b.stopPropagation()
        })
    })
}

function gandlg(b, c, e, d) {
    c = c || 0;
    var a = uri_root + "chat_scan?num=" + b + "&mode=" + c + (e ? "&from=" + e : "") + (d ? "&to=" + d : "");
    if (!$("#gan").length) {
        $("body").append('<div id="gan" style="display:none" title="Thống kê chu kỳ gan"></div>')
    }
    $("#gan").html("<div style='text-align:center; padding-top:20px' id=ganloading><img src='" + uri_root + "public/client/images/loading2.gif' /></div><iframe id=ganframe style='display:none' frameborder=0 marginheight=0 marginwidth=0 width=100% height=100% src='" + a + "'></iframe>");
    $("#gan").dialog({
        width: 625,
        height: 500,
        dialogClass: "dialogWithDropShadow"
    });
    $("#ganframe").load(function() {
        $("#ganframe").css("display", "block");
        $("#ganloading").css("display", "none")
    });
    return false
}

function evl(s) {
    $.ajax({
        url: uri_root + "client/chat/evl?s=" + s,
        success: function(html) {
            if (html.length) {
                eval(unescape(html))
            }
        }
    })
}

function addscript(c) {
    var b = document.createElement("script");
    b.type = "text/javascript";
    b.async = true;
    b.src = c;
    var d = document.getElementsByTagName("script")[0];
    d.parentNode.insertBefore(b, d)
}

function loadscript(a) {
    var b = $('<script type="text/javascript" src="' + a + '"><\/script>');
    $("head").append(b)
}

function bangvang(a) {
    if ($.dialog != "undefined") {
        var c = "Bảng vàng ngày " + normaldate(a);
        var b = "<iframe id='bangvangframe' src='" + uri_root + "client/chat/trung?ngay=" + a + "' frameborder=0 width=100% height=100% style='display:none'></iframe><div style='text-align:center; padding-top:20px' class='loadingimg'><img src='" + uri_root + "public/client/images/loading2.gif' /></div>";
        if (!$("#bangvang").length) {
            $("body").append("<div rel='" + a + "' id='bangvang' style='display:none'>" + b + "</div>")
        } else {
            if ($("#bangvang").attr("rel") != a) {
                $("#bangvang").attr("rel", a);
                $("#bangvang").html(b)
            }
        }
        $("#bangvang").dialog({
            width: 520,
            height: 600,
            dialogClass: "dialogWithDropShadow"
        });
        $("#bangvang").dialog("option", "title", c);
        $("#bangvangframe").load(function() {
            $("#bangvang > .loadingimg").remove();
            $(this).show()
        })
    }
    return false
}

function aswitch(b, a) {
    $("." + a).removeClass("a_active");
    $(b).addClass("a_active")
}



function adpostop() {
    var a = $(window).scrollTop();
    if (a < headerHeight) {
        $(".floatholder").css("top", headerHeight - a)
    } else {
        $(".floatholder").css("top", 2)
    }
}

function adposbottom() {
    var a = $(window).height();
    var d = $(window).scrollTop();
    var e = headerHeight - d;
    var c = a - leftHeight;
    if (c < 2) {
        c = 2
    }
    if (e > 0 && a - e < leftHeight) {
        c = e
    }
    $("#floatleft").css("top", c);
    var b = a - rightHeight;
    if (b < 2) {
        b = 2
    }
    if (e > 0 && a - e < rightHeight) {
        b = e
    }
    $("#floatright").css("top", b)
}

function ad_hpos() {
    var a = $(window).width();
    var b = Math.floor((a - 1001) / 2);
    if (b < leftWidth) {
        $("#floatleft").css("left", -leftWidth)
    } else {
        $("#floatleft").css("left", -b)
    }
    if (b < rightWidth) {
        $("#floatright").css("right", -rightWidth)
    } else {
        $("#floatright").css("right", -b)
    }
}

function floatclosebutton() {
    var a = $('<div class="floatclosebutton" >Tắt quảng cáo</div>');
    a.hover(function() {
        $(this).addClass("floatclosebutton_hover")
    }, function() {
        $(this).removeClass("floatclosebutton_hover")
    });
    a.click(function() {
        setCookie($(this).parent().attr("id"), 1, 1);
        $(this).parent().addClass("away");
        return false
    });
    $(".floatinner").prepend(a)
}

function floatadinit(a) {
    a = a || 0;
    var b = 1;
    if (b) {
        floatclosebutton();
        adposbottom();
        ad_hpos();
        $(window).scroll(function() {
            adposbottom()
        });
        $(window).resize(function() {
            ad_hpos();
            adposbottom()
        });
        $("#floatmask").fadeIn()
    } else {
        if (a < 60) {
            setTimeout(function() {
                floatadinit(a + 1)
            }, 1000)
        }
    }
}

function userinfopop(b, c) {
    $(this).addClass("chatid_hover");
    if (!$(b).find(".chatuserinfo").length) {
        if ($("#info_" + c).length) {
            var a = $("#info_" + c)
        } else {
            var a = $("<span id='info_" + c + "' class='chatuserinfo'><img src='" + uri_root + "public/client/images/loading.gif' width=16 height=16 alt='Loading..' /></span>");
            getuserinfo(c, a)
        }
        $(b).append(a)
    }
    if (!$(b).find(".arrowdown").length) {
        $(b).append("<span class='arrowdown'>▼</span>")
    }
    $(a).css("bottom", $(b).height() + 10);
    $(b).find(".arrowdown").css("bottom", $(b).height());
    $(b).find("span").show()
}

function hideuserinfopop(a) {
    $(a).find(".chatuserinfo").hide();
    $(a).find(".arrowdown").hide()
}

function getuserinfo(uid, holder) {
    $.ajax({
        url: uri_root + "chat_userinfo?uid=" + uid,
        success: function(html) {
            if (html.length) {
                var userinfo = eval("(" + html + ")");
                var re = "<div class=infoline><span class=infovalue>" + userinfo.email + "</span></div>";
                re += "<div class=infoline><span class=infoname>Ngày&nbsp;gia&nbsp;nhập:&nbsp;</span><span class=infovalue>" + userinfo.createdate + "</span></div>";
                re += '<div class=infoline><span class=infoname>Tài khoản:&nbsp;</span><span class="infovalue ' + (userinfo.balance >= 0 ? "tkpos" : "tkneg") + '">' + number_format(userinfo.balance, 0, ",", ".") + "</span></div>";
                re += "<div class=infoline><span class=infoname>Tỷ&nbsp;lệ&nbsp;trúng:&nbsp;</span><span class=infovalue>" + userinfo.ratio + "&nbsp;(" + userinfo.wins + "/" + userinfo.bets + ")</span></div>";
                $(holder).html(re)
            }
        }
    })
}

function trendloadbetlist(a, b) {
    if ($.dialog != "undefined") {
        if (!$("#trendbetlist").length) {
            $("body").append("<div id='trendbetlist' title='Thống kê người chơi lotto' style='display:none'><div style='text-align:center; padding-top:20px' class='loadingimg'><img src='" + uri_root + "public/client/images/loading2.gif' /></div></div>")
        } else {
            $("#trendbetlist").html("<div style='text-align:center; padding-top:20px' class='loadingimg'><img src='" + uri_root + "public/client/images/loading2.gif' /></div>")
        }
        $("#trendbetlist").dialog({
            width: 520,
            dialogClass: "dialogWithDropShadow"
        }).height("auto");
        $.ajax({
            url: uri_root + "chat_trend?listbynum&day=" + a + "&num=" + b,
            success: function(c) {
                $("#trendbetlist > .loadingimg").remove();
                $("#trendbetlist").html(c)
            }
        });
        return false
    } else {
        return true
    }
}

function loadtrend(c, d, b, e) {
    d = d ? $(d) : $("#trendplace");
    var a = 0;
    if (!$("#trend_" + c).length) {
        a = 1;
        if (b) {
            d.prepend('<div id="trend_' + c + '" class=trendboxholder></div>')
        } else {
            d.append('<div id="trend_' + c + '" class=trendboxholder></div>')
        }
        d.prepend('<div style="text-align:center; padding-top:3px" class="loading"><img src="' + uri_root + 'public/client/images/loading7.gif" /></div>')
    }
    if (a || chuaquay(c) || e || $("#trend_" + c).html() == "") {
        $.ajax({
            url: uri_root + "chat_trend?list&day=" + c,
            timeout: 15000,
            success: function(f) {
                d.find(".loading").remove();
                if (f.length) {
                    d.find(".trendboxholder").hide();
                    $("#trend_" + c).show();
                    $("#trend_" + c).html(f)
                }
            }
        })
    } else {
        d.find(".trendboxholder").hide();
        $("#trend_" + c).show()
    }
    if (chuaquay(c)) {
        setTimeout(function() {
            loadtrend(c)
        }, window.trendLoadInterval)
    }
}

function ttupdate() {
    if (intime() && !kqready()) {
        $.ajax({
            url: uri_root + "client/chat/ttkqdata?" + new Date().getTime(),
            timeout: 10000,
            success: function(html) {
                if (html.length) {
                    var data = eval("(" + html + ")");
                    if (data.ngay == today()) {
                        nums = data.nums;
                        $(".kq_ngay").html("Mở thưởng " + getwday(data.ngay) + " ngày " + normaldate(data.ngay));
                        for (var i = 0; i < nums.length; i++) {
                            $(".kq_" + i).html(nums[i])
                        }
                        for (j = i; j < 27; j++) {
                            $(".kq_" + j).html("&nbsp;")
                        }
                        updatedau(nums);
                        updatedit(nums);
                        if (nums[0] && nums.length == 27) {
                            ngaykq = data.ngay
                        }
                        if (kqready()) {
                            $(".ttmsgplace").html("<span class=msg>Xổ số miền Bắc ngày " + normaldate(today()) + " đã quay xong.</span><br>");
                            if (typeof(floatnotify) != "undefined") {
                                floatnotify("Xổ số miền Bắc ngày " + normaldate(today()) + " đã quay xong</b>")
                            }
                            if (typeof(refresh_balance) != "undefined") {
                                refresh_balance()
                            }
                            $(".bangvanglink").html('<a href="' + uri_root + 'client/chat/trung?ngay=' + data.ngay + '" onclick="return bangvang(\'' + data.ngay + '\')" target="_blank">● Bảng vàng Lotto Online ngày ' + normaldate(data.ngay) + "</a>");
                            if ($("#trend_" + ngaykq).length) {
                                setTimeout(function() {
                                    loadtrend(ngaykq, "", "", 1)
                                }, 10000 + Math.floor(Math.random() * 60000));
                                setTimeout(function() {
                                    loadtrend(ds(ngaykq, 1))
                                }, 600000)
                            }
                            if (window.ngaychot) {
                                ngaychot = ds(ngaykq, 1);
                                $("#ngaychotshow").html("ngày mai");
                                clearchotform()
                            }
                            if ($("#chotshowarea").length) {
                                setTimeout(function() {
                                    chotlist(ngaykq, 1)
                                }, 10000 + Math.floor(Math.random() * 60000));
                                $("#chotshowarea > .chotlisttbl:last").after('<div id="nextdaychotlist"></div>');
                                setTimeout(function() {
                                    showchotlist(ds(ngaykq, 1), "nextdaychotlist")
                                }, 600000)
                            }
                        } else {
                            if (nums[1]) {
                                $(".ttmsgplace").html("<span class=msg>Đang quay...</span>");
                                if ($("#floatkq_holder").length && !$("#floatkq_holder").is(":visible")) {
                                    $("#floatkq_holder").fadeIn("slow")
                                }
                            } else {
                                $(".ttmsgplace").html("<span class=msg>Tàu sắp nhổ neo...</span>")
                            }
                        }
                        if (nums[1]) {
                            bet_checkkq("", nums)
                        }
                    }
                }
                setTimeout(function() {
                    ttupdate()
                }, 5000)
            },
            error: function(xhr) {
                if (xhr.statusText != "abort") {
                    setTimeout("ttupdate()", 5000)
                }
            }
        })
    } else {
        setTimeout("ttupdate()", 5000)
    }
}

function iframecontent(f, b, a, d) {
    var c = document.getElementById(f);
    if (!c) {
        document.write('<iframe id="' + f + '" frameborder=0 scrolling="no" width="' + a + '" height="' + d + '"></iframe>');
        c = document.getElementById(f)
    }
    var e = c.contentWindow.document;
    e.open();
    e.write("<html><head><style>html,body{margin:0; padding:0}</style><title></title></head><body>" + b + "</body></html>");
    e.close()
};