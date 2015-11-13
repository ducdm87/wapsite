<?php
$lname = '';
$statistics_alias = '';
?>
<div class="title title-red">
    <div class="title-right">Thống kê quan trọng</div>
</div>
<div class="box-result">								
    <div class="select-provice select-provice-num clearfix">
        <?php
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0)){
//        echo '<div class="alert_vip">Bạn chỉ xem được tối đa số lần quay là 30 lần<br/>';
//        $this->load->view('layout/vip');
//        echo '</div>';
//        }
        ?>
        <form id="form_search" method="post" action="">
            <div class="rows clearfix">
                <div class="left left-space">
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
            </div>
            <div class="rows clearfix t-cen">
                <a class="read-more" href="javascript:;" onclick="doSubmit('thong-ke-quan-trong');"><span>Xem kết quả</span></a>
            </div>	
        </form>
    </div>
    <h1>Thống kê quan trọng Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <div class="title-tk">Thống kê các bộ số được đánh giá cao nhất</div>
    <table class="tbl-ds">
        <tr>
            <td width="50" class="t-cen">Cặp số</td>
            <td class="t-cen">Ngày về gần nhất</td>
            <td class="t-cen">Số lần xuất hiện </td>
            <td class="last t-cen">Số lần chưa về</td>
        </tr>
        <?php foreach ($items['high'] as $k => $v) { ?>
            <tr>
                <td width="50" class="t-cen"><strong><?php echo $v['number']; ?></strong></td>
                <td class="t-cen"><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                <td class="t-cen"><?php echo $v['count']; ?></td>
                <td class="last t-cen"><?php echo $v['not_count']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <div class="title-tk">Thống kê các bộ số ưu tiên khác thấp hơn</div>
    <table class="tbl-ds">
        <tr>
            <td width="50" class="t-cen">Căp số</td>
            <td class="t-cen">Ngày về gần nhất</td>
            <td class="t-cen">Số lần xuất hiện </td>
            <td class="last t-cen">Số lần chưa về</td>
        </tr>
        <?php foreach ($items['priority'] as $k => $v) { ?>
            <tr>
                <td width="50" class="t-cen"><strong><?php echo $v['number']; ?></strong></td>
                <td class="t-cen"><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                <td class="t-cen"><?php echo $v['count']; ?></td>
                <td class="last t-cen"><?php echo $v['not_count']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <div class="title-tk">Thống kê các bộ số có thể ra lô rơi</div>
    <table class="tbl-ds">
        <tr>
            <td width="50" class="t-cen">Cặp số</td>
            <td class="t-cen">Ngày về gần nhất</td>
            <td class="t-cen">Số lần xuất hiện </td>
            <td class="last t-cen">Số lần chưa về</td>
        </tr>
        <?php foreach ($items['plots_fall'] as $k => $v) { ?>
            <tr>
                <td width="50" class="t-cen"><strong><?php echo $v['number']; ?></strong></td>
                <td class="t-cen"><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                <td class="t-cen"><?php echo $v['count']; ?></td>
                <td class="last t-cen"><?php echo $v['not_count']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <div class="title-tk">Thống kê các bộ số nên thận trọng hôm nay</div>
    <table class="tbl-ds">
        <tr>
            <td width="50" class="t-cen">Cặp số</td>
            <td class="t-cen">Ngày về gần nhất</td>
            <td class="t-cen">Số lần xuất hiện </td>
            <td class="last t-cen">Số lần chưa về</td>
        </tr>
        <?php foreach ($items['cautious'] as $k => $v) { ?>
            <tr>
                <td width="50" class="t-cen"><strong><?php echo $v['number']; ?></strong></td>
                <td class="t-cen"><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                <td class="t-cen"><?php echo $v['count']; ?></td>
                <td class="last t-cen"><?php echo $v['not_count']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="line-red">&nbsp;</div>

<br/>
<div id='div-gpt-ad-1378288615889-1' style='width:336px' class="mainmenu">
    <script type='text/javascript'>
        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1378288615889-1'); });
    </script>
</div>

<br/>
<div class="msg-block">
    <ul>
        <li>&Gt; Các bộ số được đánh giá cao nhất</li>
        <li>&Gt; Các bộ số được đánh giá mức độ thấp hơn</li>
        <li>&Gt; Các bộ số lô rơi</li>
        <li>&Gt; Các bộ số được đánh nên cẩn trọng</li>
    </ul>
    <div>Thống kê tổng hợp đưa ra các bộ số được đánh giá có khả năng cao sẽ về, các bộ số có khả năng sẽ không về, thống kê này sẽ giúp người chơi cẩn trọng hơn và có cơ sở để lựa chọn cho mình con số hợp lý nhất.</div>
</div>
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