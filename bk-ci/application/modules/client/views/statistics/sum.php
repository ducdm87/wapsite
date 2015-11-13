<?php
$lname = '';
$statistics_alias = '';
$msg = 'Thống kê tổng hai số cuối tổng từ 0 đến 9, giúp người chơi có những con số cụ thể về một cặp loto hoặc số đề (2 số cuối giải đặc biệt) của tỉnh thành mở thưởng trong khoảng thời gian mà bạn muốn xem, cặp số xuất hiện nhiều nhất,  ngày về gần nhất. Chúc bạn may mắn.';
?>
<div class="title title-red">
    <div class="title-right">Thống kê theo tổng 2 số cuối</div>
</div>
<div class="box-result">
    <form id="form_search" method="post" action="">
        <div class="select-provice clearfix">
            <?php
//            if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0)){
//            echo '<div class="alert_vip">Bạn chỉ xem được tối đa số lần quay là 30 lần<br/>';
//            $this->load->view('layout/vip');
//            echo '</div>';
//            }
            ?>
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
            <a class="read-more" href="javascript:;" onclick="doSubmit('thong-ke-theo-tong-0-9');"><span>Xem kết quả</span></a>
        </div>
        <div class="title-tk">
            <span class="left">Thống kê theo tổng 2 số cuối <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></span>
            <div class="right">
                <label>Chọn</label>
                <select name="type" id="select_ratenum" tabindex="1">
                    <option <?php echo($type == 't1' ? 'selected="selected"' : ''); ?> value="t1">Thống kê tổng 0</option>
                    <option <?php echo($type == 't2' ? 'selected="selected"' : ''); ?> value="t2">Thống kê tổng 1</option>
                    <option <?php echo($type == 't3' ? 'selected="selected"' : ''); ?> value="t3">Thống kê tổng 2</option>
                    <option <?php echo($type == 't4' ? 'selected="selected"' : ''); ?> value="t4">Thống kê tổng 3</option>
                    <option <?php echo($type == 't5' ? 'selected="selected"' : ''); ?> value="t5">Thống kê tổng 4</option>
                    <option <?php echo($type == 't6' ? 'selected="selected"' : ''); ?> value="t6">Thống kê tổng 5</option>
                    <option <?php echo($type == 't7' ? 'selected="selected"' : ''); ?> value="t7">Thống kê tổng 6</option>
                    <option <?php echo($type == 't8' ? 'selected="selected"' : ''); ?> value="t8">Thống kê tổng 7</option>
                    <option <?php echo($type == 't9' ? 'selected="selected"' : ''); ?> value="t9">Thống kê tổng 8</option>
                    <option <?php echo($type == 't10' ? 'selected="selected"' : ''); ?> value="t10">Thống kê tổng 9</option>
                </select>
            </div>
        </div>
    </form>
    <h1>Thống kê theo tổng 2 số cuối Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <table class="tbl-tk tbl-num2">
        <tr>
            <th width="70">Cặp số </th>
            <th width="225">Lần xuất hiện</th>
            <th width="225"> Ngày về gần nhất</th>
        </tr>
        <?php
        if ($items) {
            foreach ($items['value'] as $k => $v):
                $phantram = '0.00';
                $phantram_w = 0;
                if ($v['count'] > 0) {
                    $phantram = round(($v['count'] / $items['total']) * 100, 2);
                    $phantram = number_format($phantram, 2, '.', '');

                    $phantram_w = round(($v['count'] / $items['phantram_count']) * 100, 2);
                    $phantram_w = number_format($phantram_w, 2, '.', '');
                }
                ?>
                <tr>
                    <td class="t-cen"><strong><?php echo $v['number']; ?></strong></td>
                    <td>
                        <div class="run"><div class="runing" style="width: <?php echo $phantram_w . '%'; ?>"></div>&nbsp;</div><?php echo $phantram . '% (' . $v['count'] . ')'; ?>
                    </td>
                    <td class="t-cen last"><?php echo ($v['count'] == 0) ? 'Không xuất hiện' : (date('d/m/Y', strtotime($v['date']))); ?></td>
                </tr>
                <?php
            endforeach;
        }
        ?>
    </table>
</div>

<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block"><?php echo $msg?></div>
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
<?php
$this->load->view($layout_sms);
$statistics_content = str_replace('[TINH]', '<a href="' . $statistics_alias . '.html">' . $lname . '</a>', $statistics_content);
echo '<br/><div class="msg-block">' . $statistics_content . '</div>';
?>
<script type="text/javascript">
    $(function(){$("#select_num").selectbox();$("#select_mien").selectbox();$("#select_ratenum").selectbox()});
</script>