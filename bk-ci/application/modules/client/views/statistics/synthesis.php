<?php
$lname = '';
$statistics_alias = '';
?>
<div class="title title-red">
    <div class="title-right">Thống kê theo bộ số</div>
</div>
<div class="box-result block-synthesis">							
    <div class="select-provice t-cen clearfix">
        <form id="form_search" method="post" action="">
            <div class="rows">
                <label class="floatnone">Tỉnh / Thành phố</label>
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
            <div class="datefrom rows clearfix">
                <label>Từ</label>
                <span class="span-input"><input type="text" id="f_rangeStart" name="fromdate" value="<?php echo $fromdate ?>" /></span>
                <label class="to">Từ</label>
                <span class="span-input"><input type="text" id="f_rangeEnd" name="todate" value="<?php echo $todate ?>" /></span>
            </div>
            <div class="rows">
                <label class="floatnone">Kiểu thống kê</label>
                <select name="type" id="select_bo" tabindex="1">
                    <option <?php echo($type == 't4' ? 'selected="selected"' : ''); ?> value="t4">Thống kê bộ chẵn lẻ</option>
                    <option <?php echo($type == 't6' ? 'selected="selected"' : ''); ?> value="t6">Thống kê bộ chẵn chẵn</option>
                    <option <?php echo($type == 't3' ? 'selected="selected"' : ''); ?> value="t3">Thống kê bộ lẻ lẻ</option>
                    <option <?php echo($type == 't5' ? 'selected="selected"' : ''); ?> value="t5">Thống kê bộ lẻ chẵn</option>                
                    <option <?php echo($type == 't7' ? 'selected="selected"' : ''); ?> value="t7">Thống kê bộ kép</option>
                    <option <?php echo($type == 't8' ? 'selected="selected"' : ''); ?> value="t8">Thống kê bộ sát kép</option>
                </select>
            </div>
            <p><a class="read-more" href="javascript:;" onclick="submitForm('thong-ke-theo-bo-so');"><span>Xem kết quả</span></a></p>
        </form>
    </div>
    <h1>Thống kê theo bộ số Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <div class="title-tk"><?php
                    $fromdate = date('d/m/Y', strtotime($fromdate));
                    $todate = date('d/m/Y', strtotime($todate));
                    switch ($type) {
                        case 't1':
                            echo 'Thống kê tổng chẵn';
                            break;
                        case 't2':
                            echo 'Thống kê tổng lẻ';
                            break;
                        case 't3':
                            echo 'Thống kê bộ lẻ lẻ';
                            break;
                        case 't5':
                            echo 'Thống kê bộ lẻ chẵn';
                            break;
                        case 't4':
                            echo 'Thống kê bộ chẵn lẻ';
                            break;
                        case 't6':
                            echo 'Thống kê bộ chẵn chẵn';
                            break;
                        case 't7':
                            echo 'Thống kê bộ kép';
                            break;
                        case 't8':
                            echo 'Thống kê bộ sát kép';
                            break;
                        case 't9':
                            echo 'Thống kê 15 số về nhiều nhất';
                            break;
                        case 't10':
                            echo 'Thống kê 15 số về ít nhất';
                            break;
                        default :
                            echo 'Thống kê tổng hợp';
                            break;
                    }
                    ?> từ <?php echo $fromdate ?> đến <?php echo $todate ?></div>
    <table class="tbl-ds tbl-gdb">
        <tr>
            <th>Cặp số</th>
            <th>Ngày về gần nhất</th>
            <th>Lần xuất hiện</th>
            <th class="last">Số lần quay chưa về</th>
        </tr>
        <?php
        foreach ($items['value'] as $k => $v):
//            $phantram = round(($v['count'] / $items['total_count']) * 100, 2);
//            $phantram = number_format($phantram, 2, '.', '');
//            $phantram_not_count = round(($v['not_count'] / $items['total_notcount']) * 100, 2);
//            $phantram_not_count = number_format($phantram_not_count, 2, '.', '');
            ?>
            <tr>
                <td class="t-cen"><?php echo $v['number'] ?></td>
                <td class="t-cen"><?php echo (date('d/m/Y', strtotime($v['date']))) ?></td>
                <td class="t-cen"><?php echo $v['count'] ?></td>
                <td class="last t-cen"><?php echo $v['not_count'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block">
    <div>Thống kê tổng hợp: Thống kê 2 số cuối của tất cả các giải theo từng tỉnh mở thưởng:</div>
    <br/>
    <ul>
        <li>&Gt; Thống kê tổng chẵn</li>
        <li>&Gt; Thống kê tổng lẻ</li>
        <li>&Gt; Thống kê bộ lẻ lẻ</li>
        <li>&Gt; Thống kê lẻ chẵn</li>
        <li>&Gt; Thống kê bộ chẵn lẻ</li>
        <li>&Gt; Thống kê bộ chẵn chẵn</li>
        <li>&Gt; Thống kê bộ kép</li>
        <li>&Gt; Thống kê bộ sát kép</li>
    </ul>
    <div>Phân loại các bộ số theo các kiểu thống kê khác nhau, rồi thống kê theo từng tính năng, giúp bạn có thể nắm bắt được kiểu bộ số nào hay xuất hiện nhất, ít xuất hiện</div>
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
    $(function(){$("#select_mien").selectbox();$("#select_bo").selectbox()});$("#f_rangeStart").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});$("#f_rangeEnd").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});
</script>