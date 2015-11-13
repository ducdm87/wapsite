<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php echo $_meta['description'] ?>" />
        <meta name="keywords" content="<?php echo $_meta['keywords'] ?>" />
        <title><?php echo $_meta['title'] ?></title>
        <meta property="og:image" content="<?php echo img_link('logo.png') ?>" />
        <?php if ($meta_refresh_mb == true && $meta_refresh_mt == true && $meta_refresh_mn == true) { ?>
            <meta http-equiv="refresh" content="900" />
        <?php } ?>
        <link type="image/x-icon" href="<?php echo img_link('favicon.ico') ?>" rel="shortcut icon" />
        <link type="text/css" rel="stylesheet" href="<?php echo $uri_root ?>min/g=css1411" />
        <script type="text/javascript" src="<?php echo $uri_root ?>min/g=js1411"></script>
        <meta name="google-site-verification" content="_MdXAARqGNM7C1GRrfqgrQg59dJuCGxL_3E4tJf_se0" />
        <script type="text/javascript">/*<![CDATA[*/var uri_root = "<?php echo $uri_root ?>";
    function loadtinhright() {
        var a = $("#f_rangeStart_right").val();
        if (a == "") {
            alert("Vui lòng nhập ngày mở thưởng trên tờ vé !");
            document.form_doveso_right.ngay.focus();
            return false
        }
        $.ajax({type: "GET", url: "<?php echo $uri_root ?>loadtinhs/<?php echo $lid_right ?>/" + a, success: function(b) {
                $("#boxCity_right").html(b);
                $("#select_provide").selectbox()
            }})
    }
    $(document).ready(function(a) {
        loadtinhright()
    });
    function dovesoright() {
        if ($("#so_right").val() == "") {
            alert("Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)");
            document.form_doveso_right.so.focus();
            return false
        } else {
            if ($("#so_right").val().length < 5) {
                alert("Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)");
                document.form_doveso_right.so.focus();
                return false
            } else {
                if ($("#f_rangeStart_right").val() == "") {
                    alert("Vui lòng nhập ngày mở thưởng trên tờ vé !");
                    document.form_doveso_right.ngay.focus();
                    return false
                } else {
                    document.form_doveso_right.submit()
                }
            }
        }
    }
    /*]]>*/</script>
        <?php if ($c_module == 'xoso' && $c_func == 'filter_date' && isset($items[0])) {
            $shared_content = 'Xổ Số ' . $items[0]->name . ' ngày ' . $date . ',';
            $shared_content.=' giải DB: ' . $items[0]->a0 . ',';
            $shared_content.=' giải nhất: ' . $items[0]->a1 . ',';
            $shared_content.=' giải nhì: ' . $items[0]->a2 . ',';
            $shared_content.=' giải ba: ' . $items[0]->a3 . ',';
            $shared_content.=' giải tư: ' . $items[0]->a4 . ',';
            $shared_content.=' giải năm: ' . $items[0]->a5 . ',';
            $shared_content.=' giải sáu: ' . $items[0]->a6 . ',';
            $shared_content.=' giải bảy: ' . $items[0]->a7;
            if ($items[0]->area != 'MB') $shared_content.=', giải tám: ' . $items[0]->a8;echo '<meta property="og:description" content="' . $shared_content . '" />';
        } ?>
    </head>
    <body>
        <div id="wrapper">
            <?php $this->load->view($layout_header) ?>
            <div class="content-wrap">
                <div class="content">
                    <div class="main clearfix">
                                <?php $this->load->view($layout_col_left) ?>
                        <div class="col-main">
                            <div class="col-content">
                                <?php
                                if ($tttt_mb || $tttt_mt || $tttt_mn) {
                                    echo '<script type="text/javascript" src="' . js_link('jquery-blink.js') . '"></script>';
                                    if ($tttt_mb) {
                                        echo '<div class="tttt_link"><a class="tttt_blink" href="' . $uri_root . 'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-bac.html">Tường thuật trực tiếp Xổ Số Miền Bắc</a></div>';
                                    } elseif ($tttt_mt) {
                                        echo '<div class="tttt_link"><a class="tttt_blink" href="' . $uri_root . 'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-trung.html">Tường thuật trực tiếp Xổ Số Miền Trung</a></div>';
                                    } else {
                                        echo '<div class="tttt_link"><a class="tttt_blink" href="' . $uri_root . 'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-nam.html">Tường thuật trực tiếp Xổ Số Miền Nam</a></div>';
                                    }
                                    echo "<script type=\"text/javascript\">$(document).ready(function() { $('.tttt_blink').blink({delay:100});});</script>";
                                }
                                $this->load->view($tmpl);
                                ?>
                                <br/>
                            </div>
                            <div class="col-right">
                                <div class="mod-module">
                                    <div id='div-gpt-ad-1378288615889-2' style='width:200px;'>
                                        <script type='text/javascript'>
                                            googletag.cmd.push(function() {
                                                googletag.display('div-gpt-ad-1378288615889-2');
                                            });
                                        </script>
                                    </div>
                                </div>

                                <div class="mod-module">
                                    <div class="topbox" style="margin-top:0;font-size:11px">
                                        <div class="contentbox_header" style='background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);height:38px;line-height:38px;margin:0 1px;position:relative'>
                                            <span class=coins>&nbsp;</span> <span style='text-shadow:1px 1px #bfbfbf; color:#ab1714;position:absolute; bottom:0; left:30px; display:inline-block; font-weight:bold'>Bảng xếp hạng theo tuần</span>
                                        </div>
                                        <div id="lototop_result" style='border-top:1px solid #ddd;height:240px; overflow:auto; *position:relative'>
                                            <table class=toptbl cellspacing=1 cellpadding=3>
                                                <?php
                                                if ($loto_top_tuan) {
                                                    foreach ($loto_top_tuan as $i => $item) {
                                                        ?>
                                                        <tr rel='<?php echo $item['userid'] ?>'>
                                                            <td class=ord><?php echo $i + 1 ?></td>
                                                            <td class=name rel='<?php echo $item['fullname'] ?>'>
                                                                <div style="width:80px;font-weight:400"><?php echo $item['fullname'] ?></div>
                                                            </td>
                                                            <td class=balance><?php echo number_format($item['taikhoan'], 0, '.', '.') ?></td>
                                                        </tr>
        <?php
    }
}
?>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="topbox" style="font-size:11px">
                                        <div class="contentbox_header lototop_thang_header" style='background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);height:38px;line-height:38px;margin:0 1px;position:relative'>
                                            <span class=coins>&nbsp;</span> <a href="javascript:;" id="lototop_thang_title" style='text-shadow:1px 1px #bfbfbf; color:#ab1714;position:absolute; bottom:0; left:30px; display:inline-block; font-weight:bold'>Bảng xếp hạng theo tháng</a>
                                        </div>
                                        <div id="lototop_thang_result" style='border-top:1px solid #ddd;height:0; overflow:auto; *position:relative'>
                                            <table class=toptbl cellspacing=1 cellpadding=3>
                                                <?php
                                                if ($loto_top_thang) {
                                                    foreach ($loto_top_thang as $i => $item) {
                                                        ?>
                                                        <tr rel='<?php echo $item['userid'] ?>'>
                                                            <td class=ord><?php echo $i + 1 ?></td>
                                                            <td class=name rel='<?php echo $item['fullname'] ?>'>
                                                                <div style="width:80px;font-weight:400"><?php echo $item['fullname'] ?></div>
                                                            </td>
                                                            <td class=balance><?php echo number_format($item['taikhoan'], 0, '.', '.') ?></td>
                                                        </tr>
        <?php
    }
}
?>
                                            </table>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        function lototop_thangpopup() {
                                            $('#lototop_thang_result').animate({'height': 240});
                                            clearTimeout(window.notiPopdownTimeout);
                                        }
                                        function lototop_thangdown() {
                                            $('#lototop_thang_result').animate({'height': 0});
                                        }
                                        $('#lototop_thang_title').click(function() {
                                            if ($(this).hasClass('lototop_thang_active')) {
                                                $(this).removeClass('lototop_thang_active');
                                                lototop_thangdown();
                                            } else {
                                                $('.lototop_thang_active').removeClass('lototop_thang_active');
                                                $(this).addClass('lototop_thang_active');
                                                lototop_thangpopup();
                                            }
                                        });
                                    </script>

                                    <div class="topbox" style="font-size:11px">
                                        <div class="topdaigia_header" style='background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);height:38px;line-height:38px;margin:0 1px;position:relative'>
                                            <span class=coins>&nbsp;</span> <a href="javascript:;" id="topdaigia" style='cursor:pointer;text-shadow:1px 1px #bfbfbf; color:#ab1714;position:absolute; bottom:0; left:30px; display:inline-block; font-weight:bold'>Top Đại gia Lotto online</a><span id='toplisthelp' class='tip' style='position:absolute; right:8px; top:8px' rel='Top đại gia Lotto online là danh sách 50 người có tài khoản lotto cao nhất'><span class='questiontip'>&nbsp;</span></span>
                                        </div>
                                        <div id="topdaigia_result" style='border-top:1px solid #ddd;height:0; overflow:auto; *position:relative'>
                                            <table class=toptbl cellspacing=1 cellpadding=3>
                                                <?php
                                                if ($topdaigia) {
                                                    foreach ($topdaigia as $i => $item) {
                                                        ?>
                                                        <tr rel='<?php echo $item['id'] ?>'>
                                                            <td class=ord><?php echo $i + 1 ?></td>
                                                            <td class=name rel='<?php echo $item['fullname'] ?>'>
                                                                <div style="width:80px;font-weight:400"><?php echo $item['fullname'] ?></div>
                                                            </td>
                                                            <td class=balance><?php echo number_format($item['taikhoan'], 0, '.', '.') ?></td>
                                                        </tr>
        <?php
    }
}
?>
                                            </table>
                                        </div>
                                        <script type="text/javascript">
                                            function topdaigiapopup() {
                                                $('#topdaigia_result').animate({'height': 240});
                                                clearTimeout(window.notiPopdownTimeout);
                                            }
                                            function topdaigiadown() {
                                                $('#topdaigia_result').animate({'height': 0});
                                            }
                                            $('#topdaigia').click(function() {
                                                if ($(this).hasClass('topdaigia_active')) {
                                                    $(this).removeClass('topdaigia_active');
                                                    topdaigiadown();
                                                } else {
                                                    $('.topdaigia_active').removeClass('topdaigia_active');
                                                    $(this).addClass('topdaigia_active');
                                                    topdaigiapopup();
                                                }
                                            });
                                        </script>
                                    </div>
                                    <script type='text/javascript'>hovertip('#toplisthelp', 1)</script>
                                    <style type="text/css">
                                        .coins{position:absolute; bottom:0; left:4px; width:23px; height:30px; background:url(<?php echo $uri_root ?>public/client/images/coins.png) no-repeat; overflow:hidden; display:inline-block; *background-image:none; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo $uri_root ?>public/client/images/coins.png, sizingMethod=scale)}
                                        .topbox{margin:5px 0; text-align:left; border:#ddd 1px solid}
                                        .toptbl{background:white; border-spacing:1px}
                                        .toptbl .ord{width:20px; background:#EAEAEA}
                                        .toptbl .name{background:#f0f0c3}
                                        .toptbl .name div{color:#069; font-weight:bold; width:215px; overflow:hidden}
                                        .toptbl .name_hover{background:#DEDFA7; cursor:pointer;border-radius:0;-moz-border-radius:0px;-webkit-border-radius:0px}
                                        .toptbl .balance{background:#ffef93; color:#008000; font-weight:bold}
                                        .toptbl .balance_hover{background:#EFDC77}
                                        .toptbl td{padding:4px}
                                        .lototop_thang_header a:hover,.topdaigia_header a:hover{left:32px !important}
                                    </style>
                                    <script type="text/javascript">
                                        $('.toptbl tr').hover(function() {
                                            $(this).find('.name').addClass('name_hover');
                                            $(this).find('.balance').addClass('balance_hover');
                                        },
                                                function() {
                                                    $(this).find('.name').removeClass('name_hover');
                                                    $(this).find('.balance').removeClass('balance_hover');
                                                });

                                        $('.toptbl td.name').click(function() {
                                            var receiver = $(this).parent().attr('rel');
                                            receiverName = $(this).find('div').html();
                                            ppchatInit(receiver, receiverName, 0, 1);
                                        });
                                        hovertip('.toptbl td.name');
                                    </script>

                                </div>

                                <div class="mod-module">
                                    <div id='trendplace'>
                                        <div id='trend_<?php echo $date_chot ?>'>
                                            <div class=contentbox>
                                                <div class=contentbox_header>
                                                    <div style='color:#b43939;font-size:14px'>Lotto chơi nhiều hôm nay</div>
                                                </div>
                                                <div class=contentbox_body>
                                                    <div>
                                                        <div class='trendholder'>
                                                            <?php
                                                            if ($trendday) {
                                                                $dem = 0;
                                                                $fontsize = 27;
                                                                $tmp = 0;
                                                                foreach ($trendday as $so => $nguoichoi) {
                                                                    $dem++;
                                                                    if ($dem > 20)
                                                                        break;

                                                                    if ($dem == 1) {
                                                                        $tmp = $nguoichoi;
                                                                    } else {
                                                                        if ($nguoichoi < $tmp && $fontsize > 12) {
                                                                            $fontsize = $fontsize - 3;
                                                                        }
                                                                        $tmp = $nguoichoi;
                                                                    }
                                                                    echo "<a class='trend_number' href='javascript:;' style='font-family:arial; font-size:" . $fontsize . "px' title='" . $nguoichoi . " người chơi'>" . $so . "</a>";
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div style='clear:both'></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $('.trenddaysw').click(function() {
                                            $('.trenddaysw').removeClass('a_active');
                                            $(this).addClass('a_active');
                                            $('#trenddayselect').val('');
                                            $('#trendayselect_guide').show();
                                            loadtrend($(this).attr('rel'), "#oldtrendplace", 1);
                                            return false;
                                        });
                                        $('#trendayselect_guide').click(function() {
                                            $(this).hide();
                                            $('#trenddayselect').focus();
                                            return false
                                        });
                                        $('#trenddayselect').change(function() {
                                            if ($(this).val() == '')
                                            {
                                                $('#trendayselect_guide').show();
                                            }
                                            else
                                            {
                                                $('.trenddaysw').removeClass('a_active');
                                                loadtrend(sqldate($(this).val()), "#oldtrendplace", 1);
                                            }
                                        });
                                        if ($.datepicker) {
                                            $('#trenddayselect').datepicker({
                                                monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                                                changeMonth: true,
                                                changeYear: true,
                                                dateFormat: 'dd/mm/yy',
                                                showAnim: '',
                                                minDate: new Date(<?php echo $minDate ?>),
                                                maxDate: new Date(<?php echo $maxDate ?>),
                                                onClose: function(text) {
                                                    if (text == '')
                                                        $('#trendayselect_guide').show()
                                                }
                                            });
                                        }
                                        else {
                                            $('#trenddayselect').blur(function() {
                                                if ($(this).val() == '')
                                                {
                                                    $('#trendayselect_guide').show();
                                                }
                                            });
                                        }
                                        trendLoadInterval = 60000;
                                        //setTimeout(function(){loadtrend('<?php echo $date_chot ?>')},60000);
                                    </script>
                                    <style type="text/css">
                                        .contentbox{margin:7px 0;border:#ddd 1px solid;text-align:left}
                                        .contentbox_header {
                                            background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
                                            height: 38px;
                                            line-height:38px;
                                            margin:0 1px;            
                                        }
                                        .contentbox_header div{font-weight:bold;color:#606060;font-size:12px;text-shadow:1px 1px #fff;position:relative;padding-left:5px}
                                        .contentbox_body{border-top:#ddd 1px solid;padding:5px}

                                        .trendholder{text-align:left}
                                        .trend_number:link, .trend_number:visited,.trend_number:hover,.trend_number:active{line-height:normal;display:inline-block; position:relative; color:#b43939; text-decoration:none; margin:0 8px 0 0}
                                        .trend_number:hover,.trend_number:active{color:#DF5900}
                                        .trend_old:link,.trend_old:visited,.trend_old:hover,.trend_old:active{color:#6C6C6C}
                                        .trend_old:hover,.trend_old:active{color:#DF5900}
                                        .trend_number:link span,.trend_number:visited span,.trend_number:hover span,.trend_number:active span{display:inline-block; width:12px; height:12px; overflow:hidden; position:absolute; right:-5px; top:-2px; text-align:center; font-size:11px; font-family:tahoma,arial; color:white; background:url('<?php echo $uri_root ?>public/client/images/rounddotbg.png'); background-repeat:no-repeat}
                                    </style>
                                </div>

                                <div class="mod-module">
                                    <div class="mod-banner-right">
                                        <?php foreach ($banner as $v) {
                                            if ($v->position == 'right' && ($v->page == 'all' || $v->page == $c_module)) { ?>
                                                <div><a target="_blank" href="<?php echo $v->url; ?>" title="<?php echo view_title($v->name); ?>"><img src="<?php echo site_url($v->image); ?>" width="200" alt="<?php echo view_title($v->name); ?>" /></a></div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                                <div class="mod-module">
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">DỰ ĐOÁN KẾT QUẢ XỔ SỐ</span></div></div>
                                    <ul class="category-provide">
                                        <li><a href="<?php echo $uri_root ?>du-doan-xo-so-mien-bac.html" title="Dự đoán xổ số Miền Bắc"><span>Dự đoán xổ số Miền Bắc</span></a></li>
                                        <?php
                                        $idmt = array();
                                        foreach ($location_today['MT'] as $value) {
                                            $idmt[] = $value->id;
                                            echo '<li><a href="' . $uri_root . 'du-doan-' . $value->alias . '.html" title="Dự đoán xổ số ' . $value->name . ' - Xổ số Miền Trung"><span>Dự đoán xổ số ' . $value->name . '</span></a></li>';
                                        }
                                        foreach ($location_menu['MT'] as $value) {
                                            if (!in_array($value->id, $idmt)) {
                                                echo '<li class="dudoan_mt" style="display:none"><a href="' . $uri_root . 'du-doan-' . $value->alias . '.html" title="Dự đoán xổ số ' . $value->name . ' - Xổ số Miền Trung"><span>Dự đoán xổ số ' . $value->name . '</span></a></li>';
                                            }
                                        }
                                        echo '<li><a href="javascript:;" onclick="showPopup(\'.dudoan_mt\')" title="" rel="nofollow">Dự đoán các tỉnh <strong class="cl-green">Miền Trung</strong></a></li>';
                                        $idmn = array();
                                        foreach ($location_today['MN'] as $value) {
                                            $idmn[] = $value->id;
                                            echo '<li><a href="' . $uri_root . 'du-doan-' . $value->alias . '.html" title="Dự đoán xổ số ' . $value->name . ' - Xổ số Miền Nam"><span>Dự đoán xổ số ' . $value->name . '</span></a></li>';
                                        }
                                        foreach ($location_menu['MN'] as $value) {
                                            if (!in_array($value->id, $idmn)) {
                                                echo '<li class="dudoan_mn" style="display:none"><a href="' . $uri_root . 'du-doan-' . $value->alias . '.html" title="Dự đoán xổ số ' . $value->name . ' - Xổ số Miền Trung"><span>Dự đoán xổ số ' . $value->name . '</span></a></li>';
                                            }
                                        }
                                        echo '<li><a href="javascript:;" onclick="showPopup(\'.dudoan_mn\')" title="" rel="nofollow">Dự đoán các tỉnh <strong class="cl-green">Miền Nam</strong></a></li>';
                                        ?>
                                    </ul>
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">THỐNG KÊ XỔ SỐ</span></div></div>
                                    <ul class="category-provide">
                                        <li><a href="<?php echo $uri_root ?>thongke-dau-duoi-0-9.html"><span>Thống kê đầu, đuôi</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-tong-chan.html"><span>Thống kê theo tổng chẵn</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-tong-le.html"><span>Thống kê theo tổng lẻ</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-theo-tong-0-9.html"><span>Thống kê tổng 2 số cuối</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-cap-so-tu-00-99.html"><span>Thống kê 00 - 99</span></a></li>
                                    </ul>
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">THỐNG KÊ VIP</span></div></div>
                                    <ul class="category-provide">
                                        <li><a href="<?php echo $uri_root ?>thong-ke-xo-so-hom-nay.html"><span>Thống kê xổ số hôm nay</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-vip-xo-so-3-mien.html"><span>Thống kê VIP xổ số 3 miền</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-so-dep-tu-cac-dien-dan-xo-so.html"><span>Số đẹp từ các diễn đàn xổ số</span></a></li>
                                        <li><a target="_blank" href="<?php echo $uri_root ?>thong-ke-tan-suat-loto.html"><span>Thông kê tần suất Loto</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-quan-trong.html"><span>Thống kê quan trọng</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-theo-bo-so.html"><span>Thống kê theo bộ số</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-lo-to-tinh.html"><span>Thống kê Loto nhanh</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-lo-gan.html"><span>Thống kê Loto gan</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-lo-to-theo-dau-duoi.html"><span>Thống kê Loto theo đầu/đuôi</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-lo-to-theo-tong.html"><span>Thống kê theo tổng</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-theo-chu-ky.html"><span>Thống kê theo chu kỳ</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-giai-dac-biet-theo-tuan.html"><span>Thống kê giải ĐB theo tuần</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thong-ke-giai-dac-biet-theo-thang.html"><span>Thống kê giải ĐB theo tháng</span></a></li>
                                    </ul>
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">THỐNG KÊ CẦU</span></div></div>
                                    <ul class="category-provide">
                                        <li><a href="<?php echo $uri_root ?>thongke-cau-xo-so.html"><span>Thống kê Cầu Loto</span></a></li>
                                        <li><a href="<?php echo $uri_root ?>thongke-cau-bach-thu-mien-bac.html"><span>Thống kê Cầu bạch thủ</span></a></li>
                                    </ul>
                                </div>
                                <div class="mod-module">
                                    <form id="form_doveso_right" name="form_doveso_right" method="get" action="<?php echo $uri_root ?>do-ve-so.html">
                                        <div class="title title-yelow"><div class="title-right"><span class="icon">DÒ VÉ SỐ ONLINE</span></div></div>
                                        <div class="box-online">
                                            <div class="rows clearfix">
                                                <label>Ngày</label>
                                                <div class="input-box">
                                                    <input type="text" id="f_rangeStart_right" name="ngay" class="input-date" value="<?php echo $fromdate_right ?>" />
                                                </div>
                                            </div>
                                            <div class="rows clearfix">
                                                <label>Vé số</label>
                                                <div class="input-box"><input type="text" id="so_right" name="so" value="<?php echo $so_right ?>" maxlength="6" /></div>
                                            </div>
                                            <div class="rows clearfix">
                                                <label>Tỉnh</label>
                                                <div class="input-box">
                                                    <div class="left" id="boxCity_right"></div>
                                                </div>
                                            </div>
                                            <div class="rows clearfix">
                                                <label>&nbsp;</label>
                                                <div class="input-box space">
                                                    <button type="button" class="button" onclick="return dovesoright()"><span><span>Dò kết quả</span></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mod-module">
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">XỔ SỐ HÔM NAY</span></div></div>
                                    <div class="mod-content-date">
                                        <?php if (!isset($alias) || $alias == '') {
                                            $alias = 'ket-qua';
                                        }$date_time = date('Ymd', time());
                                        if (isset($date) && $date != '') {
                                            $date_time = date('Ymd', strtotime($date));
                                        } ?>
                                        <div id="calendar-container"></div>
                                    </div>
                                </div>
                                <div class="mod-module">
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">TIN MỚI</span></div></div>
                                    <ul class="category-provide category-news">
<?php foreach ($lastnews as $k => $row) { ?>
                                            <li><a class="font11" href="<?php echo news_link($row->title_link); ?>" title="<?php echo view_title($row->title) ?>"><?php echo short_text($row->title, 35) ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="mod-module">
                                    <div class="mod-banner-right">
<?php foreach ($banner as $v) {
    if ($v->position == 'bottom_new' && ($v->page == 'all' || $v->page == $c_module)) { ?>
                                                <div><a target="_blank" href="<?php echo $v->url; ?>" title="<?php echo view_title($v->name); ?>"><img src="<?php echo site_url($v->image); ?>" width="200" alt="<?php echo view_title($v->name); ?>" /></a></div>
                                        <?php }
                                    } ?>
                                    </div>
                                </div>
                                <div class="mod-module">
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">Mã Tỉnh / Thành Phố</span></div></div>
                                    <div class="title-provide">MIỀN BẮC</div>
                                    <ul class="category-provide list-provide">
                                        <li class="clearfix"><span class="span-bna">MB</span><a href="<?php echo $uri_root . $url_mienbac ?>.html">Xổ số Miền Bắc</a></li>
                                    </ul>
                                    <div class="title-provide">MIỀN TRUNG</div>
                                    <ul class="category-provide list-provide">
        <?php foreach ($location_menu['MT'] as $value) {
            echo '<li class="clearfix"><span class="span-bna">' . $value->code . '</span><a href="' . $uri_root . $value->alias . '.html">Xổ số ' . $value->name . '</a></li>';
        } ?>
                                    </ul>
                                    <div class="title-provide">MIỀN NAM</div>
                                    <ul class="category-provide list-provide">
        <?php foreach ($location_menu['MN'] as $value) {
            echo '<li class="clearfix"><span class="span-bna">' . $value->code . '</span><a href="' . $uri_root . $value->alias . '.html">Xổ số ' . $value->name . '</a></li>';
        } ?>
                                    </ul>
                                </div>
                                <div class="mod-module footer-cen">
<?php foreach ($xs_keyword as $v)
    echo $v->name; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->load->view($layout_footer) ?>
        </div>
        <script type="text/javascript">/*<![CDATA[*/var LEFT_CAL = Calendarc.setup({cont: "calendar-container", max:<?php echo date('Ymd', time()) ?>, date:<?php echo $date_time ?>, selectionType: Calendarc.SEL_SINGLE, showTime: 12, onSelect: function(c) {
            var b = c.selection.get();
            if (b) {
                b = Calendarc.intToDate(b);
                var a = Calendarc.printDate(b, "%d-%m-%Y");
                window.location.href = "<?php echo $uri_root . $alias ?>/" + a + ".html"
            }
        }});
    $(function() {
        $("#select_provide").selectbox()
    });
    $("#f_rangeStart_right").datepick({dateFormat: "dd-mm-yyyy", maxDate: +0, onSelect: function() {
            loadtinhright()
        }});/*]]>*/</script>
        <script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-31260907-1', 'xoso.com');
            ga('require', 'displayfeatures');
            ga('send', 'pageview');
        </script>
    </body>
</html>