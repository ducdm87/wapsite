<?php
$lname = '';
$statistics_alias = '';
?>
<div class="title title-red">
    <div class="title-right">
        <ul class="tabs clearfix">
            <li<?php echo $type == 0 ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>thong-ke-giai-dac-biet-theo-tuan.html">Giải đặc biệt theo tuần</a></li>
            <li<?php echo $type > 0 ? ' class="active"' : '' ?>><a href="<?php echo $uri_root ?>thong-ke-cap-so-cuoi-giai-dac-biet-theo-tuan.html">Cặp số cuối giải đặc biệt theo tuần</a></li>
        </ul>
    </div>
</div>
<div class="box-result">							
    <div class="box-yellow select-provice">
        <form id="form_search" method="post" action="">
            <div class="clearfix rows datefrom">
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
                <span class="span-input"><input type="text" id="f_rangeStart" name="fromdate" value="<?php echo $fromdate ?>" /></span>
                <span class="span-input"><input type="text" id="f_rangeEnd" name="todate" value="<?php echo $todate ?>" /></span>
                <a class="read-more" href="javascript:;" onclick="submitForm('<?php echo $type == 0 ? 'thong-ke-giai-dac-biet-theo-tuan' : 'thong-ke-cap-so-cuoi-giai-dac-biet-theo-tuan' ?>');"><span>Xem</span></a>
            </div>
        </form>
    </div>
    <h1><?php echo $type == 0 ? 'Thống kê giải đặc biệt theo tuần' : 'Thống kê cặp số cuối giải đặc biệt theo tuần' ?></h1>
    <table class="tbl-ds tbl-gdb">
        <tr>
            <th>Thứ 2</th>
            <th>Thứ 3</th>
            <th>Thứ 4</th>
            <th>Thứ 5</th>
            <th>Thứ 6</th>
            <th>Thứ 7</th>
            <th class="last">Chủ nhật</th>
        </tr>
        <?php foreach ($items as $w => $list) { ?>
            <tr>
                <?php
                for ($i = 2; $i < 9; $i++) {
                    if ($w % 2 == 0) {
                        $class = $i % 2 ? 'bg-gray' : '';
                        if ($i == 8)
                            $class = 'last';
                    }else {
                        $class = $i % 2 ? '' : 'bg-gray';
                        if ($i == 8)
                            $class = 'bg-gray last';
                    }
                    $value = isset($list[$i]->data) ? $list[$i]->data : '';
                    $date = isset($list[$i]->extra) ? $list[$i]->extra : '';
                    ?>
                    <td class="<?php echo $class ?>">
                        <strong><?php echo $value ?></strong><br />
                        <span class="font10 t-gray"><?php echo $date ?></span>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block">
    <div>Tính năng này giúp bạn thống kê được trong khoảng thời gian, tỉnh thành bạn lựa chọn theo tuần:</div>
    <br/>
    <ul>
        <li>&Gt; Các giải đặc biệt trong khoảng thời gian được hiển thị theo các ngày trong tuần</li>
        <li>&Gt; Thống kê 2 số</li>
        <li>&Gt; Thống kê đầu số</li>
        <li>&Gt; Thống kê đuôi số</li>
        <li>&Gt; Thống kê tổng của 2 số cuối giải đặc biệt</li>
    </ul>
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
<script type="text/javascript" src="<?php echo js_link('tooltip.js') ?>"></script>
<script type="text/javascript">
    $(function(){$("#select_mien").selectbox()});$("#f_rangeStart").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});$("#f_rangeEnd").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});
</script>