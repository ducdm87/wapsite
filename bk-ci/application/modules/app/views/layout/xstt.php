<?php
//$timer = '10:53:00';
$time = date('H:i');
$timer = date('H:i', strtotime($timer));

if (!$data) {
    echo 1;
    die();
}

$days = array(
    '0' => 'Chủ nhật',
    '1' => 'Thứ 2',
    '2' => 'Thứ 3',
    '3' => 'Thứ 4',
    '4' => 'Thứ 5',
    '5' => 'Thứ 6',
    '6' => 'Thứ 7'
);

switch ($area) {
    case 'MB':
        $l_area = 'Truyền thống';
        $time_end = '18:00';
        break;
    case 'MT':
        $l_area = 'Miền Trung';
        $time_end = '17:00';
        break;
    case 'MN':
        $l_area = 'Miền Nam';
        $time_end = '16:00';
        break;
}

if ($time >= $time_end && $time < $timer) {
    echo 1;
    die();
}

if ($time < $time_end) {
    $date = date('d/m/Y', strtotime('-1 day'));
    $date_ve_do = date('d-m-Y', strtotime('-1 day'));
    $datew = date('w', strtotime('-1 day'));
} else {
    $date = date('d/m/Y');
    $date_ve_do = date('d-m-Y');
    $datew = date('w');
}

//$cols = $total_location;
$cols = count(get_object_vars($data));
$check = true;

$arr_search = array('++++', '+++', '++', '+');
$arr_replace = array('<img src="' . img_link('count_1.gif') . '" width="13" alt="" height="13" /><img src="' . img_link('count_2.gif') . '" width="13" alt="" height="13" /><img src="' . img_link('count_3.gif') . '" width="13" alt="" height="13" /><img src="' . img_link('count_4.gif') . '" width="13" alt="" height="13" />', '<img src="' . img_link('count_1.gif') . '" width="13" alt="" height="13" /><img src="' . img_link('count_2.gif') . '" width="13" alt="" height="13" /><img src="' . img_link('count_3.gif') . '" width="13" alt="" height="13" />', '<img src="' . img_link('count_1.gif') . '" width="13" alt="" height="13" /><img src="' . img_link('count_2.gif') . '" width="13" alt="" height="13" />', '<img src="' . img_link('count_1.gif') . '" width="13" alt="" height="13" />');

