<?php
$lname = '';
$statistics_alias = '';
$cur_year = date('Y');
$min_year = $cur_year - 10;
$yearList = array();
for ($i = $min_year; $i <= $cur_year; $i++) {
    $tmp = sprintf('%02d', $i);
    $yearList[] = $tmp;
}
?>
<div class="title title-red">
    <div class="title-right">
        <ul class="tabs clearfix">
            <li<?php echo $type == 0 ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>thong-ke-giai-dac-biet-theo-thang.html">Thống kê giải đặc biệt theo tháng</a></li>
            <li<?php echo $type > 0 ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>thong-ke-cap-so-cuoi-giai-dac-biet-theo-thang.html">Thống kê cặp số cuối giải đặc biệt theo tháng</a></li>
        </ul>
    </div>
</div>
<div class="box-yellow select-provice clearfix">
    <form id="form_search" method="post" action="">
        <div class="left">
            <select name="lid" id="select_mien" tabindex="1">
                <?php
                foreach ($xs_location_menu as $value) {
                    $selected = '';
                    if ($lid == $value->id) {
                        $selected = ' selected=""';
                        $lname = $value->name;
                        $statistics_alias = $value->alias;
                    }
                    echo '<option' . $selected . ' value="' . $value->alias . '">' . $value->name . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="box-fromto left">
            <label class="label-title">Từ</label>
            <select name="fy" id="select_year" tabindex="1">
                <?php
                foreach ($yearList as $value) {
                    $selected = '';
                    if ($fy == $value) {
                        $selected = ' selected=""';
                    }
                    echo '<option' . $selected . ' value="' . $value . '">' . $value . '</option>';
                }
                ?>
            </select>
            <label class="label-title">đến năm</label>
            <select name="ty" id="select_year1" tabindex="1">
                <?php
                foreach ($yearList as $value) {
                    $selected = '';
                    if ($ty == $value) {
                        $selected = ' selected=""';
                    }
                    echo '<option' . $selected . ' value="' . $value . '">' . $value . '</option>';
                }
                ?>
            </select>
            <a class="read-more" href="javascript:;" onclick="doSubmit('<?php echo $type == 0 ? 'thong-ke-giai-dac-biet-theo-thang' : 'thong-ke-cap-so-cuoi-giai-dac-biet-theo-thang' ?>');"><span>Xem</span></a>
        </div>
    </form>
</div>
<h1><?php echo $type == 0 ? 'Thống kê giải đặc biệt theo tháng' : 'Thống kê cặp số cuối giải đặc biệt theo tháng' ?> Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
<?php if ($fy <= $ty): ?>
    <?php for ($y = $fy; $y <= $ty; $y++): ?>
        <div class="title-tk">Thống kê của năm: <?php echo $y ?></div>
        <div class="box-result statistics-month">
            <table class="tbl-ds">
                <tr>
                    <td class="t-cen">Ngày</td>
                    <td class="t-cen">Tháng 1</td>
                    <td class="t-cen">Tháng 2</td>
                    <td class="t-cen">Tháng 3</td>
                    <td class="t-cen">Tháng 4</td>
                    <td class="t-cen">Tháng 5</td>
                    <td class="t-cen">Tháng 6</td>
                    <td class="t-cen">Tháng 7</td>
                    <td class="t-cen">Tháng 8</td>
                    <td class="t-cen">Tháng 9</td>
                    <td class="t-cen">Tháng 10</td>
                    <td class="t-cen">Tháng 11</td>
                    <td class="t-cen last">Tháng 12</td>
                </tr>
                <?php for ($d = 1; $d <= 31; $d++): ?>
                    <tr>
                        <td class="t-cen"><strong><?php echo $d; ?></strong></td>
                        <?php
                        for ($m = 1; $m <= 12; $m++) {
                            $_m = (strlen($m) == 1 ? '0' . $m : $m);
                            $_d = (strlen($d) == 1 ? '0' . $d : $d);
                            $date = $y . '-' . $_m . '-' . $_d;

                            $class = 't-cen';
                            if ($m == 12) {
                                $class .= ' last';
                            }
                            if (($d == 1 || $d == 2 || $d == 3) && ($m == 1)) {
                                $class .= ' bg-red';
                            } elseif ((date('N', strtotime($date)) == 7)) {
                                $class .= ' bg-yelow';
                            }

                            if ($y % 4 == 0) {
                                if ($m == 2 && $d > 29)
                                    $title = "";
                                else
                                    $title = "Ngày: " . $_d . "/" . $_m . "/" . $y;
                            }else {
                                if ($m == 2 && $d > 28)
                                    $title = "";
                                else
                                    $title = "Ngày: " . $_d . "/" . $_m . "/" . $y;
                            }
                            if ($m == 4 || $m == 6 || $m == 9 || $m == 11) {
                                if ($d == 31)
                                    $title = "";
                            }
                            ?>
                            <td class="<?php echo $class; ?>" title="<?php echo $title; ?>">
                                <?php
                                $have = false;
                                $val = '';
                                foreach ($items as $k => $v) {
                                    if ($v->date == $date) {
                                        $val = $v->data;
                                        $have = true;
                                        break;
                                    } else {
                                        continue;
                                    }
                                }
                                if ($have) {
                                    if ($type <> 1) {
                                        echo $val;
                                    } else {
                                        echo substr($val, 3, 2);
                                    }
                                } else {
                                    echo '&nbsp;';
                                }
                                ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    <?php endfor; //End loop year?>
    <div class="line-red mb10">&nbsp;</div>
    <div class="box-note t-cen">
        <span><span class="span-colorred"></span>Ngày Tết</span>
        <span><span class="span-coloryelow"></span>Chủ nhật</span>
        <span><span class="span-colorgray"></span>Ngày thường</span>
    </div>
<?php endif; //End Chon nam hop le ?>
<br/>
<div class="msg-block">
    <div>Tính năng này giúp bạn thống kê được trong khoảng thời gian, tỉnh thành bạn lựa chọn theo tháng:</div>
    <br/>
    <ul>
        <li>&Gt; Các giải đặc biệt trong khoảng thời gian được hiển thị theo các ngày trong tháng</li>
        <li>&Gt; Thống kê 2 số</li>
        <li>&Gt; Thống kê đầu số</li>
        <li>&Gt; Thống kê đuôi số</li>
        <li>&Gt; Thống kê tổng của 2 số cuối giải đặc biệt</li>
    </ul>
</div>
<br/>
<?php
$this->load->view($layout_sms);
$statistics_content = str_replace('[TINH]', '<a href="' . $statistics_alias . '.html">' . $lname . '</a>', $statistics_content);
echo '<br/><div class="msg-block">' . $statistics_content . '</div>';
?>
<script type="text/javascript">
    $(function(){$("#select_mien").selectbox();$("#select_year").selectbox();$("#select_year1").selectbox()});
</script>