<?php
$lname = '';
$statistics_alias = '';
?>
<div class="title title-red">
    <div class="title-right">Thống kê Loto theo Tỉnh/Thành</div>
</div>
<div class="box-result">								
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
                <label class="to">Đến</label>
                <span class="span-input"><input type="text" id="f_rangeEnd" name="todate" value="<?php echo $todate ?>" /></span>
            </div>
            <div class="rows seque clearfix">
                <label>Dãy số</label>
                <span class="span-input"><input type="text" class="txt-input" name="number" id="number" value="<?php echo $number ?>" /></span>
                <div class="clear number_eg">(vd: 12,34,45,54,33,45,98);</div>
            </div>
            <p><a class="read-more" href="javascript:;" onclick="submitForm('thong-ke-lo-to-tinh');"><span>Xem kết quả</span></a></p>
        </form>
    </div>
    <h1>Thống kê Loto theo Tỉnh/Thành Xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></h1>
    <?php
    if ($items) {
        $fromdate = date('d/m/Y', strtotime($fromdate));
        $todate = date('d/m/Y', strtotime($todate));
        foreach ($items as $key => $value) {
            ?>
            <div class="title-tk">Thống kê dãy số <?php echo $key ?> xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a> từ ngày: <?php echo $fromdate ?> - <?php echo $todate ?></div>
            <table class="tbl-ds">
                <?php
                foreach ($value as $item) {
                    if ($item->data == '') {
                        echo '<tr>
                            <td colspan="2">- Không xuất hiện dãy số này trong thời gian trên !</td>
                        </tr>';
                    } else {
                        $url = $uri_root . $statistics_alias . '/' . date('d-m-Y', strtotime($item->date)) . '.html';
                        $item->date = date('d/m/Y', strtotime($item->date));
                        $giai = '';
                        $item->data = $item->data . '-';
                        $item->data = str_replace($key . '-', '<span class="red">' . $key . '</span>-', $item->data);
                        $item->data = substr($item->data, 0, strlen($item->data) - 1);
                        $item->data = str_replace('-', ' - ', $item->data);
                        switch ($item->giai) {
                            case 0:
                                $giai = 'Giải đặc biệt';
                                break;
                            case 1:
                                $giai = 'Giải nhất';
                                break;
                            case 2:
                                $giai = 'Giải nhì';
                                break;
                            case 3:
                                $giai = 'Giải ba';
                                break;
                            case 4:
                                $giai = 'Giải tư';
                                break;
                            case 5:
                                $giai = 'Giải năm';
                                break;
                            case 6:
                                $giai = 'Giải sáu';
                                break;
                            case 7:
                                $giai = 'Giải bảy';
                                break;
                            case 8:
                                $giai = 'Giải tám';
                                break;
                            default:
                                break;
                        }

                        echo '<tr>
                            <td width="100"><a title="Xem kết quả xổ số ' . $lname . ' Ngày: ' . $item->date . '" target="_blank" href="' . $url . '">' . $item->date . '</a></td>
                            <td class="last"><div>' . $giai . ': ' . $item->data . '</div></td>
                        </tr>';
                    }
                }
                ?>
            </table>
            <?php
        }
    }
    ?>
</div>
<div class="line-red">&nbsp;</div>
<br/>
<div class="msg-block">Thống kê đưa ra cặp số xuất hiện ở mỗi giải mà ngày đó cặp số đó xuất hiện tính trong khoảng  thời thời gian bạn chọn, theo tỉnh, thành phố mở thưởng cho các bộ số bạn quan tâm, từ đó bạn có thể chọn các thống kê khác để đưa ra quyết định hợp lý, chúc bạn may mắn.</div>
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
    $(function(){$("#select_mien").selectbox()});$("#f_rangeStart").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});$("#f_rangeEnd").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0});
</script>