<?php
$lname = '';
$statistics_alias = '';
foreach ($xs_location_menu as $value) {
    if ($lid == $value->alias) {
        $lname = $value->name;
        $statistics_alias = $value->alias;
        break;
    }
}
$title = 'Dò vé số';
if ($sos != '')
    $title = 'Kết quả dò vé số ' . $sos . ' cho xổ số ' . $lname . ', ngày ' . date('d/m/Y', strtotime($fromdate));
?>
<h1 style="position: absolute; text-indent: -99999px"><?php echo $title ?></h1>
<script type="text/javascript">
    function loadtinh(){var d=$("#f_rangeStart").val();if(d==""){alert('Vui lòng nhập ngày mở thưởng trên tờ vé !');document.form_doveso.ngay.focus();return false}$.ajax({type:"GET",url:"<?php echo $uri_root ?>loadtinh/<?php echo $lid ?>/"+d,success:function(data){$("#boxCity").html(data);$("#select_mien").selectbox()}})}$(document).ready(function(e){loadtinh()});function doveso(){if($("#so").val()==""){alert('Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)');document.form_doveso.so.focus();return false}else if($("#so").val().length<5){alert('Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)');document.form_doveso.so.focus();return false}else if($("#f_rangeStart").val()==""){alert('Vui lòng nhập ngày mở thưởng trên tờ vé !');document.form_doveso.ngay.focus();return false}else document.form_doveso.submit()}
</script>
<div class="title title-red">
    <div class="title-right">
        DÒ VÉ SỐ ONLINE - MAY MẮN MỖI NGÀY
    </div>
</div>
<div class="select-provice t-cen clearfix">
    <?php
//    if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0)){
//    echo '<div class="alert_vip">Bạn chỉ được dò 1 vé số<br/>';
//    $this->load->view('layout/vip');
//    echo '</div>';
//    }
    ?>
    <form id="form_doveso" name="form_doveso" method="get" action="">
        <div class="clearfix rows datefrom">
            <label>Ngày</label>
            <span class="span-input">
                <input type="text" id="f_rangeStart" name="ngay" value="<?php echo $fromdate ?>" />
            </span>
            <label class="to">Tỉnh</label>
            <div class="left" id="boxCity"></div>
        </div>
        <div class="rows seque clearfix">
            <label class="left">Vé số</label>
            <span class="span-input"><input class="txt-input" type="text" id="so" name="so" value="<?php echo $sos ?>" /></span>
            <div class="clear number_eg">(vd: 45435,43223,65443);</div>
        </div>
        <a class="read-more" href="javascript:;" onclick="return doveso();"><span>Dò kết quả</span></a>
    </form>
