<?php
$lname = '';
$statistics_alias = '';
?>
<div class="title title-red">
    <div class="title-right">Thống kê đầu đuôi 0-9</div>
</div>
<div class="box-result">								
    <div class="select-provice clearfix">
        <?php
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0)){
//        echo '<div class="alert_vip">Bạn chỉ xem được tối đa số lần quay là 30 lần<br/>';
//        $this->load->view('layout/vip');
//        echo '</div>';
//        }
        ?>
        <form id="form_search" method="post" action="">
            <div class="left">
                <label>Tỉnh / Thành phố</label>
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
            <div class="left numberbox">
                <label>Lần quay</label>
                <select id="select_num" name="time_turn" tabindex="1">
                    <option value="10"<?php echo $time_turn == 10 ? ' selected="selected"' : '' ?>>10</option>
                    <option value="20"<?php echo $time_turn == 20 ? ' selected="selected"' : '' ?>>20</option>
                    <option value="30"<?php echo $time_turn == 30 ? ' selected="selected"' : '' ?>>30</option>   
                    <?php //if (isset($_SESSION['user']) && $_SESSION['user']['gender'] == 1){?>
                    <option value="50"<?php echo $time_turn == 50 ? ' selected="selected"' : '' ?>>50</option>
                    <option value="100"<?php echo $time_turn == 100 ? ' selected="selected"' : '' ?>>100</option>
                    <option value="365"<?php echo $time_turn == 365 ? ' selected="selected"' : '' ?>>365</option>
                    <?php //}?>
                </select>
            </div>
            <a class="read-more" href="javascript:;" onclick="doSubmit('thongke-dau-duoi-0-9');"><span>Xem kết quả</span></a>
        </form>
    </div>
    <h1>Thống kê đầu đuôi 0-9 Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <?php if ($items): ?>
        <div class="title-tk">Đầu số xuất hiện trong <?php echo $time_turn ?> lần quay Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></div>
        <table class="tbl-tk tbl-tkdd">
            <tr>
                <th width="70">đặc biệt </th>
                <th width="210">Lần xuất hiện</th>
                <th width="33">Loto</th>
                <th width="210" class="last">Lần xuất hiện</th>
            </tr>
            <?php
            foreach ($items['dau'] as $k => $v):
                $phantram = '0.00';
                $phantram_w = 0;
                if ($v > 0) {
                    $phantram = round(($v / $items['total_loto_dau']) * 100, 2);
                    $phantram = number_format($phantram, 2, '.', '');

                    $phantram_w = round(($v / $items['phantram_loto_dau']) * 100, 2);
                    $phantram_w = number_format($phantram_w, 2, '.', '');
                }
                $phantram_dacbiet = '0.00';
                $phantram_db_w = 0;
                if ($items['dau_dacbiet'][$k] > 0) {
                    $phantram_dacbiet = round(($items['dau_dacbiet'][$k] / $items['total_dacbiet_dau']) * 100, 2);
                    $phantram_dacbiet = number_format($phantram_dacbiet, 2, '.', '');

                    $phantram_db_w = round(($items['dau_dacbiet'][$k] / $items['phantram_dacbiet_dau']) * 100, 2);
                    $phantram_db_w = number_format($phantram_db_w, 2, '.', '');
                }
                ?>
                <tr>
                    <td class="t-cen">Đầu <strong><?php echo $k ?></strong></td>
                    <td><div class="run"><div class="runing" style="width: <?php echo $phantram_db_w . '%'; ?>"></div>&nbsp;</div><?php echo $phantram_dacbiet . '% (' . $items['dau_dacbiet'][$k] . ')'; ?></td>
                    <td><strong><?php echo $k ?></strong></td>
                    <td class="last"><div class="run"><div class="runing" style="width: <?php echo $phantram_w . '%'; ?>"></div>&nbsp;</div><?php echo $phantram . '% (' . $v . ')'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="title-tk">Đuôi số xuất hiện trong <?php echo $time_turn ?> lần quay Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></div>
        <table class="tbl-tk tbl-tkdd">
            <tr>
                <th width="70">đặc biệt </th>
                <th width="210">Lần xuất hiện</th>
                <th width="33">Loto</th>
                <th width="210" class="last">Lần xuất hiện</th>
            </tr>
            <?php
            foreach ($items['duoi'] as $k => $v):
                $phantram = '0.00';
                $phantram_w = 0;
                if ($v > 0) {
                    $phantram = round(($v / $items['total_loto_duoi']) * 100, 2);
                    $phantram = number_format($phantram, 2, '.', '');

                    $phantram_w = round(($v / $items['phantram_loto_duoi']) * 100, 2);
                    $phantram_w = number_format($phantram_w, 2, '.', '');
                }
                $phantram_dacbiet = '0.00';
                $phantram_db_w = 0;
                if ($items['duoi_dacbiet'][$k] > 0) {
                    $phantram_dacbiet = round(($items['duoi_dacbiet'][$k] / $items['total_dacbiet_duoi']) * 100, 2);
                    $phantram_dacbiet = number_format($phantram_dacbiet, 2, '.', '');

                    $phantram_db_w = round(($items['duoi_dacbiet'][$k] / $items['phantram_dacbiet_duoi']) * 100, 2);
                    $phantram_db_w = number_format($phantram_db_w, 2, '.', '');
                }
                ?>
                <tr>
                    <td class="t-cen">Đuôi <strong><?php echo $k ?></strong></td>
                    <td><div class="run"><div class="runing" style="width: <?php echo $phantram_db_w . '%'; ?>"></div>&nbsp;</div><?php echo $phantram_dacbiet . '% (' . $items['duoi_dacbiet'][$k] . ')'; ?></td>
                    <td><strong><?php echo $k ?></strong></td>
                    <td class="last"><div class="run"><div class="runing" style="width: <?php echo $phantram_w . '%'; ?>"></div>&nbsp;</div><?php echo $phantram . '% (' . $v . ')'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<div class="line-red">&nbsp;</div>
<br/>
<div class="banner">
    <?php
    $arr_banner_middle = array();
    foreach ($banner as $v) {
        if ($v->position == 'middle' && ($v->page == 'all' || $v->page == $c_module)) {
            $arr_banner_middle[] = '<div><a target="_blank" href="' . $v->url . '" title="' . view_title($v->name) . '"><img src="' . site_url($v->image) . '" width="566" alt="' . view_title($v->name) . '" /></a></div>';
        }
    }
    echo $arr_banner_middle[array_rand($arr_banner_middle)];
    ?>
</div>
<div id='div-gpt-ad-1378288615889-1' style='width:336px' class="mainmenu">
    <script type='text/javascript'>
        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1378288615889-1'); });
    </script>
</div>
<br/>
<?php
$this->load->view($layout_sms);
$statistics_content = str_replace('[TINH]', '<a href="' . $statistics_alias . '.html">' . $lname . '</a>', $statistics_content);
echo '<br/><div class="msg-block">' . $statistics_content . '</div>';
?>
<script type="text/javascript">
    $(function(){$("#select_mien").selectbox();$("#select_num").selectbox()});
</script>