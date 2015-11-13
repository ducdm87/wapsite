<?php
if ($so <= 0)
    return;

$lname = '';
$statistics_alias = '';
foreach ($xs_location_menu as $value) {
    if ($lid == $value->id) {
        $lname = $value->name;
        $statistics_alias = $value->alias;
        break;
    }
}
$fromdate = date('d/m/Y', strtotime($fromdate));
?>
<div class="thongbao">
    <b id="tit_content">Kết quả vé số dò <?php echo $fromdate ?></b>
    <div class="nd">
        <p>Bạn đã dò kết quả vé số Xổ Số <?php echo $lname ?></p>
        <p>Loại vé <?php echo strlen($so) ?> chữ số</p>
        <p>Mở thưởng ngày <?php echo $fromdate ?></p>
        <p>Dãy số của bạn <strong><?php echo $so ?></strong> </p>
        <div class="ketqua">
            <?php
            if ($items) {
                $class = '';
                $giaithuong = array(
                    '200.000.000'
                    , '20.000.000'
                    , '5.000.000'
                    , '2.000.000'
                    , '400.000'
                    , '200.000'
                    , '100.000'
                    , '40.000'
                    , '40.000'
                );
                $url = '';
                switch ($items->area) {
                    case 'MB':
                        $l_area = 'Truyền thống';
                        $class = ' kqmienbac';
                        $url = $url_mienbac;
                        break;
                    case 'MT':
                        $l_area = 'Miền Trung';
                        $class = ' kqmiennam';
                        $url = $url_mientrung;
                        if (strlen($items->a0) == 5)
                            $giaithuong = array(
                                '250.000.000'
                                , '40.000.000'
                                , '10.000.000'
                                , '5.000.000'
                                , '2.500.000'
                                , '1.000.000'
                                , '500.000'
                                , '250.000'
                                , '100.000'
                                , ''
                                , '500.000'
                            );
                        else
                            $giaithuong = array(
                                '1.500.000.000'
                                , '40.000.000'
                                , '10.000.000'
                                , '5.000.000'
                                , '2.500.000'
                                , '1.000.000'
                                , '500.000'
                                , '250.000'
                                , '100.000'
                                , '100.000.000'
                                , '7.000.000'
                            );
                        break;
                    case 'MN':
                        $l_area = 'Miền Nam';
                        $class = ' kqmiennam';
                        $url = $url_miennam;
                        $giaithuong = array(
                            '1.500.000.000'
                            , '30.000.000'
                            , '20.000.000'
                            , '10.000.000'
                            , '3.000.000'
                            , '1.000.000'
                            , '400.000'
                            , '200.000'
                            , '100.000'
                            , '100.000.000'
                            , '6.000.000'
                        );
                        break;
                }
                if ($result == -1) {
                    ?>
                    <p><strong>Rất tiếc vé của bạn không trúng giải!</strong></p>
                    <p>Chúc bạn may mắn lần sau! :)</p>
                <?php } elseif ($result == 999) { ?>
                    <p>Xổ Số <?php echo $lname ?> ngày <strong><?php echo $fromdate ?></strong> không phát hành loại vé <strong><?php echo strlen($so) ?></strong> chữ số, vui lòng nhập đúng thông tin truy vấn!</p>
                    <?php
                } else {
                    $giai = '';
                    $trigia = $giaithuong[$result];
                    switch ($result) {
                        case 0:
                            $giai = 'đặc biệt';
                            break;
                        case 1:
                            $giai = 'nhất';
                            break;
                        case 2:
                            $giai = 'nhì';
                            break;
                        case 3:
                            $giai = 'ba';
                            break;
                        case 4:
                            $giai = 'tư';
                            break;
                        case 5:
                            $giai = 'năm';
                            break;
                        case 6:
                            $giai = 'sáu';
                            break;
                        case 7:
                            $giai = 'bảy';
                            break;
                        case 8:
                            $giai = 'tám';
                            if ($items->area == 'MB')
                                $giai = 'khuyến khích';
                            break;
                        case 9:
                            $giai = 'Đặt Biệt Phụ';
                            break;
                        case 10:
                            $giai = 'khuyến khích';
                            break;
                    }
                    ?>
                    <p>
                        <strong>Chúc mừng bạn!</strong> <br  />
                        Vé số của bạn đã trúng giải <?php echo $giai ?>!<br />
                        Tổng giá trị giải thưởng là <strong><?php echo $trigia ?>đ</strong>
                    </p>
                <?php } ?>
            <?php } else { ?>
                <p>Kết quả xổ số <?php echo $lname ?> mở thưởng ngày <strong><?php echo $fromdate ?></strong> hiện chưa có trên hệ thống.</p>
            <?php } ?>
        </div>
    </div>
</div>