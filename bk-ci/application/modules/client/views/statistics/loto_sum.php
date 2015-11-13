<?php
$lname = '';
$statistics_alias = '';
?>
<div class="title title-red">
    <div class="title-right">Thống kê lô tô theo tổng</div>
</div>
<div class="select-provice rate-lo clearfix">
    <form id="form_search" method="post" action="">
        <div class="rows clearfix">
            <div class="left">
                <label class="floatnone label-title">Tỉnh / Thành phố</label>
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
        </div>

        <div class="datefrom rows clearfix">
            <label class="label-title">Từ</label>
            <span class="span-input"><input type="text" id="f_rangeStart" name="fromdate" value="<?php echo $fromdate ?>" /></span>
            <label class="to">Đến</label>
            <span class="span-input"><input type="text" id="f_rangeEnd" name="todate" value="<?php echo $todate ?>" /></span>
        </div>
        <div class="rows seque clearfix">
            <label class="label-title">&nbsp;</label>
            <a class="read-more" href="javascript:;" onclick="submitForm('thong-ke-lo-to-theo-tong');"><span>Xem thống kê</span></a>
        </div>
    </form>
</div>
<h1>Thống kê lô tô theo tổng Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
<?php
if ($items) {
    $fromdate = date('d/m/Y', strtotime($fromdate));
    $todate = date('d/m/Y', strtotime($todate));
    ?>
    <div class="box-result">								
        <div class="title-tk">Thống kê loto theo <strong class="red">tổng</strong> xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a> từ <?php echo $fromdate ?> đến <?php echo $todate ?></div>
        <table class="tbl-ds tbl-total">
            <tr>
                <td width="100" class="t-cen">Ngày</td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>0</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>1</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>2</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>3</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>4</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>5</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>6</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>7</strong></td>
                <td class="t-cen"><span class="t-gray span-num">Tổng</span><strong>8</strong></td>
                <td class="t-cen last"><span class="t-gray span-num last">Tổng</span><strong>9</strong></td>
            </tr>
            <?php
            foreach ($items['value'] as $key => $value) {
                $tmp = strtotime($key);
                ?>
                <tr>
                    <td class="t-cen"><?php echo date('d/m/Y', $tmp) ?></td>
                    <?php
                    foreach ($value as $i => $v) {
                        if ($v->so == 0) {
                            if ($i == 9)
                                echo '<td class="last t-cen"><div class="numer">' . $v->total . '</div></td>';
                            else
                                echo '<td class="t-cen"><div class="numer">' . $v->total . '</div></td>';
                        }
                        else {
                            if ($i == 9)
                                echo '<td class="last t-cen"><div class="numer" rel="tooltip" title="' . $v->so . '">' . $v->total . '</div></td>';
                            else
                                echo '<td class="t-cen"><div class="numer" rel="tooltip" title="' . $v->so . '">' . $v->total . '</div></td>';
                        }
                    }
                    ?>
                </tr>
            <?php } ?>
            <tr>
                <td class="t-cen">Tổng số lần về</td>
                <?php
                foreach ($items['total'] as $i => $value) {
                    if ($i == 9)
                        echo '<td class="last t-cen"><div class="numer">' . $value . '</div></td>';
                    else
                        echo '<td class="t-cen"><div class="numer">' . $value . '</div></td>';
                }
                ?>
            </tr>
        </table>
    </div>
    <?php
}
?>
<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block">Thống kê tổng hai số cuối tổng từ 0 đến 9, giúp người chơi có những con số cụ thể về một cặp loto hoặc số đề (2 số cuối giải đặc biệt) của tỉnh thành mở thưởng trong khoảng thời gian mà bạn muốn xem, cặp số xuất hiện nhiều nhất,  ngày về gần nhất, bạn sẽ biết được con số nào, xuất hiện ngày nào, và tổng của các cặp số xuất hiện bao nhiêu lần trong 1 ngày. Chúc bạn may mắn.</div>
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
<script type="text/javascript" src="<?php echo js_link('tooltip.js') ?>"></script>
<script type="text/javascript">
    $(function(){$("#select_mien").selectbox()});$("#f_rangeStart").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});$("#f_rangeEnd").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});
</script>