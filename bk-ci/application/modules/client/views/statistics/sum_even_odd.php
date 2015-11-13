<?php
$lname = '';
$statistics_alias = '';
$msg = '';
$url = '';
if ($type == 0) {
    $title = 'Thống kê theo tổng chẵn';
    $msg = 'Thống kê tổng chẵn, giúp người chơi có những con số cụ thể về một cặp loto hoặc số đề (2 số cuối giải đặc biệt) của tỉnh thành mở thưởng trong khoảng thời gian mà bạn muốn xem, cặp số xuất hiện nhiều nhất, số lần chưa về, ngày về gần nhất. Chúc bạn may mắn';
    $url = 'thong-ke-tong-chan';
} else {
    $title = 'Thống kê theo tổng lẻ';
    $msg = 'Thống kê tổng lẻ, giúp bạn có những con số cụ thể về một cặp loto hoặc số đề (2 số cuối giải đặc biệt) của tỉnh thành mở thưởng trong khoảng thời gian mà bạn muốn xem, cặp số xuất hiện nhiều nhất, số lần chưa về, ngày về gần nhất. Chúc bạn may mắn';
    $url = 'thong-ke-tong-le';
}
?>
<div class="title title-red">
    <div class="title-right"><?php echo $title ?></div>
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
            <a class="read-more" href="javascript:;" onclick="doSubmit('<?php echo $url ?>');"><span>Xem kết quả</span></a>
        </form>
    </div>
    <h1><?php echo $title ?> Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <div class="title-tk"><?php echo $title . ' '; ?><a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></div>
    <table class="tbl-tk">
        <tr>
            <th width="70">Cặp số </th>
            <th width="225">Lần xuất hiện</th>
            <th width="225" class="last">Lần không xuất hiện</th>
        </tr>
        <?php
        if ($items) {
            foreach ($items['value'] as $k => $v):
                $phantram = '0.00';
                $phantram_w = 0;
                $phantram_not_count = '0.00';
                $phantram_not_count_w = 0;
                if ($v['count'] > 0) {
                    $phantram = round(($v['count'] / $items['total_count']) * 100, 2);
                    $phantram = number_format($phantram, 2, '.', '');
                    $phantram_not_count = round(($v['not_count'] / $items['total_notcount']) * 100, 2);
                    $phantram_not_count = number_format($phantram_not_count, 2, '.', '');

                    $phantram_w = round(($v['count'] / $items['phantram_count']) * 100, 2);
                    $phantram_w = number_format($phantram_w, 2, '.', '');
                    $phantram_not_count_w = round(($v['not_count'] / $items['phantram_notcount']) * 100, 2);
                    $phantram_not_count_w = number_format($phantram_not_count_w, 2, '.', '');
//                    echo (date('d/m/Y', strtotime($v['date'])));
                }
                ?>
                <tr>
                    <td class="t-cen"><strong><?php echo $v['number']; ?></strong></td>
                    <td>
                        <div class="run"><div class="runing" style="width: <?php echo $phantram_w . '%'; ?>"></div>&nbsp;</div><?php echo $phantram . '% (' . $v['count'] . ')'; ?>
                    </td>
                    <td class="last">
                        <div class="run"><div class="runing" style="width: <?php echo $phantram_not_count_w . '%'; ?>"></div>&nbsp;</div><?php echo $phantram_not_count . '% (' . $v['not_count'] . ')'; ?>
                    </td>
                </tr>
                <?php
            endforeach;
        }
        ?>
    </table>
</div>

<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block"><?php echo $msg ?></div>
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
    $(function(){$("#select_num").selectbox();$("#select_mien").selectbox()});
</script>