</div>
<?php
if ($sos != '') {
    $arr_so = explode(',', $sos);
    $date_ve_do = $fromdate;
    $fromdate = date('d/m/Y', strtotime($fromdate));
    ?>
    <div class="box-result mb10">
        <div class="title-tk">Kết quả dò vé số xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a>, ngày <?php echo $fromdate ?></div>
        <div class="box-access">
            <p>Bạn đã truy vấn dò kết quả vé số <strong>Xổ Số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a></strong></p>
        </div>
        <?php
        foreach ($arr_so as $i => $so) {
//            if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && $i > 0)
//                break;
            $so = trim($so);
            ?>
            <div class="line-red">&nbsp;</div>
            <div class="box-access">
                <p>Loại vé <strong><?php echo strlen($so) ?> chữ số</strong>, mở thưởng ngày <strong><?php echo $fromdate ?></strong></p>
                <p>Dãy số của bạn là: <strong class="red"><?php echo $so ?></strong></p>									
            </div>
            <?php
            if ($items) {
                $class = '';
                $giaithuong = array(
                    200000000
                    , 20000000
                    , 5000000
                    , 2000000
                    , 400000
                    , 200000
                    , 100000
                    , 40000
                    , 40000
                );
                $url = '';
                switch ($items->area) {
                    case 'MB':
                        $l_area = 'Truyền thống';
                        $class = ' kqmienbac';
                        $url = $url_mienbac;
                        break;
                    case 'MT':
                        $l_area = 'Miền Trung';
                        $class = ' kqmiennam';
                        $url = $url_mientrung;
                        if (strlen($items->a0) == 5)
                            $giaithuong = array(
                                250000000
                                , 40000000
                                , 10000000
                                , 5000000
                                , 2500000
                                , 1000000
                                , 500000
                                , 250000
                                , 100000
                                , 0
                                , 500000
                            );
                        else
                            $giaithuong = array(
                                1500000000
                                , 40000000
                                , 10000000
                                , 5000000
                                , 2500000
                                , 1000000
                                , 500000
                                , 250000
                                , 100000
                                , 100000000
                                , 7000000
                            );
                        break;
                    case 'MN':
                        $l_area = 'Miền Nam';
                        $class = ' kqmiennam';
                        $url = $url_miennam;
                        $giaithuong = array(
                            1500000000
                            , 30000000
                            , 20000000
                            , 10000000
                            , 3000000
                            , 1000000
                            , 400000
                            , 200000
                            , 100000
                            , 100000000
                            , 6000000
                        );
                        break;
                }

                if ($result[$so] === '' || $result[$so] === NULL) {
                    ?>
                    <div class="box-gray clearfix">
                        <div class="imgs"><img src="<?php echo img_link('sime.png'); ?>" width="121" height="95" alt="" /></div>
                        <div class="gray-text">
                            <p><strong>Rất tiếc vé của bạn không trúng giải!</strong></p>
                            <p>Chúc bạn may mắn lần sau! :)</p>
                        </div>
                    </div>
                <?php } elseif ($result[$so] == 999) { ?>
                    <div class="box-gray clearfix">
                        <p>Xổ Số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a> ngày <strong><?php echo $fromdate ?></strong> không phát hành loại vé <strong><?php echo strlen($so) ?></strong> chữ số, vui lòng nhập đúng thông tin truy vấn!</p>
                        <p>Xem thêm thông tin phía dưới!</p>
                    </div>
                    <?php
                } else {
                    $giai = array();
                    $trigia = 0;
                    $arr_result = explode(',', $result[$so]);
                    foreach ($arr_result as $rs) {
                        if ($rs === '')
                            continue;

                        $trigia = $trigia + $giaithuong[$rs];
                        switch ($rs) {
                            case 0:
                                $giai[] = 'giải Đặc Biệt';
                                break;
                            case 1:
                                $giai[] = 'giải Nhất';
                                break;
                            case 2:
                                $giai[] = 'giải Nhì';
                                break;
                            case 3:
                                $giai[] = 'giải Ba';
                                break;
                            case 4:
                                $giai[] = 'giải Tư';
                                break;
                            case 5:
                                $giai[] = 'giải Năm';
                                break;
                            case 6:
                                $giai[] = 'giải Sáu';
                                break;
                            case 7:
                                $giai[] = 'giải Bảy';
                                break;
                            case 8:
                                $giai[] = 'giải Tám';
                                if ($items->area == 'MB')
                                    $giai[] = 'giải Khuyến Khích';
                                break;
                            case 9:
                                $giai[] = 'giải Đặt Biệt Phụ';
                                break;
                            case 10:
                                $giai[] = 'giải Khuyến Khích';
                                break;
                        }
                    }
                    ?>
                    <div class="box-gray clearfix">
                        <div class="imgs"><img src="<?php echo img_link('sime1.png'); ?>" width="120" height="115" alt="" /></div>
                        <div class="gray-text">
                            <p>
                                <strong>Chúc mừng bạn!</strong> <br  />
                                Vé số của bạn đã trúng <?php echo implode(' & ', $giai); ?>!<br />
                                Tổng giá trị giải thưởng là <strong><?php echo number_format($trigia, 0, '.', ',') ?> đ</strong>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="box-gray">
                    <p>Kết quả xổ số <a href="<?php echo $statistics_alias ?>.html"><?php echo $lname ?></a> mở thưởng ngày <?php echo $fromdate ?> hiện chưa có trên hệ thống.</p>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="line-red">&nbsp;</div>
    <?php
    if ($items) {
        $title_share = 'Xổ Số ' . $lname . ' - ' . $items->dateOfWeek . ' ngày ' . $items->date;

        $shared_content = 'Xổ Số ' . $items->name . ' ngày ' . $items->date . ',';
        $shared_content.=' giải DB: ' . $items->a0 . ',';
        $shared_content.=' giải nhất: ' . $items->a1 . ',';
        $shared_content.=' giải nhì: ' . $items->a2 . ',';
        $shared_content.=' giải ba: ' . $items->a3 . ',';
        $shared_content.=' giải tư: ' . $items->a4 . ',';
        $shared_content.=' giải năm: ' . $items->a5 . ',';
        $shared_content.=' giải sáu: ' . $items->a6 . ',';
        $shared_content.=' giải bảy: ' . $items->a7;
        if ($items->area != 'MB')
            $shared_content.=', giải tám: ' . $items->a8;

        $date_ve_do = str_replace('/', '-', $items->date);
        $alias_date = $statistics_alias . '/' . $date_ve_do;
        $curPageURL = urlencode($uri_root . $alias_date . '.html');
        $url_google = 'https://www.google.com/bookmarks/mark?op=add&amp;bkmk=' . $curPageURL . '&amp;title=' . urlencode($title_share) . '&amp;annotation=' . $shared_content;
        $url_facebook = 'http://www.facebook.com/sharer.php?u=' . $curPageURL;
        $url_yahoo = 'http://www.addtoany.com/add_to/yahoo_mail?linkurl=' . $curPageURL . '. ' . $shared_content . '&amp;type=page&amp;linkname=' . $title_share . '&amp;linknote=';
        $url_email = 'mailto:?subject=' . formatMail($title_share) . '&amp;body=' . $curPageURL . '. ' . formatMail($shared_content);
        ?>
        <div class="title title-red">
            <div class="title-right clearfix"><strong class="left">KẾT QUẢ XỔ SỐ <?php echo $l_area ?></strong>
                <a href="<?php echo $uri_root . $url ?>.html" class="right view-table">Xem chi tiết <span>&nbsp;</span></a>
            </div>
        </div>
        <div class="box-result">
            <table class="tbl-tt<?php echo $class ?>">
                <tr>
                    <td colspan="2">
                        <a href="<?php echo $uri_root . $alias_date ?>.html"><strong>Xổ Số <?php echo $lname ?> - <?php echo $items->dateOfWeek ?> ngày <?php echo $items->date ?></strong></a>
                    </td>
                    <td class="last t-cen">Giải thưởng(đ)</td>
                </tr>
                <tr>
                    <td class="bg-gray border-right" width="105">Giải đặc biệt</td>
                    <td class="bg-gray border-right giaidb">
                        <?php
                        echo '<strong class="red font18 span-space">' . ($items->a0 == '' ? "*****" : $items->a0) . '</strong>';
                        ?>
                    </td>
                    <td class="last bg-gray t-right"><strong><?php echo number_format($giaithuong[0], 0, '.', ',') ?></strong></td>
                </tr>
                <tr>
                    <td class="border-right">Giải nhất</td>
                    <td class="border-right giai1">
                        <?php
                        echo '<strong class="span-space">' . ($items->a1 == '' ? "*****" : $items->a1) . '</strong>';
                        ?>
                    </td>
                    <td class="last t-right"><?php echo number_format($giaithuong[1], 0, '.', ',') ?></td>
                </tr>
                <tr>
                    <td class="bg-gray border-right">Giải nhì</td>
                    <td class="bg-gray border-right giai2">
                        <?php
                        $str = str_replace(array('-'), array('</strong><strong class="span-space">'), $items->a2);
                        echo '<strong class="span-space">' . ($str == '' ? "*****" : $str) . '</strong>';
                        ?>
                    </td>
                    <td class="last t-right bg-gray"><?php echo number_format($giaithuong[2], 0, '.', ',') ?></td>
                </tr>
                <tr>
                    <td class="border-right">Giải ba</td>
                    <td class="border-right giai3">
                        <?php
                        $str = str_replace(array('-'), array('</strong><strong class="span-space">'), $items->a3);
                        echo '<strong class="span-space">' . ($str == '' ? "*****" : $str) . '</strong>';
                        ?>
                    </td>
                    <td class="last t-right"><?php echo number_format($giaithuong[3], 0, '.', ',') ?></td>
                </tr>
                <tr>
                    <td class="bg-gray border-right">Giải tư</td>
                    <td class="bg-gray border-right giai4">
                        <?php
                        $str = str_replace(array('-'), array('</strong><strong class="span-space">'), $items->a4);
                        echo '<strong class="span-space">' . ($str == '' ? "*****" : $str) . '</strong>';
                        ?>
                    </td>
                    <td class="last t-right bg-gray "><?php echo number_format($giaithuong[4], 0, '.', ',') ?></td>
                </tr>
                <tr>
                    <td class="border-right">Giải năm</td>
                    <td class="border-right giai5">
                        <?php
                        $str = str_replace(array('-'), array('</strong><strong class="span-space">'), $items->a5);
                        echo '<strong class="span-space">' . ($str == '' ? "*****" : $str) . '</strong>';
                        ?>
                    </td>
                    <td class="last t-right"><?php echo number_format($giaithuong[5], 0, '.', ',') ?></td>
                </tr>
                <tr>
                    <td class="bg-gray border-right">Giải sáu</td>
                    <td class="bg-gray border-right giai6">
                        <?php
                        $str = str_replace(array('-'), array('</strong><strong class="span-space">'), $items->a6);
                        echo '<strong class="span-space">' . ($str == '' ? "*****" : $str) . '</strong>';
                        ?>
                    </td>
                    <td class="last t-right bg-gray"><?php echo number_format($giaithuong[6], 0, '.', ',') ?></td>
                </tr>
                <tr>
                    <td class="border-right">Giải bảy</td>
                    <td class="border-right giai7">
                        <?php
                        $str = str_replace(array('-'), array('</strong><strong class="span-space">'), $items->a7);
                        echo '<strong class="span-space">' . ($str == '' ? "*****" : $str) . '</strong>';
                        ?>
                    </td>
                    <td class="last t-right"><?php echo number_format($giaithuong[7], 0, '.', ',') ?></td>
                </tr>
                <?php
                if ($items->area != 'MB') {
                    if (strlen($items->a0) == 5) {
                        ?>
                        <tr>
                            <td class="bg-gray border-right">Giải tám</td>
                            <td class="bg-gray border-right giai8">
                                <?php
                                echo '<strong class="span-space">' . ($items->a8 == '' ? "*****" : $items->a8) . '</strong>';
                                ?>
                            </td>
                            <td class="bg-gray last t-right"><?php echo number_format($giaithuong[8], 0, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-right">Giải khuyến khích (vé có 2 số cuối trùng với 2 số cuối của giải Đặc Biệt - <strong class="red"><?php echo substr($items->a0, 3, 2) ?></strong>)</td>
                            <td class="last t-right"><?php echo number_format($giaithuong[10], 0, '.', ',') ?></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td class="bg-gray border-right">Giải tám</td>
                            <td class="bg-gray border-right giai8">
                                <?php
                                echo '<strong class="span-space">' . ($items->a8 == '' ? "*****" : $items->a8) . '</strong>';
                                ?>
                            </td>
                            <td class="bg-gray last t-right"><?php echo number_format($giaithuong[8], 0, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-right">Giải Đặt Biệt Phụ (sai chữ số đầu, trúng 5 chữ số cuối so với giải Đặc Biệt)</td>
                            <td class="last t-right"><?php echo number_format($giaithuong[9], 0, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bg-gray border-right">Giải Khuyến Khích (trúng chữ số đầu tiên và sai 1 trong 5 chữ số còn lại)</td>
                            <td class="bg-gray last t-right"><?php echo number_format($giaithuong[10], 0, '.', ',') ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="2" class="bg-gray border-right">Giải khuyến khích (vé có 2 số cuối trùng với 2 số cuối của giải Đặc Biệt - <strong class="red"><?php echo substr($items->a0, 3, 2) ?></strong>)</td>
                        <td class="bg-gray last t-right"><?php echo number_format($giaithuong[8], 0, '.', ',') ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="line-red">&nbsp;</div>
        <div class="view-result clearfix">
            <div class="right share-right">
                <div class="share-like left">
                    <a rel="nofollow" href="<?php echo $url_facebook ?>" title="Facebook" target="_blank" class="share-f">&nbsp;</a>
                    <a rel="nofollow" href="<?php echo $url_google ?>" title="Google" target="_blank" class="share-g">&nbsp;</a>                
                    <a rel="nofollow" href="<?php echo $url_yahoo ?>" title="Yahoo" target="_blank" class="share-yahoo">&nbsp;</a>
                    <a rel="nofollow" href="<?php echo $url_email ?>" title="Email" target="_blank" class="share-email">&nbsp;</a>
                </div>
            </div>
        </div>
        <ul class="list-editor space1">
            <li>Để nhận kết quả xổ số <strong><?php echo $lname ?></strong> sớm nhất, soạn tin <span>KQ <?php echo $items->code ?></span> gửi <span>8017</span></li>
        </ul>
        <?php
        $lid_ve_do = 1;
        $url_veso = 'mien-bac';
        if ($items->area == 'MT') {
            $lid_ve_do = 2;
            $url_veso = 'mien-trung';
        } elseif ($items->area == 'MN') {
            $lid_ve_do = 3;
            $url_veso = 'mien-nam';
        }
        ?>
        <div class="tabs-note space-pleft clearfix">
            <a class="span-in" target="_blank" href="<?php echo $uri_root ?>in-ve-do.html?l=<?php echo $lid_ve_do ?>&amp;d=<?php echo $date_ve_do ?>&amp;t=2">In vé dò</a>
            <a class="span-dvo" href="<?php echo $uri_root ?>do-ve-so.html">Dò vé online</a>
            <a class="span-vs" href="<?php echo $uri_root ?>ve-so-<?php echo $url_veso ?>.html">Hình ảnh vé số </a>
            <a class="span-mvs" href="<?php echo $uri_root ?>mua-online.html">Mua online</a>
            <a class="span-tkxs" href="<?php echo $uri_root ?>thong-ke-quan-trong.html">Thống kê xổ số</a>
        </div>
        <?php
    }
}
?>
<br/>
<div class="msg-block">Bạn mua vé số, bạn không biết cách so sánh vé số, bạn chưa hiểu được giá trị các giải mà bạn có thể trúng số. Bạn chỉ cần nhập dãy số trên vé số của bạn vào ô “Vé số” và chọn ngày mở thưởng của tỉnh thành mà bạn tham gia, hệ thống sẽ tự động cập nhật, thống kê và đưa ra cho bạn biết được, bạn đã có trúng vé số hay không? trúng giải nào và tổng số tiền mà bạn đạt được (Nếu trúng).</div>
<br/>
<script type="text/javascript">
    $(function(){$("#select_mien").selectbox()});$("#f_rangeStart").datepick({dateFormat:'dd-mm-yyyy',maxDate:+0,onSelect:function(){loadtinh()}});
</script>