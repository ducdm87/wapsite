<?php
$lname = '';
$statistics_alias = '';
$label = '';
if ($type == 0) {
    $title = 'đầu';
    $label = 'Đầu';
} else {
    $title = 'đuôi';
    $label = 'Đuôi';
}
?>
<div class="title title-red">
    <div class="title-right">Thống kê lô tô theo đầu đuôi</div>
</div>
<div class="box-result">								
    <div class="select-provice rate-lo clearfix">
        <form id="form_search" method="post" action="">
            <div class="rows clearfix">
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
            <div class="rows">
                <label class="label-title">Tra cứu</label>
                <span class="span-lookup"><input type="radio" value="0" name="type"<?php if ($type == 0) echo ' checked="checked"' ?> /> <strong>Loto theo đầu</strong> </span>
                <input type="radio" value="1" name="type"<?php if ($type == 1) echo ' checked="checked"' ?> /> <strong>Loto theo đuôi</strong>
            </div>
            <div class="datefrom rows clearfix">
                <label class="label-title">Từ</label>
                <span class="span-input"><input type="text" id="f_rangeStart" name="fromdate" value="<?php echo $fromdate ?>" /></span>
                <label class="to">Đến</label>
                <span class="span-input"><input type="text" id="f_rangeEnd" name="todate" value="<?php echo $todate ?>" /></span>
            </div>
            <div class="rows seque clearfix">
                <label class="label-title">&nbsp;</label>
                <a class="read-more" href="javascript:;" onclick="submitForm('thong-ke-lo-to-theo-dau-duoi');"><span>Xem thống kê</span></a>
            </div>
        </form>
    </div>
    <h1>Thống kê lô tô theo đầu đuôi Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <?php
    if ($items):
        $fromdate = date('d/m/Y', strtotime($fromdate));
        $todate = date('d/m/Y', strtotime($todate));
        ?>
        <div class="title-tk">Thống kê loto theo <span class="red"><?php echo $title ?></span> từ ngày <?php echo $fromdate ?> đến ngày <?php echo $todate ?></div>
        <table class="tbl-ds tbl-dsdd t-cen">
            <tr>
                <td width="105" class="t-cen">Ngày </td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 0</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 1</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 2</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 3</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 4</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 5</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 6</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 7</td>
                <td><span class="t-gray"><?php echo $label ?></span><br /> 8</td>
                <td class="last"><span class="t-gray"><?php echo $label ?></span><br />9</td>
            </tr>
            <?php foreach ($items['value'] as $key => $value) { ?>
                <tr>
                    <td width="105" class="t-cen">
                        <?php echo date('d/m/Y', strtotime($key)) ?>
                    </td>
                    <?php
                    foreach ($value as $k => $v) {
                        if ($k == 9)
                            echo '<td class="last">' . $v . '</td>';
                        else
                            echo '<td>' . $v . '</td>';
                    }
                    ?>
                </tr>
            <?php } ?>
            <tr>
                <td width="105" class="t-cen bg-yelow red">Tổng số lần về</td>
                <?php
                foreach ($items['total'] as $k => $value) {
                    if ($k == 9)
                        echo '<td class="last bg-yelow red"><strong>' . $value . '</strong></td>';
                    else
                        echo '<td class="bg-yelow red"><strong>' . $value . '</strong></td>';
                }
                ?>
            </tr>
        </table>
    <?php endif; ?>
</div>
<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block">
    <div>Ý nghĩa của tính năng này là giúp bạn thống kê được trong khoảng thời gian, tỉnh thành bạn lựa chọn:</div>
    <br/>
    <ul>
        <li>&Gt; Thống kê các đầu số từ 0 đến 9 có số lần về là bao nhiêu</li>
        <li>&Gt; Thống kê các đuôi số từ 0 đến 9 có số lần về là bao nhiêu</li>
    </ul>
    <div>Được thiết kế khoa học, dễ hiểu và khác biệt tại xoso.com.</div>
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
    $(function(){$("#select_mien").selectbox()});$("#f_rangeStart").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});$("#f_rangeEnd").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});
</script>