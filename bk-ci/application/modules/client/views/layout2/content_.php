<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php echo(isset($_meta['description']) ? $_meta['description'] : ''); ?>" />
        <meta name="keywords" content="<?php echo(isset($_meta['keywords']) ? $_meta['keywords'] : ''); ?>" />
        <title><?php echo(isset($_meta['title']) ? $_meta['title'] : ''); ?></title>
        <link type="image/x-icon" href="<?php echo img_link('favicon.ico'); ?>" rel="shortcut icon" />
        <link href="<?php echo css_link('styles.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo css_link('stylesbh.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo css_link('ddsmoothmenu.css') ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo js_link('jquery-1.7.2.js') ?>"></script>
        <script type="text/javascript" src="<?php echo js_link('ddsmoothmenu.js') ?>"></script>
        <script type="text/javascript" src="<?php echo js_link('common.js') ?>"></script>          
    </head>
    <body>
        <div id="wrapper">
            <div class="page">
                <div class="page1">
                    <div class="header-wrapp">
                        <div class="header">
                            <img src="<?php echo img_link('banner.gif'); ?>" width="990" height="137" alt="" />
                            <ul class="links-contact">
                                <li><a href="/lien-he-quan-tri.html">Liên hệ</a></li>
                            </ul>
                            <?php
                            if ($c_module == 'home')
                                echo '<h1 style="display:none">Cổng thông tin truy nã tội phạm</h1>';
                            ?>
                            <div class="infor">Cổng thông tin truy nã tội phạm</div>
                            <div class="mod-date">
                                <?php
                                $today = time();
                                $day = date('N', $today);
                                switch ($day) {
                                    case 1:
                                        $thu = "Thứ Hai";
                                        break;
                                    case 2:
                                        $thu = "Thứ Ba";
                                        break;
                                    case 3:
                                        $thu = "Thứ Tư";
                                        break;
                                    case 4:
                                        $thu = "Thứ Năm";
                                        break;
                                    case 5:
                                        $thu = "Thứ Sáu";
                                        break;
                                    case 6:
                                        $thu = "Thứ Bảy";
                                        break;
                                    case 7:
                                        $thu = "Chủ Nhật";
                                        break;
                                }
                                echo $thu . ', ' . date('d/m/Y', $today);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="nav-container">
                        <div id="smoothmenu" class="ddsmoothmenu">
                            <ul>
                                <li><a href="javascript:;" ><span>Trực Tiếp</span></a>
                                    <ul class="submenu-border">
                                        <div class="top-menu-popup">
                                            <li><a href="/xo-so-truc-tiep/mien-nam.html"><span>Trực Tiếp Xổ Số Miền Nam</span></a></li>
                                            <li><a href="/xo-so-truc-tiep/mien-bac.html"><span>Trực Tiếp Xổ Số Miền Bắc</span></a></li>
                                            <li><a href="/xo-so-truc-tiep/mien-trung.html"><span>Trực Tiếp Xổ Số Miền Trung</span></a></li>
                                            <li><a href="/thong-tin/lich-quay-so-mo-thuong.html"><span>Lịch Quay Số Mở Thưởng</span></a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="javascript:;"><span>Kết Quả Xổ Số</span></a>
                                    <ul class="submenu-border">
                                        <div class="top-menu-popup">
                                            <li ><a href="/<?php echo $url_miennam ?>.html" class="parent"><span>KQXS Miền Nam</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/<?php echo $url_miennam ?>.html"><span>Xem tất Cả</span></a></li>
                                                        <li><a href="/<?php echo $url_miennam ?>/thu-hai.html"><span>Thứ Hai</span></a></li>
                                                        <li><a href="/<?php echo $url_miennam ?>/thu-ba.html"><span>Thứ Ba</span></a></li>
                                                        <li><a href="/<?php echo $url_miennam ?>/thu-tu.html"><span>Thứ Tư</span></a></li>
                                                        <li><a href="/<?php echo $url_miennam ?>/thu-nam.html"><span>Thứ Năm</span></a></li>
                                                        <li><a href="/<?php echo $url_miennam ?>/thu-sau.html"><span>Thứ sáu</span></a></li>
                                                        <li><a href="/<?php echo $url_miennam ?>/thu-bay.html"><span>Thứ bảy</span></a></li>
                                                        <li><a href="/<?php echo $url_miennam ?>/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li> <a href="/<?php echo $url_mienbac ?>.html" class="parent"><span>KQXS Miền Bắc</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/<?php echo $url_mienbac ?>.html"><span>Xem tất Cả</span></a></li>
                                                        <li><a href="/<?php echo $url_mienbac ?>/thu-hai.html"><span>Thứ Hai</span></a></li>
                                                        <li><a href="/<?php echo $url_mienbac ?>/thu-ba.html"><span>Thứ Ba</span></a></li>
                                                        <li><a href="/<?php echo $url_mienbac ?>/thu-tu.html"><span>Thứ Tư</span></a></li>
                                                        <li><a href="/<?php echo $url_mienbac ?>/thu-nam.html"><span>Thứ Năm</span></a></li>
                                                        <li><a href="/<?php echo $url_mienbac ?>/thu-sau.html"><span>Thứ sáu</span></a></li>
                                                        <li><a href="/<?php echo $url_mienbac ?>/thu-bay.html"><span>Thứ bảy</span></a></li>
                                                        <li><a href="/<?php echo $url_mienbac ?>/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li> <a href="/<?php echo $url_mientrung ?>.html" class="parent"><span>KQXS Miền Trung</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/<?php echo $url_mientrung ?>.html"><span>Xem tất Cả</span></a></li>
                                                        <li><a href="/<?php echo $url_mientrung ?>/thu-hai.html"><span>Thứ Hai</span></a></li>
                                                        <li><a href="/<?php echo $url_mientrung ?>/thu-ba.html"><span>Thứ Ba</span></a></li>
                                                        <li><a href="/<?php echo $url_mientrung ?>/thu-tu.html"><span>Thứ Tư</span></a></li>
                                                        <li><a href="/<?php echo $url_mientrung ?>/thu-nam.html"><span>Thứ Năm</span></a></li>
                                                        <li><a href="/<?php echo $url_mientrung ?>/thu-sau.html"><span>Thứ sáu</span></a></li>
                                                        <li><a href="/<?php echo $url_mientrung ?>/thu-bay.html"><span>Thứ bảy</span></a></li>
                                                        <li><a href="/<?php echo $url_mientrung ?>/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li> <a href="javascript:;" class="parent"><span>KQXS Theo Tỉnh/TP</span></a>
                                                <ul class="submenu-border" id="menukqxstinh">
                                                    <div class="top-menu-popup">
                                                        <li class="root"><a href="/<?php echo $url_miennam ?>.html" title="Kết quả xổ số Miền Nam - Xem KQXS các tỉnh Miền Nam theo ngày"><span><strong>Kết quả xổ số Miền Nam</strong></span></a></li>
                                                        <?php
                                                        foreach ($location_menu['MN'] as $value) {
                                                            echo '<li><a href="/' . $value->alias . '.html" title="Kết quả xổ số ' . $value->name . ' - Xổ số Miền Nam"><span>Kết quả xổ số ' . $value->name . '</span></a></li>';
                                                        }
                                                        ?>
                                                        <li class="root"><a href="/<?php echo $url_mientrung ?>.html" title="Kết quả xổ số Miền Trung - Xem KQXS các tỉnh Miền Trung theo ngày"><span><strong>Kết quả xổ số Miền Trung</strong></span></a></li>
                                                        <?php
                                                        foreach ($location_menu['MT'] as $value) {
                                                            echo '<li><a href="/' . $value->alias . '.html" title="Kết quả xổ số ' . $value->name . ' - Xổ số Miền Trung"><span>Kết quả xổ số ' . $value->name . '</span></a></li>';
                                                        }
                                                        ?>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li> <a href="/xo-so-dien-toan.html" class="parent"><span>KQXS Điện Toán</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/xo-so-dien-toan.html"  title="Xổ số Điện Toán "><span>Xem tất cả</span></a></li>
                                                        <li><a href="/xo-so-dien-toan/1*2*3.html" title="Click xem tất cả 1*2*3"><span>Xổ Số 1*2*3</span></a></li>
                                                        <li><a href="/xo-so-dien-toan/6x36.html" title="Click xem tất cả 6X36"><span>Xổ Số 6X36</span></a></li>
                                                        <li><a href="/xo-so-dien-toan/than-tai-4.html" title="Click xem tất cả Thần Tài 4"><span>Xổ Số Thần Tài 4</span></a></li>                                                        
                                                    </div>
                                                </ul>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="/so-dau-duoi/mien-nam.html"><span>Sớ Đầu Đuôi</span></a>
                                    <ul class="submenu-border">
                                        <div class="top-menu-popup">
                                            <li><a href="/so-dau-duoi/mien-nam.html" class="parent"><span>Sớ Miền Nam</span></a>
                                                <ul class="submenu-border"><div class="top-menu-popup">
                                                        <li><a href="/so-dau-duoi/mien-nam.html"><span>Xem tất cả</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-nam/thu-hai.html"><span>Thứ Hai</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-nam/thu-ba.html"><span>Thứ Ba</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-nam/thu-tu.html"><span>Thứ Tư</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-nam/thu-nam.html"><span>Thứ Năm</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-nam/thu-sau.html"><span>Thứ sáu</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-nam/thu-bay.html"><span>Thứ bảy</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-nam/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li> <a href="/so-dau-duoi/mien-bac.html" class="parent"><span>Sớ Miền Bắc</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/so-dau-duoi/mien-bac.html"><span>Xem tất cả</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-bac/thu-hai.html"><span>Thứ Hai</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-bac/thu-ba.html"><span>Thứ Ba</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-bac/thu-tu.html"><span>Thứ Tư</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-bac/thu-nam.html"><span>Thứ Năm</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-bac/thu-sau.html"><span>Thứ sáu</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-bac/thu-bay.html"><span>Thứ bảy</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-bac/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li> <a href="/so-dau-duoi/mien-trung.html" class="parent"><span>Sớ Miền Trung</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/so-dau-duoi/mien-trung.html"><span>Xem tất cả</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-trung/thu-hai.html"><span>Thứ Hai</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-trung/thu-ba.html"><span>Thứ Ba</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-trung/thu-tu.html"><span>Thứ Tư</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-trung/thu-nam.html"><span>Thứ Năm</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-trung/thu-sau.html"><span>Thứ sáu</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-trung/thu-bay.html"><span>Thứ bảy</span></a></li>
                                                        <li><a href="/so-dau-duoi/mien-trung/chu-nhat.html"><span>Chủ Nhật</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="/thong-ke-xo-so.html"><span>Thống Kê</span></a>
                                    <ul class="submenu-border">
                                        <div class="top-menu-popup">
                                            <li><a href="#" ><span>Thống Kê Theo Tỉnh</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/lo-to-tinh.html"><span>Thống Kê Lô</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/gan-cuc-dai-tinh.html"><span>Kiểm Tra Gan Cực Đại</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/tan-suat-tinh.html"><span>Thống Kê Tần Suất</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/tan-suat-chi-tiet-tinh.html" target="_blank"><span>Thống Kê Tần Suất Chi Tiết</span></a></li>


                                            <li> <a href="#"><span>Thống Kê Theo Miền</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/lo-to-mien.html"><span>Thống Kê Lô</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/gan-cuc-dai-mien.html"><span>Kiểm Tra Gan Cực Đại</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/tan-suat-mien.html"><span>Thống Kê Tần Suất</span></a></li>
                                            <li class="child"><a href="/thong-ke-xo-so/tan-suat-chi-tiet-mien.html" target="_blank"><span>Thống Kê Tần Suất Chi Tiết</span></a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="/ve-so.html"><span>Vé Số</span></a>
                                    <ul class="submenu-border"><div class="top-menu-popup">
                                            <li ><a class="parent" href="/ve-so/mien-nam.html" title="Xem Vé Số Miền Nam"><span>Vé Số Miền Nam</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/ve-so/mien-nam.html" title="Vé Số"><span>Xem tất cả</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/an-giang.html" title="Xem Vé Số An Giang"><span>Vé Số An Giang</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/bac-lieu.html" title="Xem Vé Số Bạc Liêu"><span>Vé Số Bạc Liêu</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/ben-tre.html" title="Xem Vé Số Bến Tre"><span>Vé Số Bến Tre</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/binh-duong.html" title="Xem Vé Số Bình Dương"><span>Vé Số Bình Dương</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/binh-phuoc.html" title="Xem Vé Số Bình Phước"><span>Vé Số Bình Phước</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/binh-thuan.html" title="Xem Vé Số Bình Thuận"><span>Vé Số Bình Thuận</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/ca-mau.html" title="Xem Vé Số Cà Mau"><span>Vé Số Cà Mau</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/can-tho.html" title="Xem Vé Số Cần Thơ"><span>Vé Số Cần Thơ</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/da-lat.html" title="Xem Vé Số Đà Lạt"><span>Vé Số Đà Lạt</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/dong-nai.html" title="Xem Vé Số Đồng Nai"><span>Vé Số Đồng Nai</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/dong-thap.html" title="Xem Vé Số Đồng Tháp"><span>Vé Số Đồng Tháp</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/hau-giang.html" title="Xem Vé Số Hậu Giang"><span>Vé Số Hậu Giang</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/kien-giang.html" title="Xem Vé Số Kiên Giang"><span>Vé Số Kiên Giang</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/long-an.html" title="Xem Vé Số Long An"><span>Vé Số Long An</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/soc-trang.html" title="Xem Vé Số Sóc Trăng"><span>Vé Số Sóc Trăng</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/tay-ninh.html" title="Xem Vé Số Tây Ninh"><span>Vé Số Tây Ninh</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/tien-giang.html" title="Xem Vé Số Tiền Giang"><span>Vé Số Tiền Giang</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/tp-hcm.html" title="Xem Vé Số TP. HCM"><span>Vé Số TP. HCM</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/tra-vinh.html" title="Xem Vé Số Trà Vinh"><span>Vé Số Trà Vinh</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/vinh-long.html" title="Xem Vé Số Vĩnh Long"><span>Vé Số Vĩnh Long</span></a></li>
                                                        <li><a href="/ve-so/mien-nam/vung-tau.html" title="Xem Vé Số Vũng Tàu"><span>Vé Số Vũng Tàu</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li ><a class="parent" href="/ve-so/mien-bac.html" title="Xem Vé Số Miền Bắc"><span>Vé Số Miền Bắc</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/ve-so/mien-bac.html" title="Vé Số"><span>Xem tất cả</span></a></li>
                                                        <li><a href="/ve-so/mien-bac/bac-ninh.html" title="Xem Vé Số Bắc Ninh"><span>Vé Số Bắc Ninh</span></a></li>
                                                        <li><a href="/ve-so/mien-bac/ha-noi.html" title="Xem Vé Số Hà Nội"><span>Vé Số Hà Nội</span></a></li>
                                                        <li><a href="/ve-so/mien-bac/hai-phong.html" title="Xem Vé Số Hải Phòng"><span>Vé Số Hải Phòng</span></a></li>
                                                        <li><a href="/ve-so/mien-bac/nam-dinh.html" title="Xem Vé Số Nam Định"><span>Vé Số Nam Định</span></a></li>
                                                        <li><a href="/ve-so/mien-bac/quang-ninh.html" title="Xem Vé Số Quảng Ninh"><span>Vé Số Quảng Ninh</span></a></li>
                                                        <li><a href="/ve-so/mien-bac/thai-binh.html" title="Xem Vé Số Thái Bình"><span>Vé Số Thái Bình</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li ><a class="parent" href="/ve-so/mien-trung.html" title="Xem Vé Số Miền Trung"><span>Vé Số Miền Trung</span></a>
                                                <ul class="submenu-border">
                                                    <div class="top-menu-popup">
                                                        <li><a href="/ve-so/mien-trung.html" title="Vé Số"><span>Xem tất cả</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/binh-dinh.html" title="Xem Vé Số Bình Định"><span>Vé Số Bình Định</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/da-nang.html" title="Xem Vé Số Đà Nẵng"><span>Vé Số Đà Nẵng</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/dak-lak.html" title="Xem Vé Số Đắk Lắk"><span>Vé Số Đắk Lắk</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/dak-nong.html" title="Xem Vé Số Đắk Nông"><span>Vé Số Đắk Nông</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/gia-lai.html" title="Xem Vé Số Gia Lai"><span>Vé Số Gia Lai</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/khanh-hoa.html" title="Xem Vé Số Khánh Hòa"><span>Vé Số Khánh Hòa</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/kon-tum.html" title="Xem Vé Số Kon Tum"><span>Vé Số Kon Tum</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/ninh-thuan.html" title="Xem Vé Số Ninh Thuận"><span>Vé Số Ninh Thuận</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/phu-yen.html" title="Xem Vé Số Phú Yên"><span>Vé Số Phú Yên</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/quang-binh.html" title="Xem Vé Số Quảng Bình"><span>Vé Số Quảng Bình</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/quang-nam.html" title="Xem Vé Số Quảng Nam"><span>Vé Số Quảng Nam</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/quang-ngai.html" title="Xem Vé Số Quảng Ngãi"><span>Vé Số Quảng Ngãi</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/quang-tri.html" title="Xem Vé Số Quảng Trị"><span>Vé Số Quảng Trị</span></a></li>
                                                        <li><a href="/ve-so/mien-trung/thua-thien-hue.html" title="Xem Vé Số Thừa T. Huế"><span>Vé Số Thừa T. Huế</span></a></li>
                                                    </div>
                                                </ul>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="/in-ve-do.html"><span>In Vé Dò</span></a></li>
                                <li><a href="/tin-tuc.html"><span>Tin Tức</span></a></li>                                
                                <li style="float:right"><a href="/help.html"><span>Help ?</span></a>
                                    <ul class="submenu-border" style="width:auto"><div class="top-menu-popup"><li ><a href="/help/44-huong-dan-in-ve-do-ket-qua-xo-so.html"><span>Hướng Dẫn In Vé Dò Kết Quả Xổ Số</span></a></li><li ><a href="/help/40-huong-dan-dang-ky-thanh-vien-in-ve-do-va-ban-xo-so-online.html"><span>Hướng dẫn đăng ký thành viên, in vé dò và bán xổ số online</span></a></li><li ><a href="/help/41-co-gi-moi-trong-phien-ban-nay.html"><span>Có gì mới trong phiên bản này</span></a></li><li ><a href="/help/42-lay-ket-qua-xo-so-ve-websites-cua-ban.html"><span>Lấy kết quả xổ số về websites của bạn</span></a></li></div></ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    if (isset($alias) && $alias != '') {
                        $date_time = date('Ymd', time());
                        if (isset($date) && $date != '') {
                            $date_time = date('Ymd', strtotime($date));
                        }
                        ?>
                        <div style="width:198px;height:179px;clear:both">
                            <link type="text/css" rel="stylesheet" href="<?php echo css_link('lich/jscal2.css') ?>" />
                            <link type="text/css" rel="stylesheet" href="<?php echo css_link('lich/border-radius.css') ?>" />
                            <script type="text/javascript" src="<?php echo js_link('lich/jscal2.js') ?>"></script>
                            <script type="text/javascript" src="<?php echo js_link('lich/en.js') ?>"></script>
                            <div id="calendar-container"></div>
                            <script type="text/javascript">
                                var DISABLED_DATES = {<?php echo $date_time ?>: true};
                                var LEFT_CAL = Calendarc.setup({
                                    cont: "calendar-container",
                                    date: <?php echo $date_time ?>,
                                    disabled : function(date) {
                                        date = Calendarc.dateToInt(date);
                                        return date in DISABLED_DATES;
                                    },
                                    selectionType: Calendarc.SEL_SINGLE,
                                    showTime: 12,
                                    onSelect : function(cal) {
                                        var date = cal.selection.get();
                                        if (date) {
                                            date = Calendarc.intToDate(date);
                                            var f_date = Calendarc.printDate(date, "%d-%m-%Y");					
                                            window.location.href='/<?php echo $alias ?>/' + f_date +'.html';
                                        }
                                    }
                                });
                            </script>
                        </div>
                    <?php } ?>
                    <div class="main">
                        <?php $this->load->view($tmpl) ?>
                    </div>
                    <div class="footer">
                        <div class="footer-top clearfix">
                            <ul class="left">
                                <li><a rel="nofollow" href="<?php echo site_url(); ?>">Trang chủ</a></li>
                                <li><a href="/lien-he-quan-tri.html">Liên hệ</a></li>
                            </ul>
                            <a href="#top" class="back-top">Lên đầu trang</a>
                        </div>
                        <div class="footer-bot clearfix">
                            <div class="footer-logo">
                                <img src="<?php echo img_link('logo-footer.png'); ?>" width="70" height="95" alt="" /></div>
                            <p class="title"><strong class="red">Cổng thông tin truy nã tội phạm</strong></p>                            
                            <p>Website đang trong quá trình chạy thử nghiệm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>