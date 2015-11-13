<?php
if ($sos != '') {
    $arr_so = explode(',', $sos);
    $fromdate = date('d/m/Y', strtotime($fromdate));
    ?>
    <br/>
    <div class="tit-xs clearfix"><strong class="title-xs">Kết quả dò vé số xổ số <?php echo $lname ?>, ngày <?php echo $fromdate ?></strong></div>
    <div class="block_content">
        <div class="t-cen block_content_head">
            <p>Bạn đã truy vấn dò kết quả vé số <strong>Xổ Số <?php echo $lname ?></strong></p>
        </div>
        <?php
        foreach ($arr_so as $so) {
            $tmp = explode(':', $so);
            $so = trim($tmp[0]);
            ?>
            <div class="line-red">&nbsp;</div>
            <div class="t-cen box-dvs">
                <p>Loại vé <strong><?php echo strlen($so) ?> chữ số</strong>, mở thưởng ngày <strong><?php echo $fromdate ?></strong></p>
                <p>Dãy số của bạn là: <strong class="red"><?php echo $so ?></strong></p>									
            </div>
            <?php
            if ($items) {
                $class = '';
                $giaithuong = array(
                    200000000
                    , 20000000
                    , 5000000
                    , 2000000
                    , 400000
                    , 200000
                    , 100000
                    , 40000
                    , 40000
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
                                250000000
                                , 40000000
                                , 10000000
                                , 5000000
                                , 2500000
                                , 1000000
                                , 500000
                                , 250000
                                , 100000
                                , 0
                                , 500000
                            );
                        else
                            $giaithuong = array(
                                1500000000
                                , 40000000
                                , 10000000
                                , 5000000
                                , 2500000
                                , 1000000
                                , 500000
                                , 250000
                                , 100000
                                , 100000000
                                , 7000000
                            );
                        break;
                    case 'MN':
                        $l_area = 'Miền Nam';
                        $class = ' kqmiennam';
                        $url = $url_miennam;
                        $giaithuong = array(
                            1500000000
                            , 30000000
                            , 20000000
                            , 10000000
                            , 3000000
                            , 1000000
                            , 400000
                            , 200000
                            , 100000
                            , 100000000
                            , 6000000
                        );
                        break;
                }

                if ($result[$so] === '' || $result[$so] === NULL) {
                    ?>
                    <div class="t-cen box-dvs">
                        <div class="imgs"><img src="<?php echo img_link('sime.png'); ?>" width="121" height="95" alt="" /></div>
                        <div class="gray-text">
                            <p><strong>Rất tiếc vé của bạn không trúng giải!</strong></p>
                            <p>Chúc bạn may mắn lần sau! :)</p>
                        </div>
                    </div>
                <?php } elseif ($result[$so] == 999) { ?>
                    <div class="t-cen box-dvs">
                        <p>Xổ Số <?php echo $lname ?> ngày <strong><?php echo $fromdate ?></strong> không phát hành loại vé <strong><?php echo strlen($so) ?></strong> chữ số, vui lòng nhập đúng thông tin truy vấn!</p>
                    </div>
                    <?php
                } else {
                    $giai = array();
                    $trigia = 0;
                    $arr_result = explode(',', $result[$so]);
                    foreach ($arr_result as $rs) {
                        if ($rs === '')
                            continue;

                        $trigia = $trigia + $giaithuong[$rs];
                        $trigia = $trigia * $soluong[$so];
                        switch ($rs) {
                            case 0:
                                $giai[] = 'giải Đặc Biệt';
                                break;
                            case 1:
                                $giai[] = 'giải Nhất';
                                break;
                            case 2:
                                $giai[] = 'giải Nhì';
                                break;
                            case 3:
                                $giai[] = 'giải Ba';
                                break;
                            case 4:
                                $giai[] = 'giải Tư';
                                break;
                            case 5:
                                $giai[] = 'giải Năm';
                                break;
                            case 6:
                                $giai[] = 'giải Sáu';
                                break;
                            case 7:
                                $giai[] = 'giải Bảy';
                                break;
                            case 8:
                                $giai[] = 'giải Tám';
                                if ($items->area == 'MB')
                                    $giai[] = 'giải Khuyến Khích';
                                break;
                            case 9:
                                $giai[] = 'giải Đặt Biệt Phụ';
                                break;
                            case 10:
                                $giai[] = 'giải Khuyến Khích';
                                break;
                        }
                    }
                    ?>
                    <div class="t-cen box-dvs">
                        <div class="imgs"><img src="<?php echo img_link('sime1.png'); ?>" width="120" height="115" alt="" /></div>
                        <div class="gray-text">
                            <p>
                                <strong>Chúc mừng bạn!</strong> <br  />
                                <?php echo $soluong[$so] == 1 ? '' : '<strong>' . $soluong[$so] . '</strong> ' ?>Vé số của bạn đã trúng <strong><?php echo implode(' & ', $giai); ?>!</strong><br />
                                Tổng giá trị giải thưởng là <strong class="red"><?php echo number_format($trigia, 0, '.', ',') ?> đ</strong>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="t-cen box-dvs">
                    <p>Kết quả xổ số <?php echo $lname ?> mở thưởng ngày <?php echo $fromdate ?> hiện chưa có trên hệ thống.</p>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="mb10 clearfix"></div>
    <?php
    if ($items) {
        ?>
        <div class="tit-xs clearfix">
            <strong class="title-xs">KẾT QUẢ XỔ SỐ <?php echo mb_strtoupper($l_area, 'UTF-8') ?></strong>
        </div>
        <div class="block_content">
            <div class="box-result">
                <table class="tbl-xs<?php echo $class ?>">
                    <tr>
                        <td class="t-left border-right" colspan="2">
                            <strong>Xổ Số <?php echo $lname ?> - <?php echo $items->dateOfWeek ?> ngày <?php echo $items->date ?></strong>
                        </td>
                        <td class="t-right">Giải thưởng(đ)</td>
                    </tr>
                    <tr>
                        <td class="bg-gray border-right" width="1%" nowrap>Giải đặc biệt</td>
                        <td class="bg-gray border-right giaidb">
                            <?php
                            echo '<strong class="red font18 span-space">' . ($items->a0 == '' ? "*****" : $items->a0) . '</strong>';
                            ?>
                        </td>
                        <td class="bg-gray t-right"><strong><?php echo number_format($giaithuong[0], 0, '.', ',') ?></strong></td>
                    </tr>
                    <tr>
                        <td class="border-right">Giải nhất</td>
                        <td class="border-right giai1">
                            <?php
                            echo '<strong class="span-space">' . ($items->a1 == '' ? "*****" : $items->a1) . '</strong>';
                            ?>
                        </td>
                        <td class="t-right"><?php echo number_format($giaithuong[1], 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td class="bg-gray border-right">Giải nhì</td>
                        <td class="bg-gray border-right giai2">
                            <?php
                            echo str_replace('-', ' - ', $items->a2);
                            ?>
                        </td>
                        <td class="t-right bg-gray"><?php echo number_format($giaithuong[2], 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td class="border-right">Giải ba</td>
                        <td class="border-right giai3">
                            <?php
                            echo str_replace('-', ' - ', $items->a3);
                            ?>
                        </td>
                        <td class="t-right"><?php echo number_format($giaithuong[3], 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td class="bg-gray border-right">Giải tư</td>
                        <td class="bg-gray border-right giai4">
                            <?php
                            echo str_replace('-', ' - ', $items->a4);
                            ?>
                        </td>
                        <td class="t-right bg-gray "><?php echo number_format($giaithuong[4], 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td class="border-right">Giải năm</td>
                        <td class="border-right giai5">
                            <?php
                            echo str_replace('-', ' - ', $items->a5);
                            ?>
                        </td>
                        <td class="t-right"><?php echo number_format($giaithuong[5], 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td class="bg-gray border-right">Giải sáu</td>
                        <td class="bg-gray border-right giai6">
                            <?php
                            echo str_replace('-', ' - ', $items->a6);
                            ?>
                        </td>
                        <td class="t-right bg-gray"><?php echo number_format($giaithuong[6], 0, '.', ',') ?></td>
                    </tr>
                    <tr>
                        <td class="border-right">Giải bảy</td>
                        <td class="border-right giai7">
                            <?php
                            echo str_replace('-', ' - ', $items->a7);
                            ?>
                        </td>
                        <td class="t-right"><?php echo number_format($giaithuong[7], 0, '.', ',') ?></td>
                    </tr>
                    <?php
                    if ($items->area != 'MB') {
                        if (strlen($items->a0) == 5) {
                            ?>
                            <tr>
                                <td class="bg-gray border-right">Giải tám</td>
                                <td class="bg-gray border-right giai8">
                                    <?php echo $items->a8 ?>
                                </td>
                                <td class="bg-gray t-right"><?php echo number_format($giaithuong[8], 0, '.', ',') ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-right border_radius_btl">Giải khuyến khích (vé có 2 số cuối trùng với 2 số cuối của giải Đặc Biệt - <strong class="red"><?php echo substr($items->a0, 3, 2) ?></strong>)</td>
                                <td class="t-right border_radius_btr"><?php echo number_format($giaithuong[10], 0, '.', ',') ?></td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td class="bg-gray border-right">Giải tám</td>
                                <td class="bg-gray border-right giai8">
                                    <?php echo $items->a8 ?>
                                </td>
                                <td class="bg-gray t-right"><?php echo number_format($giaithuong[8], 0, '.', ',') ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-right">Giải Đặt Biệt Phụ (sai chữ số đầu, trúng 5 chữ số cuối so với giải Đặc Biệt)</td>
                                <td class="t-right"><?php echo number_format($giaithuong[9], 0, '.', ',') ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="bg-gray border-right border_radius_btl">Giải Khuyến Khích (trúng chữ số đầu tiên và sai 1 trong 5 chữ số còn lại)</td>
                                <td class="bg-gray t-right border_radius_btr"><?php echo number_format($giaithuong[10], 0, '.', ',') ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="2" class="bg-gray border-right border_radius_btl">Giải khuyến khích (vé có 2 số cuối trùng với 2 số cuối của giải Đặc Biệt - <strong class="red"><?php echo substr($items->a0, 3, 2) ?></strong>)</td>
                            <td class="bg-gray t-right border_radius_btr"><?php echo number_format($giaithuong[8], 0, '.', ',') ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <?php
    }
}
?>