if ($area == 'MB') {
    $v = $data->MB;
    if ($v->status == 0)
        $check = false;

    $title_share = 'Xổ Số ' . $v->name . ' - ' . ($days[$datew]) . ' ngày ' . $date;

    $alias_date = $v->alias . '/' . $date_ve_do;
    $curPageURL = urlencode($uri_root . $alias_date . '.html');
    ?>
    <div class="tit-xs clearfix">
        <strong class="title-xs">TRỰC TIẾP XỔ SỐ <?php echo mb_strtoupper($l_area, 'UTF-8') ?></strong>
    </div>
    <div class="block_content">
        <div class="page-title" style="background:#fff">
            <strong class="txt-red"><h2>Xổ Số <?php echo $v->name; ?> - <?php echo($days[$datew]); ?> ngày <?php echo $date; ?></h2></strong>
        </div>
        <table class="tbl-xs">
            <tr>
                <td class="bg-gray border-right">Giải đặc biệt</td>
                <td class="bg-gray giaidb">
                    <?php
                    $str = str_replace('*****', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $v->data[0]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="red font18 span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="border-right">Giải nhất</td>
                <td class="giai1 font70014">
                    <?php
                    $str = str_replace('*****', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $v->data[1]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="bg-gray border-right">Giải nhì</td>
                <td class="bg-gray giai2 font70014">
                    <?php
                    $str = str_replace(array('-', '*****'), array('</strong><strong class="span-space">', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $v->data[2]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="border-right">Giải ba</td>
                <td class="giai3 font70014">
                    <?php
                    $str = str_replace(array('-', '*****'), array('</strong><strong class="span-space">', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $v->data[3]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="bg-gray border-right">Giải tư</td>
                <td class="bg-gray giai4 font70014">
                    <?php
                    $str = str_replace(array('-', '****'), array('</strong><strong class="span-space">', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $v->data[4]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="border-right">Giải năm</td>
                <td class="giai5 font70014">
                    <?php
                    $str = str_replace(array('-', '****'), array('</strong><strong class="span-space">', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $v->data[5]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="bg-gray border-right">Giải sáu</td>
                <td class="bg-gray giai6 font70014">
                    <?php
                    $str = str_replace(array('-', '***'), array('</strong><strong class="span-space">', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $v->data[6]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
            <tr>
                <td class="border-right">Giải bảy</td>
                <td class="giai7 font70014">
                    <?php
                    $str = str_replace(array('-', '**'), array('</strong><strong class="span-space">', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $v->data[7]);
                    $str = str_replace($arr_search, $arr_replace, $str);
                    echo '<strong class="span-space">' . $str . '</strong>';
                    ?>
                </td>
            </tr>
        </table>
        <table class="tbl-xs">
            <tr>
                <th class="border-right">Đầu</th>
                <th class="border-right">Đuôi</th>
                <th class="border-right">Đầu</th>
                <th>Đuôi</th>
            </tr>
            <tr>
                <td class="bg-gray first"><strong>0</strong></td>
                <td class="bg-gray border-right"><?php echo $v->extra[0] ?></td>
                <td class="bg-gray border-right"><strong>5</strong></td>
                <td class="bg-gray"><?php echo $v->extra[5] ?></td>
            </tr>
            <tr>
                <td class="first"><strong>1</strong></td>
                <td class="border-right"><?php echo $v->extra[1] ?></td>
                <td class="border-right"><strong>6</strong></td>
                <td><?php echo $v->extra[6] ?></td>
            </tr>
            <tr>
                <td class="bg-gray first"><strong>2</strong></td>
                <td class="bg-gray border-right"><?php echo $v->extra[2] ?></td>
                <td class="bg-gray border-right"><strong>7</strong></td>
                <td class="bg-gray"><?php echo $v->extra[7] ?></td>
            </tr>
            <tr>
                <td class="first"><strong>3</strong></td>
                <td class="border-right"><?php echo $v->extra[3] ?></td>
                <td class="border-right"><strong>8</strong></td>
                <td><?php echo $v->extra[8] ?></td>
            </tr>
            <tr>
                <td class="bg-gray first border_radius_btl"><strong>4</strong></td>
                <td class="bg-gray border-right"><?php echo $v->extra[4] ?></td>
                <td class="bg-gray border-right"><strong>9</strong></td>
                <td class="bg-gray border_radius_btr"><?php echo $v->extra[9] ?></td>
            </tr>
        </table>
    </div>
    <div class="mb10 clearfix"></div>
    <div class="tit-xs clearfix">
        <strong class="title-xs">Loto trực tiếp <?php echo ($v->name == '' ? 'Miền Bắc' : $v->name); ?></strong>
    </div>
    <div class="block_content">
        <table class="tbl-xs">
            <?php
            $str = '';
            $l1 = 8;
            $l2 = 17;
            $l3 = 26;
            foreach($v->data_b as $k1=>$v1){
                if($v1!=''){
                    if($k1==0)
                        $str.=$v1;
                    else
                        $str.=','.$v1;
                }
            }
            $arr = explode(',', $str);
            sort($arr);
            ?>
            <tr>
                <?php for ($i = 0; $i <= $l1; $i++): ?>
                    <td class="<?php echo($i == $l1 ? 'last' : 'border-right'); ?>"><strong><?php echo $arr[$i] ?></strong></td>
                <?php endfor; ?>							
            </tr>
            <tr>
                <?php for ($i = ($l1 + 1); $i <= $l2; $i++): ?>
                    <td class="<?php echo($i == $l2 ? 'last' : 'border-right'); ?>"><strong><?php echo $arr[$i] ?></strong></td>
                <?php endfor; ?>							
            </tr>
            <tr>
                <?php
                for ($i = ($l2 + 1); $i <= $l3; $i++):
                    $class = '';
                    if ($i == ($l2 + 1))
                        $class = ' border_radius_btl';
                    ?>
                    <td class="<?php echo($i == $l3 ? 'last border_radius_btr' : 'border-right' . $class); ?>"><strong><?php echo $arr[$i] ?></strong></td>
                <?php endfor; ?>							
            </tr>
        </table>
    </div>
    <?php
}else {
    $title = '';
    $title_loto = '';
    $i = 0;
    $g8 = '';
    $g7 = '';
    $g6 = '';
    $g5 = '';
    $g4 = '';
    $g3 = '';
    $g2 = '';
    $g1 = '';
    $g0 = '';
    $code = '';
    $extra = array();
    $loto_arr = array();
    $sms = '';

    $column = count(get_object_vars($data));
    foreach ($data as $value) {
        if ($value->status == 0)
            $check = false;

        $i++;
        $class = '';
        $class_loto = '';

        if ($i != $column) {
            $class = 'border-right ';
            $class_loto = ' border-right';
        } else {
            $class.=' border_radius_btr ';
        }

        $title .= '<td class="' . $class . 't-cen"><strong>' . $value->name . '</strong></td>';

        $title_loto .= '<th class="bg-yelow1 t-cen' . $class_loto . '" colspan="3"><span>' . $value->name . '</span></th>';

        $str = str_replace('**', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $value->data[8]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g8 .='<td class="' . $class . 't-cen font70014"><strong class="red">' . $str . '</strong></td>';

        $str = str_replace('***', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $value->data[7]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g7 .='<td class="' . $class . 'bg-gray t-cen font70014">' . $str . '</td>';

        $str = str_replace(array('-', '****'), array('</div><div>', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $value->data[6]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g6 .='<td class="' . $class . 't-cen font70014"><div>' . $str . '</div></td>';

        $str = str_replace('****', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $value->data[5]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g5 .='<td class="' . $class . 'bg-gray t-cen font70014">' . $str . '</td>';

        $str = str_replace(array('-', '*****'), array('</div><div>', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $value->data[4]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g4 .='<td class="' . $class . 't-cen font70014"><div>' . $str . '</div></td>';

        $str = str_replace(array('-', '*****'), array('</div><div>', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />'), $value->data[3]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g3 .='<td class="' . $class . 'bg-gray t-cen font70014"><div>' . $str . '</div></td>';

        $str = str_replace('*****', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $value->data[2]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g2 .='<td class="' . $class . 't-cen font70014">' . $str . '</td>';

        $str = str_replace('*****', '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $value->data[1]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g1 .='<td class="' . $class . 'bg-gray t-cen font70014">' . $str . '</td>';

        $str = str_replace(str_repeat('*', strlen($value->data[0])), '<img src="' . img_link('icon-xs/loading.gif') . '" width="40" alt="" height="10" />', $value->data[0]);
        $str = str_replace($arr_search, $arr_replace, $str);
        $g0 .='<td class="' . $class . 't-cen font70014"><strong class="red">' . $str . '</strong></td>';

        $code .='<td class="' . $class . 'bg-gray t-cen">' . $value->code . '</td>';

        for ($j = 0; $j <= 9; $j++)
            $extra[$i][$j] = $value->extra[$j];


        $str='';
        foreach($value->data_b as $k1=>$v1){
            if($v1!=''){
                if($k1==0)
                    $str.=$v1;
                else
                    $str.=','.$v1;
            }
        }
        $loto_arr[$i] = explode(',', $str);
        sort($loto_arr[$i]);

        $sms .= '<li>Để nhận kết quả xổ số <strong>' . $value->name . '</strong> sớm nhất, soạn tin <span>KQ ' . $value->code . '</span> gửi <span>8017</span></li>';
    }

    $title_share = 'Xổ Số ' . $l_area . ' - ' . ($days[$datew]) . ' ngày ' . $date;

    if ($area == 'MT')
        $alias_date = $url_mientrung . '/' . $date_ve_do;
    else
        $alias_date = $url_miennam . '/' . $date_ve_do;
    $curPageURL = urlencode($uri_root . $alias_date . '.html');
    ?>
    <div class="tit-xs clearfix">
        <strong class="title-xs">TRỰC TIẾP XỔ SỐ <?php echo mb_strtoupper($l_area, 'UTF-8') ?></strong>
    </div>
    <div class="block_content">
        <div class="page-title">
            <strong class="txt-red"><h2>Xổ số <?php echo $l_area ?> ngày <?php echo($days[$datew]); ?> - <?php echo $date; ?></h2></strong>
        </div>
        <table class="tbl-xs">
            <tr>
                <td class="border-right t-cen"><strong><?php echo($days[$datew]); ?></strong></td>
                <?php echo $title ?>
            </tr>
            <tr>
                <td class="border-righ bg-gray t-cen border-right"><?php echo $date; ?></td>
                <?php echo $code ?>
            </tr>
            <tr>
                <td class="border-right t-cen">Giải tám</td>
                <?php echo $g8 ?>
            </tr>
            <tr>
                <td class="border-right bg-gray t-cen">Giải bảy</td>
                <?php echo $g7 ?>
            </tr>
            <tr>
                <td class="border-right t-cen">Giải sáu</td>
                <?php echo $g6 ?>
            </tr>
            <tr>
                <td class="border-right bg-gray t-cen">Giải năm</td>
                <?php echo $g5 ?>
            </tr>
            <tr>
                <td class="border-right t-cen">Giải tư</td>
                <?php echo $g4 ?>
            </tr>
            <tr>
                <td class="border-right bg-gray t-cen">Giải ba</td>
                <?php echo $g3 ?>
            </tr>
            <tr>
                <td class="border-right t-cen">Giải nhì</td>
                <?php echo $g2 ?>
            </tr>
            <tr>
                <td class="border-right bg-gray t-cen">Giải nhất</td>
                <?php echo $g1 ?>
            </tr>
            <tr>
                <td class="border-right t-cen border_radius_btl">Giải đặc biệt</td>
                <?php echo $g0 ?>
            </tr>
        </table>
    </div>
    <div class="mb10 clearfix"></div>
    <div class="tit-xs clearfix">
        <strong class="title-xs">BẢNG LOTO TRỰC TIẾP XỔ SỐ <?php echo mb_strtoupper($l_area, 'UTF-8') ?> - <?php echo $date; ?></strong>
    </div>
    <div class="block_content">
        <table class="tbl-xs">
            <tr>
                <?php echo $title_loto ?>
            </tr>
            <tr>
                <?php
                $loto_title = '';
                for ($i = 0; $i < $column; $i++) {
                    $class = '';
                    if ($i != $column - 1)
                        $class = ' border-right';
                    $loto_title .= '<th class="t-cen' . $class . ' bg-red-line" colspan="3"><strong>Loto trực tiếp</strong></th>';
                    ?>
                    <td class="bg-gray t-cen border-right" width="18"><strong>Số</strong></td>
                    <td class="t-cen<?php echo $class ?>" colspan="2">Đơn vị</td>
                <?php } ?>
            </tr>
            <?php for ($i = 0; $i < 10; $i++) { ?>
                <tr>
                    <?php
                    for ($j = 1; $j <= $column; $j++) {
                        $class = '';
                        if ($j != $column)
                            $class = ' border-right';
                        ?>
                        <td class="bg-gray t-cen border-right" width="18"><strong><strong class="red"><?php echo $i ?></strong></strong></td>
                        <td class="t-cen<?php echo $class ?>" colspan="2"><?php echo $extra[$j][$i] ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <tr>
                <?php echo $loto_title ?>
            </tr>
            <tr>
                <?php
                for ($i = 1; $i <= $column; $i++) {
                    $border_right = '';
                    if ($i != $column)
                        $border_right = 'border-right:1px solid #E1E1E1';
                    ?>
                    <td colspan="3" style="padding:0;border-top:0;<?php echo $border_right ?>">
                        <table class="tbl-xs">
                            <?php
                            foreach ($loto_arr[$i] as $k => $value) {
                                $class = '';
                                if (($k + 1) % 3 == 1)
                                    echo '<tr>';
                                if (($k + 1) % 3 != 0)
                                    $class = ' border-right';
                                echo '<td class="t-cen' . $class . '" width="18"><strong>' . $value . '</strong></td>';
                                if (($k + 1) % 3 == 0)
                                    echo '</tr>';
                            }
                            ?>
                        </table>
                    </td>
    <?php } ?>
            </tr>
        </table>
    </div>
<?php } ?>
<?php if ($check) { ?>
    <script type="text/javascript">
        clearInterval(timerCheck);
    </script>
<?php } ?>