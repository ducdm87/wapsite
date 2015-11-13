<h1>Đặt số</h1>

<link href="<?php echo css_link('jquery-ui-1.8.23.custom.css') ?>" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo js_link('jquery-ui-1.8.23.custom.min.js') ?>'></script>
<script type='text/javascript' src='<?php echo js_link('clock.js') ?>'></script>
<script type='text/javascript'>
    var year = '<?php echo date('Y') ?>';
    var month = '<?php echo date('m') ?>';
    var day = '<?php echo date('d') ?>';
    var hours = '<?php echo date('H') ?>';
    var minutes = '<?php echo date('i') ?>';
    var seconds = '<?php echo date('s') ?>';
    var ngay = '';
    var date = new Date(year, month - 1, day, hours, minutes, seconds);
    var weekday = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
    clock();
    setTimeout('timesync(1800000)', 1800000);
</script>
<script type='text/javascript' src='<?php echo js_link('xoso.js') ?>'></script>
<script type='text/javascript'>
    var uid = '';
    var year = '<?php echo date('Y') ?>';
    var staticdir = '<?php echo html_url(); ?>';
    var uri_root = '<?php echo html_url(); ?>';
</script>
<div class="contentcontainer">    
    <style type="text/css">
        .contentcontainer{font-family:arial,sans-serif}
        #ngay{padding:2px}
        input[type="text"]{padding:2px;height:15px;line-height:15px;font-family:arial,sans-serif}
        input[type="submit"]{cursor:pointer;font-family:arial,sans-serif}
        .contentcontainer a:link,.contentcontainer a:visited{color: #0051ca}
        .contentcontainer a:hover,.contentcontainer a:active{color: #ff8022}
        .msg {
            background: none repeat scroll 0 0 #f8ffea;
            border: 1px solid #b4eb41;
            color: #434600;
            display: inline-block;
            margin: 5px 0;
            padding: 5px;
        }
        .deletebutton:link, .deletebutton:visited, .deletebutton:hover, .deletebutton:active {
            background: url("<?php echo $uri_root ?>public/client/images/delete.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
            display: inline-block;
            height: 20px;
            overflow: hidden;
            position: absolute;
            right: -5px;
            top: -5px;
            width: 20px;
            z-index: 3;
        }

        .bet{float:left; border:#cdcdcd 1px solid; background:#f2f2f2; margin:5px; padding:2px 4px; font-size:12px; font-weight:bold; color:#333; position:relative; z-index:0; cursor:default}
        .bet_hover{border-color:#FF9E46}
        .betnum{font-size:18px; font-weight:bold; color:#bc1c18;line-height:22px}
        .bet_value{font-size:12px; font-weight:bold; color:#7101AD}
        .hilight{background:#FFE3AA}
        .selected{background:#d5d5d5; border-color:#cdcdcd}
        .trung{background:#fded93}
        .trung .nhay{position:absolute; top:-5px; right:-3px; z-index:2; background:red; color:white; padding:0 3px 0 3px; font-size:12px}
        .tool{position:absolute; top:-5px; right:-3px; z-index:3}
        #lichsu{width:700px;height:560px;overflow:auto}
        .lichsu{margin:5px 25px 5px 5px; border-collapse:collapse;width:670px}
        .lichsu th,.lichsu td{border:#cdcdcd 1px solid; text-align:center; font-size:13px;padding:5px}
        .lichsu th{background:#d5d5d5; color:#333; font-size:12px}
        .lichsu_lastrow td{background:#E6E6E6; font-weight:bold}

        .tbl_dangtheo{ margin:5px 30px 5px 5px; border-collapse:collapse}
        .tbl_dangtheo th,.tbl_dangtheo td{text-align:center; font-size:13px; font-weight:bold; border:#A8BEDF 1px solid}
        .tbl_dangtheo th{background:#CADDF9; color:#12499C; font-size:12px}
        .tbl_dangtheo .num{font-size:16px; color:#AA0088}
        .tbl_dangtheo .diemhoa{color:#008000}

        .pos{color:#00A000}
        .neg{color:#EE0000}

        .betnum_ls:link{text-decoration:none; color:#710196 !important; font-size:13px; font-weight:bold}
        .betnum_ls:visited{text-decoration:none; color:#710196 !important; font-size:13px; font-weight:bold}
        .betnum_ls:active{text-decoration:none; color:#FFA722 !important; font-size:13px; font-weight:bold}
        .betnum_ls:hover{text-decoration:none; color:#E67800 !important; font-size:13px; font-weight:bold}
        .bottom1 select, input{float:none}
    </style>    
    <script type='text/javascript'>
    var betlsloading=0;    
    function loadbetls(a) {
        if (!betlsloading) {
            betlsloading = 1;
            $("#lichsu").append("<div id='betlsloadingimg' style='margin:10'><img src='" + uri_root + "public/client/images/loading5.gif'></div>");
            $.ajax({url: uri_root + "acp_admin/datso/betlist?ngay=" + a, cache: false, success: function (c) {
                    if (c) {
                        var d = c.split("|");
                        for (i in d) {
                            var k = 0, h = 0, e = 0;
                            var f = d[i];
                            f = f.split("~");
                            ngayls = f[0];
                            var g = f[1].split(",");
                            var l = "<table class=lichsu cellspacing=1 cellpadding=5><tr><th width=\"175\">Ngày ghi</th><th width=\"45\">Lô</th><th width=\"80\">Điểm</th><th width=\"150\">Fullname</th><th width=\"200\">Kích hoạt</th><th width=\"50\">#</th></tr>";
                            for (j in g) {
                                num = g[j].split(":");
                                k += num[1] * 1;
                                h += num[1] * num[2];
                                l += "<tr>";
                                if (j == 0) {
                                    l += "<td valign=top rowspan='" + g.length + "'><a href='#betplace'>" + f[0] + "</a></td>"
                                }
                                l += "<td><a href='#' class='betnum_ls'>" + num[0] + "</a></td><td>" + num[1] + "</td><td class='pos'>" + f[2] + "</td>"
                                if (j == 0) {
                                    l += "<td valign=top rowspan='" + g.length + "'>" + f[3] + "</td>"
                                    l += "<td valign=top rowspan='" + g.length + "'><a onclick=\"return confirm('Bạn chắc chắn muốn xóa?');\" href='<?php echo admin_url($module . '/delete') ?>/" + num[2] + "'> Xoá </a></td>"
                                }
                                l += "</tr>";
                            }
                            l += "</table>";
                            $("#lichsu").append(l)
                        }
                    }
                    betlsloading = 0;
                    $("#betlsloadingimg").remove()
                }})
        }
    }

    var betlimit = 2000;
    var curruser = '';
    var editrestrict = true;
    var ngaybet = '<?php echo $date ?>';
    var balance = 0;
    var balancedate = '';
    var diem = 0;
    var diemthang = 0;
    var tt = 0;
    var nextday = '<?php echo $nextday ?>';
    loadImg("<?php echo img_link('delete.png') ?>");
    loadImg("<?php echo img_link('loading5.gif') ?>");
    loadImg("<?php echo img_link('loading6.gif') ?>");
    </script>
    <div class="toppage">
        <form method="post" id=betform name=betform action='' style='font-size:13px; font-weight:bold; color:#353535; padding:3px; margin-bottom:5px'>
            User: 
            <select name="userid" style="float:none">
                <?php 
                foreach ($user_list as $value) {
                    echo '<option value="'.$value->id.'">'.$value->username.' ('.$value->fullname.')</option>';
                }
                ?>
            </select>
            <span style='font-size:12px'>Ngày ghi: <input type=text size=8 id="ngay" name=ngay style='font-size:12px; color:#8B2001' value='<?php echo date('d/m/Y', strtotime($date.' -1 day')) ?>' onchange='ngaychange(this.value)' /></span>
            <span style='font-size:12px'>Thời gian kích hoạt: <input type=text size=20 name=created style='font-size:12px; color:#8B2001' value='<?php echo date('d/m/Y H:i:s') ?>' /></span>
            Cặp số: <input type=text size=10 name=range style='font-size:15px; font-weight:bold; color:#bc1c18' title='Có thể nhập nhiều cặp số, cách nhau bằng dấu phẩy' />
            Số điểm: <input type=text size=2 name=bet style='font-size:15px; font-weight:bold; color:#62018B' />
            <input type=submit name='betsubmit' value='   Ghi   ' style='font-size:15px; font-weight:bold; color:#01468B;background-color: #b8100d;background-image: linear-gradient(to bottom, #b8100d, #960501);border: #980804 1px solid;color: #f1f4f8;font-weight:bold; font-size:12px;font-family:arial,sans-serif;height:23px;padding:0 10px;border-radius: 3px;-moz-border-radius: 3px;-webkit-border-radius: 3px' />
        </form>
    </div>
    <script type='text/javascript'>picker('ngay');</script>
    <div style='margin-top:10px; border:#cdcdcd 1px solid; float:left'>
        <div style='background:#f2f2f2; padding:5px; font-weight:bold'>Thống kê</div>
        <div id='lichsu'></div>
        <a href="javascript:;" id="more_lichsu" style="text-align:right;padding:5px;display:block">Xem thêm</a>
    </div>
    <script type='text/javascript'>
        $('#more_lichsu').click(function () {
            loadbetls(ngayls);
        });
    </script>
    <script type='text/javascript'>var ngayls = ngaybet;loadbetls(ngayls);</script>
    <div style='clear:both'></div>
</div>