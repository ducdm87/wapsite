<style type="text/css">
    .top-links{position:relative}
    .top-links .menuopener{float:left;padding:0 10px;font-weight:700;cursor:pointer}
    .top-links .menuopener span{line-height:30px;float:left}
    .top-links .menuopener span.arrow{padding:0 12px 0 0;background:url(<?php echo $uri_root ?>public/client/images/sprites11.png) no-repeat right -102px}
    .menudd{background:#F5F5F5;display:none;position:absolute;z-index:1000;top:25px;right:0;border:#e1e1e1 1px solid;text-align:left}
    .menudd *{color:#111}
    .menudd a:link{line-height:14px;display:block;*width:100%;color:#111;font-weight:400;padding:5px 5px 5px 12px;background:url(/public/client/images/sprites11.png) no-repeat 5px -157px}
    .menudd a:visited{line-height:14px;display:block;*width:100%;color:#111;font-weight:400;padding:5px 5px 5px 12px;background:url(/public/client/images/sprites11.png) no-repeat 5px -157px}
    .menudd a:hover{line-height:14px;display:block;*width:100%;color:#fff;font-weight:400;background:#b53021;padding:5px}
    .menudd a:active{line-height:14px;display:block;*width:100%;color:#fff;font-weight:400;background:#b53021;padding:5px}
    .hello{background:url(<?php echo $uri_root ?>public/client/images/user-info.gif) no-repeat;height:54px;line-height:20px;padding:10px 0 0 69px}
    .hello strong{color:#841609;font-size:14px}
</style>
<div class="top-links-wrap">
    <div class="top-links">
        <div class="left">
            <a href="<?php echo $uri_root ?>loto-online.html"><span>Dự đoán Online</span></a> | <a href="<?php echo $uri_root ?>giao-luu-thao-luan-chot-so-lotto.html"><span>Thảo luận - Chốt Số</span></a> | <a href="<?php echo $uri_root ?>soi-cau.html"><span>Soi Cầu</span></a>
        </div>
        <div id="userbox" class="right"></div>
        <script type="text/javascript">var uid='';var curruser='';var user='';var taikhoan='';function loadst(){$.ajax({url:uri_root+"client/user/loadst",cache:false,success:function (c){var objuser=jQuery.parseJSON(c);uid=objuser.id;curruser=objuser.username;user=objuser.fullname;taikhoan=objuser.taikhoan;$(".hello").html('Xin chào:<br/><strong>'+curruser+'</strong>');$("#taikhoanloto").html(taikhoan);$("#userbox").html(objuser.strlogin);$(".menuopener").click(function () {if ($(".menudd").css("display") != "block") {$(".menudd").css("display", "block");} else {$("div.menudd").css("display", "none");}});}});}loadst();</script>
    </div>
</div>
<div class="header-wrap">
    <div class="header">
        <?php echo $c_module == 'home' ? '<h1 style="position: absolute; text-indent: -99999px">' . $_meta['title'] . '</h1>' : '' ?>
        <a href="<?php echo $uri_root ?>" class="logo"><img src="<?php echo img_link('logo.png'); ?>" width="236" height="94" alt="" /></a>
        <div class="mod-banner-home">
            <?php foreach ($banner as $v) {
                if ($v->position == 'top' && ($v->page == 'all' || $v->page == $c_module)) { ?>
                    <div><a target="_blank" href="<?php echo $v->url; ?>" title="<?php echo view_title($v->name); ?>"><img src="<?php echo site_url($v->image); ?>" width="728" alt="<?php echo view_title($v->name); ?>" /></a></div>
    <?php }
} ?>
        </div>
    </div>
    <div class="mainmenu-wrapp">
        <div class="mainmenu clearfix">
            <div class="main-menu-left">&nbsp;</div>
            <div class="main-menu" id="smoothmenu">
                <ul id="nav">
                    <li class="first nav-home"><a href="<?php echo $uri_root ?>" title="Trang chủ xổ số"><span>&nbsp;</span></a></li>
                    <li<?php echo $c_module == 'tructiep' ? ' class="active"' : '' ?>>
                        <a href="<?php echo $uri_root ?>tuong-thuat-truc-tiep-ket-qua-xo-so.html"><span><span class="arrow">Trực tiếp</span></span></a>
                        <ul class="submenu-border sub-menu" style="display:none">
                            <div class="top-menu-popup">
                                <li><a href="<?php echo $uri_root ?>tuong-thuat-truc-tiep-ket-qua-xo-so/mien-bac.html"><span>Trực tiếp Miền Bắc</span></a></li>
                                <li><a href="<?php echo $uri_root ?>tuong-thuat-truc-tiep-ket-qua-xo-so/mien-trung.html"><span>Trực tiếp Miền Trung</span></a></li>
                                <li><a href="<?php echo $uri_root ?>tuong-thuat-truc-tiep-ket-qua-xo-so/mien-nam.html"><span>Trực tiếp Miền Nam</span></a></li>
                                <li><a href="<?php echo $uri_root ?>lich-mo-thuong-xo-so.html"><span>Lịch mở thưởng</span></a></li>
                            </div>
                        </ul>
                    </li>
                    <li<?php echo(($c_module == 'xoso' && $c_func != 'tructiep') || $c_module == 'xs_northern') ? ' class="active"' : '' ?>>
                        <a href="<?php echo $uri_root ?>ket-qua.html"><span><span class="arrow">Kết quả xổ số</span></span></a>
                        <ul class="submenu-border sub-menu" style="display:none">
                            <div class="top-menu-popup">
                                <li><a href="<?php echo $uri_root . $url_mienbac ?>.html"><span>Kết quả Miền Bắc</span></a></li>
                                <li><a href="<?php echo $uri_root . $url_miennam ?>.html"><span>Kết quả Miền Nam</span></a></li>
                                <li><a href="<?php echo $uri_root . $url_mientrung ?>.html"><span>Kết quả Miền Trung</span></a></li>
                                <li><a href="javascript:"><span>Kết quả theo tỉnh</span></a>
                                    <ul class="submenu-border" id="menukqxstinh">
                                        <div class="top-menu-popup">
                                            <li class="root"><a href="<?php echo $uri_root . $url_mienbac ?>.html" title="Kết quả xổ số Miền Bắc"><span><strong>Kết quả xổ số Miền Bắc</strong></span></a></li>
                                            <li class="root"><a href="<?php echo $uri_root . $url_miennam ?>.html" title="Kết quả xổ số Miền Nam - Xem KQXS các tỉnh Miền Nam theo ngày"><span><strong>Kết quả xổ số Miền Nam</strong></span></a></li>
                                            <?php foreach ($location_menu['MN'] as $value) {
                                                echo '<li><a href="' . $uri_root . $value->alias . '.html" title="Kết quả xổ số ' . $value->name . ' - Xổ số Miền Nam"><span>Kết quả xổ số ' . $value->name . '</span></a></li>';
                                            } ?>
                                            <li class="root"><a href="<?php echo $uri_root . $url_mientrung ?>.html" title="Kết quả xổ số Miền Trung - Xem KQXS các tỉnh Miền Trung theo ngày"><span><strong>Kết quả xổ số Miền Trung</strong></span></a></li>
<?php foreach ($location_menu['MT'] as $value) {
    echo '<li><a href="' . $uri_root . $value->alias . '.html" title="Kết quả xổ số ' . $value->name . ' - Xổ số Miền Trung"><span>Kết quả xổ số ' . $value->name . '</span></a></li>';
} ?>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="<?php echo $uri_root ?>xo-so-dien-toan.html"><span>Kết quả điện toán</span></a></li>
                            </div>
                        </ul>
                    </li>
                    <li<?php echo $c_module == 'statistics' && $c_func != 'doveso' ? ' class="active"' : '' ?>>
                        <a href="<?php echo $uri_root ?>thong-ke-quan-trong.html"><span><span class="arrow">Thống kê</span></span></a>
                        <ul class="submenu-border sub-menu" style="display:none">
                            <div class="top-menu-popup">
                                <li><a href="<?php echo $uri_root ?>thong-ke-xo-so-hom-nay.html"><span>Thống kê cơ bản</span></a>
                                    <ul class="submenu-border sub-menu">
                                        <div class="top-menu-popup">
                                            <li><a href="<?php echo $uri_root ?>thongke-dau-duoi-0-9.html"><span>Thống kê đầu, đuôi</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-tong-chan.html"><span>Thống kê theo tổng chẵn</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-tong-le.html"><span>Thống kê theo tổng lẻ</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-theo-tong-0-9.html"><span>Thống kê theo tổng 2 số cuối</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-cap-so-tu-00-99.html"><span>Thống kê 00 - 99</span></a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="<?php echo $uri_root ?>thong-ke-lo-to-tinh.html"><span>Thống kê Loto</span></a>
                                    <ul class="submenu-border sub-menu">
                                        <div class="top-menu-popup">
                                            <li><a href="<?php echo $uri_root ?>thong-ke-quan-trong.html"><span>Thống kê quan trọng</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-theo-bo-so.html"><span>Thống kê theo bộ số</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-lo-to-tinh.html"><span>Thống kê Loto nhanh</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-lo-gan.html"><span>Thống kê Loto gan</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-lo-to-theo-dau-duoi.html"><span>Thống kê Loto theo đầu / đuôi</span></a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="<?php echo $uri_root ?>thong-ke-giai-dac-biet-theo-tuan.html"><span>Thống kê đặc biệt</span></a>
                                    <ul class="submenu-border sub-menu">
                                        <div class="top-menu-popup">
                                            <li><a href="<?php echo $uri_root ?>thong-ke-lo-to-theo-tong.html"><span>Thống kê theo tổng</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-theo-chu-ky.html"><span>Thống kê theo chu kỳ</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-giai-dac-biet-theo-tuan.html"><span>Thống kê giải đặc biệt theo tuần</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thong-ke-giai-dac-biet-theo-thang.html"><span>Thống kê giải đặc biệt theo tháng</span></a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="javascript:"><span>Thống kê Cầu</span></a>
                                    <ul class="submenu-border sub-menu">
                                        <div class="top-menu-popup">
                                            <li><a href="<?php echo $uri_root ?>thongke-cau-xo-so.html"><span>Thống kê Cầu Loto</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>thongke-cau-bach-thu-mien-bac.html"><span>Thống kê Cầu bạch thủ</span></a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a target="_blank" href="<?php echo $uri_root ?>thong-ke-tan-suat-loto.html"><span>Thống kê tần suất</span></a>
                            </div>
                        </ul>
                    </li>
                    <li<?php echo $c_module == 'sodauduoi' ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam.html">Sớ đầu đuôi</a>
                        <ul class="submenu-border sub-menu" style="display:none">
                            <div class="top-menu-popup">
                                <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam.html"><span>Sớ Miền Nam</span></a>
                                    <ul class="submenu-border sub-menu">
                                        <div class="top-menu-popup">
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam.html"><span>Xem tất cả</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam/thu-hai.html"><span>Thứ Hai</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam/thu-ba.html"><span>Thứ Ba</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam/thu-tu.html"><span>Thứ Tư</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam/thu-nam.html"><span>Thứ Năm</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam/thu-sau.html"><span>Thứ Sáu</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam/thu-bay.html"><span>Thứ Bảy</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-nam/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                        </div>
                                    </ul>
                                </li><li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac.html"><span>Sớ Miền Bắc</span></a>
                                    <ul class="submenu-border sub-menu">
                                        <div class="top-menu-popup">
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac.html"><span>Xem tất cả</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac/thu-hai.html"><span>Thứ Hai</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac/thu-ba.html"><span>Thứ Ba</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac/thu-tu.html"><span>Thứ Tư</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac/thu-nam.html"><span>Thứ Năm</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac/thu-sau.html"><span>Thứ Sáu</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac/thu-bay.html"><span>Thứ Bảy</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-bac/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                        </div>
                                    </ul>
                                </li><li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung.html"><span>Sớ Miền Trung</span></a>
                                    <ul class="submenu-border sub-menu">
                                        <div class="top-menu-popup">
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung.html"><span>Xem tất cả</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung/thu-hai.html"><span>Thứ Hai</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung/thu-ba.html"><span>Thứ Ba</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung/thu-tu.html"><span>Thứ Tư</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung/thu-nam.html"><span>Thứ Năm</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung/thu-sau.html"><span>Thứ Sáu</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung/thu-bay.html"><span>Thứ Bảy</span></a></li>
                                            <li><a href="<?php echo $uri_root ?>so-dau-duoi/mien-trung/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                        </div>
                                    </ul>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <li<?php echo $c_module == 'statistics' && $c_func == 'doveso' ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>do-ve-so.html">Dò vé số</a></li>
                    <li<?php echo $c_module == 'print_xoso' && $c_func == 'index' ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>in-ve-do.html">In vé dò</a></li>
                    <li<?php echo $c_module == 'news' && ($c_func == 'index' || $c_func == 'detail') ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>tin-xo-so.html">Tin tức</a>
                        <ul class="submenu-border sub-menu" style="display:none">
                            <div class="top-menu-popup">
<?php foreach ($news_category as $value) {
    echo '<li><a href="' . $uri_root . 'tin-xo-so/danh-muc-' . $value->name_link . '.html"><span>' . $value->name . '</span></a></li>';
} ?>
                            </div>
                        </ul>
                    </li>
                    <li><a target="_blank" href="http://forum.xoso.com"><span>Diễn đàn</span></a></li>
                    <li<?php echo $c_module == 'demo' && $c_func == 'tao_ma_nhung' ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>tao-ma-nhung/ket-qua-xo-so.html">Chèn KQXS</a></li>
                </ul>
            </div>
            <div class="main-menu-right">&nbsp;</div>
        </div>
    </div>
    <div id='div-gpt-ad-1378288615889-0' style='width:970px;text-align:center' class="mainmenu">
        <script type='text/javascript'>googletag.cmd.push(function () {
        googletag.display("div-gpt-ad-1378288615889-0")
    });</script>
    </div>
</div>