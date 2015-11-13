<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php echo(isset($_meta['description']) ? $_meta['description'] : ''); ?>" />
        <meta name="keywords" content="<?php echo(isset($_meta['keywords']) ? $_meta['keywords'] : ''); ?>" />
        <title><?php echo(isset($_meta['title']) ? $_meta['title'] : ''); ?></title>
        <meta property="og:image" content="<?php echo img_link('logo.png') ?>" />
        <link type="image/x-icon" href="<?php echo img_link('favicon.ico') ?>" rel="shortcut icon" />
        <link href="<?php echo css_link('style.css') ?>" rel="stylesheet" type="text/css" />        
        <link type="text/css" rel="stylesheet" href="<?php echo css_link('lich/jscal2.css') ?>" />        
        <link href="<?php echo css_link('jquery.datepick.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo css_link('stylesbh.css?v=2.5') ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo js_link('jquery-1.7.2.js') ?>"></script>
        <script type="text/javascript" src="<?php echo js_link('jquery.selectbox-0.2.js') ?>"></script>       
        <script type="text/javascript" src="<?php echo js_link('lich/jscal2.js') ?>"></script>
        <script type="text/javascript" src="<?php echo js_link('lich/en.js') ?>"></script>              
        <script type="text/javascript" src="<?php echo js_link('jquery-ui.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo js_link('jquery.datepick.js') ?>"></script>
        <script type="text/javascript" src="<?php echo js_link('common.js') ?>"></script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-31260907-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <meta name="google-site-verification" content="_MdXAARqGNM7C1GRrfqgrQg59dJuCGxL_3E4tJf_se0" />
        <script type="text/javascript">
            var uri_root='<?php echo $uri_root ?>';function loadtinhright(){var d=$("#f_rangeStart_right").val();if(d==""){alert('Vui lòng nhập ngày mở thưởng trên tờ vé !');document.form_doveso_right.ngay.focus();return false}$.ajax({type:"GET",url:"<?php echo $uri_root ?>loadtinhs/<?php echo $lid_right ?>/"+d,success:function(data){$("#boxCity_right").html(data);$("#select_provide").selectbox()}})}$(document).ready(function(e){loadtinhright()});function dovesoright(){if($("#so_right").val()==""){alert('Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)');document.form_doveso_right.so.focus();return false}else if($("#so_right").val().length<5){alert('Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)');document.form_doveso_right.so.focus();return false}else if($("#f_rangeStart_right").val()==""){alert('Vui lòng nhập ngày mở thưởng trên tờ vé !');document.form_doveso_right.ngay.focus();return false}else document.form_doveso_right.submit()}
            var googletag=googletag||{};googletag.cmd=googletag.cmd||[];(function(){var gads=document.createElement('script');gads.async=true;gads.type='text/javascript';var useSSL='https:'==document.location.protocol;gads.src=(useSSL?'https:':'http:')+'//www.googletagservices.com/tag/js/gpt.js';var node=document.getElementsByTagName('script')[0];node.parentNode.insertBefore(gads,node)})();
            googletag.cmd.push(function() {
                googletag.defineSlot('/35883025/xs_top', [970, 90], 'div-gpt-ad-1378288615889-0').addService(googletag.pubads());
                googletag.defineSlot('/35883025/xs_b1', [336, 280], 'div-gpt-ad-1378288615889-1').addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });
        </script>
        <?php
        if ($c_module == 'xoso' && $c_func == 'filter_date' && isset($items[0])) {
            $shared_content = 'Xổ Số ' . $items[0]->name . ' ngày ' . $date . ',';
            $shared_content.=' giải DB: ' . $items[0]->a0 . ',';
            $shared_content.=' giải nhất: ' . $items[0]->a1 . ',';
            $shared_content.=' giải nhì: ' . $items[0]->a2 . ',';
            $shared_content.=' giải ba: ' . $items[0]->a3 . ',';
            $shared_content.=' giải tư: ' . $items[0]->a4 . ',';
            $shared_content.=' giải năm: ' . $items[0]->a5 . ',';
            $shared_content.=' giải sáu: ' . $items[0]->a6 . ',';
            $shared_content.=' giải bảy: ' . $items[0]->a7;
            if ($items[0]->area != 'MB')
                $shared_content.=', giải tám: ' . $items[0]->a8;

            echo '<meta property="og:description" content="' . $shared_content . '" />';
        }
        ?>
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
                                <?php $this->load->view($tmpl) ?>
                                <br/>
                            </div>
                            <div class="col-right">
                                <div class="mod-module">
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">XỔ SỐ HÔM NAY</span></div></div>
                                    <div class="mod-content-date">
                                        <?php
                                        if (!isset($alias) || $alias == '') {
                                            $alias = 'ket-qua';
                                        }
                                        $date_time = date('Ymd', time());
                                        if (isset($date) && $date != '') {
                                            $date_time = date('Ymd', strtotime($date));
                                        }
                                        ?>
                                        <div id="calendar-container"></div>
                                    </div>
                                </div>
                                <div class="mod-module">
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
                                                    <button type="button" class="button" onclick="return dovesoright();"><span><span>Dò kết quả</span></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mod-module">
                                    <div class="title title-yelow"><div class="title-right"><span class="icon">TIN MỚI</span></div></div>
                                    <ul class="category-provide category-news">
                                        <?php foreach ($lastnews as $k => $row) { ?>
                                            <li><a class="font11" href="<?php echo news_link($row->title_link); ?>" title="<?php echo view_title($row->title) ?>"><?php echo short_text($row->title, 38) ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="mod-module">
                                    <div class="mod-banner-right">
                                        <?php
                                        foreach ($banner as $v) {
                                            if ($v->position == 'bottom_new' && ($v->page == 'all' || $v->page == $c_module)) {
                                                ?>
                                                <div><a target="_blank" href="<?php echo $v->url; ?>" title="<?php echo view_title($v->name); ?>"><img src="<?php echo site_url($v->image); ?>" width="200" alt="<?php echo view_title($v->name); ?>" /></a></div>
                                                <?php
                                            }
                                        }
                                        ?>
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
                                        <?php
                                        foreach ($location_menu['MT'] as $value) {
                                            echo '<li class="clearfix"><span class="span-bna">' . $value->code . '</span><a href="' . $uri_root . $value->alias . '.html">Xổ số ' . $value->name . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                    <div class="title-provide">MIỀN NAM</div>
                                    <ul class="category-provide list-provide">
                                        <?php
                                        foreach ($location_menu['MN'] as $value) {
                                            echo '<li class="clearfix"><span class="span-bna">' . $value->code . '</span><a href="' . $uri_root . $value->alias . '.html">Xổ số ' . $value->name . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="mod-module">
                                    <div class="mod-banner-right">
                                        <?php
                                        foreach ($banner as $v) {
                                            if ($v->position == 'right' && ($v->page == 'all' || $v->page == $c_module)) {
                                                ?>
                                                <div><a target="_blank" href="<?php echo $v->url; ?>" title="<?php echo view_title($v->name); ?>"><img src="<?php echo site_url($v->image); ?>" width="200" alt="<?php echo view_title($v->name); ?>" /></a></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="mod-module footer-cen">
                                    <?php
                                    foreach ($xs_keyword as $v)
                                        echo $v->name;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view($layout_footer) ?>
        </div>
        <script type="text/javascript">
            var LEFT_CAL=Calendarc.setup({cont:"calendar-container",max:<?php echo date('Ymd', time()) ?>,date:<?php echo $date_time ?>,selectionType:Calendarc.SEL_SINGLE,showTime:12,onSelect:function(cal){var date=cal.selection.get();if(date){date=Calendarc.intToDate(date);var f_date=Calendarc.printDate(date,"%d-%m-%Y");window.location.href='<?php echo $uri_root . $alias ?>/'+f_date+'.html'}}});$(function(){$("#select_provide").selectbox()});$("#f_rangeStart_right").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0,onSelect:function(){loadtinhright()}});
        </script>
    </body>
</html>