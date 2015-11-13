<?php
$lname = '';
$statistics_alias = '';
?>
<div class="title title-red">
    <div class="title-right">Thống kê gan cực đại</div>
</div>
<div class="box-result">								
    <div class="select-provice rate-lo clearfix">
        <?php
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0)){
//        echo '<div class="alert_vip">Bạn chỉ được xem với biên độ 10 ngày<br/>và thời gian tối đa là 1 năm tính đến thời điểm hiện tại.<br/>';
//        $this->load->view('layout/vip');
//        echo '</div>';
//        }
        ?>
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
                <label>Dãy số</label>
                <span class="span-input"><input type="text" name="number" id="number" value="<?php echo $number ?>" class="txt-input txt-inputor"></span>
                <div class="clear number_eg">(vd: 12,34,45,54,33,45,98);</div>
            </div>
            <div class="rows"></div>
            <div class="rows">
                <label class="label-title">Tra cứu</label>
                <span class="span-lookup"><input type="radio" value="1" name="type"<?php if ($type == 1) echo ' checked="checked"' ?> /> Theo Lô</span>
                <span class="span-lookup"><input type="radio" value="2" name="type"<?php if ($type == 2) echo ' checked="checked"' ?> /> Đầu Đuôi</span>
                <input type="radio" value="3" name="type"<?php if ($type == 3) echo ' checked="checked"' ?> /> Đặc Biệt
            </div>
            <div class="datefrom rows clearfix">
                <label class="label-title">Từ</label>
                <span class="span-input"><input type="text" id="f_rangeStart" name="fromdate" value="<?php echo $fromdate ?>" /></span>
                <label class="to">Đến</label>
                <span class="span-input"><input type="text" id="f_rangeEnd" name="todate" value="<?php echo $todate ?>" /></span>
            </div>
            <div class="rows seque clearfix">
                <label class="label-title">Biên độ gan</label>
                <span class="span-input space"><input<?php //echo (isset($_SESSION['user']) && $_SESSION['user']['gender'] == 1)?'':' disabled=""'?> type="text" name="amplitude" class="txt-input txt-liver" value="<?php echo $amplitude ?>" /></span>
                <a class="read-more" href="javascript:;" onclick="submitForm('thong-ke-lo-gan');"><span>Xem kết quả</span></a>
            </div>
        </form>
    </div>
    <h1>Thống kê gan cực đại Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <?php
    if (count($items)) {
        $fromdate = date('d/m/Y', strtotime($fromdate));
        $todate = date('d/m/Y', strtotime($todate));
        foreach ($items as $key => $value) {
            ?>
            <div class="title-tk">Thống kê Gan cực đại dãy số <?php echo $key ?> xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a> từ ngày: <?php echo $fromdate ?> - <?php echo $todate ?></div>
            <?php
            if (!$value) {
                echo '<table class="tbl-ds"><tr><td>Không xuất hiện !</td></tr></table>';
            } else {
                $url_from_date = $uri_root . $statistics_alias . '/' . date('d-m-Y', strtotime($value->from_date)) . '.html';
                $url_to_date = $uri_root . $statistics_alias . '/' . date('d-m-Y', strtotime($value->to_date)) . '.html';
                $url_end_date = $uri_root . $statistics_alias . '/' . date('d-m-Y', strtotime($value->end_date)) . '.html';
                $url_final_date = $uri_root . $statistics_alias . '/' . date('d-m-Y', strtotime($value->final_date)) . '.html';
                $value->from_date = date('d/m/Y', strtotime($value->from_date));
                $value->to_date = date('d/m/Y', strtotime($value->to_date));
                $value->end_date = date('d/m/Y', strtotime($value->end_date));
                $value->final_date = date('d/m/Y', strtotime($value->final_date));
                ?>
                <table class="tbl-ds">
                    <tr>
                        <td width="105">Gan cực đại </td>
                        <td class="last" colspan="3"><?php echo $value->total ?> lần quay không xuất hiện</td>
                    </tr>
                    <tr>
                        <td>Từ ngày </td>
                        <td class="red"><a href="<?php echo $url_from_date ?>" title="Kết quả sổ xố <?php echo $lname ?> ngày <?php echo $value->from_date ?>" target="_blank"><span class="red"><?php echo $value->from_date ?></span></a></td>
                        <td class="t-cen">Đến ngày</td>
                        <td class="last red"><a href="<?php echo $url_to_date ?>" title="Kết quả sổ xố <?php echo $lname ?> ngày <?php echo $value->to_date ?>" target="_blank"><span class="red"><?php echo $value->to_date ?></span></a></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="last">
                            <?php if ($value->end_total > 1) { ?>
                                Số <?php echo $key ?> xuất hiện ngày cuối <a href="<?php echo $url_end_date ?>" title="Kết quả sổ xố <?php echo $lname ?> ngày <?php echo $value->end_date ?>" target="_blank"><span class="red"><?php echo $value->end_date ?></span></a> đến <a href="<?php echo $url_final_date ?>" title="Kết quả sổ xố <?php echo $lname ?> ngày <?php echo $value->final_date ?>" target="_blank"><span class="red"><?php echo $value->final_date ?></span></a> là <?php echo $value->end_total ?> lần quay.
                            <?php } else { ?>
                                Số <?php echo $key ?> xuất hiện ngày cuối <a href="<?php echo $url_end_date ?>" title="Kết quả sổ xố <?php echo $lname ?> ngày <?php echo $value->end_date ?>" target="_blank"><span class="red"><?php echo $value->end_date ?></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                <?php
            }
        }
    }
    ?>
</div>
<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block">Thống kê lô gan: Giúp bạn có thể tìm được các bộ số với các biên độ gan khác nhau trong 1 khoảng thời gian mà bạn chon lựa. Ngoài ra hệ thống còn tổng hợp dữ liệu biên độ gan max từ 00 đến 99 để bạn có thể tham khảo, logan trên xoso.com được tra cứu theo dãy số, tất cả các giải, theo đầu, đuôi, theo giải đặc biệt.</div>
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
<?php /*echo (isset($_SESSION['user']) && $_SESSION['user']['gender'] == 1)?'':'minDate:-365,';*/ ?>
<script type="text/javascript">
    $(function(){$("#select_mien").selectbox()});$("#f_rangeStart").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});$("#f_rangeEnd").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});
</script>