<link href="<?php echo css_link('jquery.datepick.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo js_link('jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo js_link('jquery.datepick.js') ?>"></script>
<?php
$lname = '';
$statistics_alias = '';
$max = $num = $num2 = array();
for ($i = 0; $i <= 99; $i++) {
    $item = isset($count[$i]) ? $count[$i] : 0;
    $max[$i] = $item;
    $num[$item] = $i;
    $num2[$item][$i] = $i;
}
?>
<div class="title t-cen title-red">
    <div class="title-right">Thống kê theo chu kỳ</div>
</div>
<div class="select-provice">
    <div class="clearfix rows datefrom">
        <form id="form_search" method="post" action="">
            <label>Tỉnh / thành phố</label>
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
            <a class="read-more" href="javascript:;" onclick="submitForm('thong-ke-theo-chu-ky');"><span>Xem thống kê</span></a>
        </form>
    </div>
    <div class="box-table">
        <table class="tbl-num">
            <tr>
                <?php if (max($max) > 0) { ?>
                    <td class="t-cen first">
                        Cặp số <strong class="red">
                            <?php
                            $i = 0;
                            $sep = "";
                            foreach ($num2[max($max)] as $k => $strmax) {
                                $k = $k > 9 ? $k : "0" . $k;
                                if ($i > 0)
                                    $sep = ", ";
                                echo $sep . $k;
                                $i++;
                            }
                            ?>
                        </strong> xuất hiện nhiều nhất <?php echo max($max) ?> lần
                    </td>
                    <td class="t-cen<?php if (min($max) == 0) echo ' cen'; else echo ' last'; ?>">
                        Cặp số <strong class="red">
                            <?php
                            $min = min($max);
                            if ($min == 0)
                                $min = 1;
                            $i = 0;
                            $sep = "";
                            foreach ($num2[$min] as $k => $strmin) {
                                $k = $k > 9 ? $k : "0" . $k;
                                if ($i > 0)
                                    $sep = ", ";
                                echo $sep . $k;
                                $i++;
                            }
                            ?>
                        </strong> xuất hiện ít nhất <?php echo $min ?> lần
                    </td>
                    <?php if (min($max) == 0) { ?>
                        <td class="t-cen last">
                            Những cặp số <strong class="red">
                                <?php
                                $i = 0;
                                $sep = "";
                                foreach ($num2[min($max)] as $k => $strmin) {
                                    $k = $k > 9 ? $k : "0" . $k;
                                    if ($i > 0)
                                        $sep = ", ";
                                    echo $sep . $k;
                                    $i++;
                                }
                                ?>
                            </strong> chưa về lần nào (lô khan)
                        </td>
                    <?php } ?>
                <?php } else { ?>
                    <td class="t-cen">Không có dữ liệu được tìm thấy!</td>
                <?php } ?>
            </tr>
        </table>
    </div>
</div>
<h1>Thống kê theo chu kỳ Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
<?php if (max($max) > 0) { ?>
    <div class="box-result mb10 block-chuky">
        <div class="title-tk">Thống kê chi tiết</div>
        <table class="tbl-ds tbl-total">
            <tr>
                <td width="1%" class="t-cen" nowrap="">Ngày \ Cặp số</td>
                <?php for ($i = 0; $i <= 98; $i++) : ?>
                    <td class="t-cen" width="25"><strong><?php printf('%02d', $i) ?></strong></td>
                <?php endfor ?>
                <td class="last"><strong>99</strong></td>
            </tr>
            <?php foreach ($items as $date => $value) { ?>
                <tr>
                    <td class="t-cen"><?php echo date('d/m/Y', strtotime($date)) ?></td>
                    <?php
                    for ($i = 0; $i <= 99; $i++) {
                        $ii = $i > 9 ? $i : "0" . $i;
                        $item = isset($items[$date][$i]) ? $items[$date][$i] : '-';
                        $title = isset($items[$date][$i]) ? date('d/m/Y', strtotime("$date")) . " - " . $ii : '';
                        $class = 't-cen';
                        if ($i == 99)
                            $class = 'last';
                        $style = isset($items[$date][$i]) ? " style='background:#ccc'" : '';
                        ?> 
                        <td class="<?php echo $class ?>"<?php echo $style ?>><div class="numer" rel="tooltip" title="<?php echo $title; ?>"><?php echo $item ?></div></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <tr>
                <td class="t-cen bg-yelow red">Tổng lần về</td>
                <?php
                for ($i = 0; $i <= 99; $i++) {
                    $item = isset($count[$i]) ? $count[$i] : 0;
                    $class = 't-cen ';
                    if ($i == 99)
                        $class = 'last ';
                    ?>
                    <td class="<?php echo $class ?>bg-yelow red"><div class="numer"><strong><?php echo $item ?></strong></div></td>
                <?php } ?>
            </tr>
            <tr>
                <td class="t-cen bg-red">Ngày \ Cặp số</td>
                <?php for ($i = 0; $i <= 98; $i++) : ?>
                    <td class="t-cen bg-red"><div class="numer"><strong><?php printf('%02d', $i) ?></strong></div></td>
                <?php endfor ?>
                <td class="last bg-red"><div class="numer"><strong>99</strong></div></td>
            </tr>
        </table>
    </div>
<?php } ?>
<br/>
<div class="msg-block">
    <div>Tính năng này giúp bạn thống kê được trong khoảng thời gian bạn lựa chọn:</div>
    <br/>
    <ul>
        <li>&Gt; Các cặp số nào về nhiều nhất, các cặp số nào về ít nhất trong các lần mở thưởng</li>
        <li>&Gt; Các cặp số nào lâu chưa về, các cặp số mới về</li>
    </ul>
    <div>Thống kê theo chu kỳ tại xoso.com Dễ theo dõi, dễ hiểu, và rất khoa học, nó giúp bạn nhanh chóng ước lượng được con số mà mình quan tâm.</div>
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