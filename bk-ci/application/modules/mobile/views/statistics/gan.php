<?php
$lname = '';
$statistics_alias = '';
foreach ($xs_location_menu as $value) {
    if ($lid == $value->id) {
        $lname = $value->name;
        $statistics_alias = $value->alias;
        break;
    }
}
?>
<div class="thongbao">
    <b id="tit_content">Kết quả Gan cực đại Xổ Số <?php echo $lname ?></b>
    <div>
        <?php
        if (count($items)) {
            $fromdate = date('d/m/Y', strtotime($fromdate));
            $todate = date('d/m/Y', strtotime($todate));
            foreach ($items as $key => $value) {
                ?>
                <table class="tbl-ds">
                    <tr id="chan"><td colspan="2" id="dam">Thống kê Gan cực đại dãy số <?php echo $key ?> xổ số <?php echo $lname ?> từ ngày: <?php echo $fromdate ?> - <?php echo $todate ?></td></tr>
                    <?php
                    if (!$value) {
                        echo '<tr><td colspan="2">Không xuất hiện !</td></tr>';
                    } else {
                        $value->from_date = date('d/m/Y', strtotime($value->from_date));
                        $value->to_date = date('d/m/Y', strtotime($value->to_date));
                        $value->end_date = date('d/m/Y', strtotime($value->end_date));
                        $value->final_date = date('d/m/Y', strtotime($value->final_date));
                        ?>
                        <tr>
                            <td>Gan cực đại</td>
                            <td><?php echo $value->total ?> lần quay không xuất hiện</td>
                        </tr>
                        <tr id="chan">
                            <td colspan="2">Từ ngày <strong class="red"><?php echo $value->from_date ?></strong> Đến ngày <strong class="red"><?php echo $value->to_date ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php if ($value->end_total > 1) { ?>
                                    Số <?php echo $key ?> xuất hiện ngày cuối <strong class="red"><?php echo $value->end_date ?></strong> đến <strong class="red"><?php echo $value->final_date ?></strong> là <?php echo $value->end_total ?> lần quay.
                                <?php } else { ?>
                                    Số <?php echo $key ?> xuất hiện ngày cuối <strong class="red"><?php echo $value->end_date ?></strong>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
        }
        ?>
    </div>
</div>
<div class="msg">Thống kê lô gan: Giúp bạn có thể tìm được các bộ số với các biên độ gan khác nhau trong 1 khoảng thời gian mà bạn chon lựa. Ngoài ra hệ thống còn tổng hợp dữ liệu biên độ gan max từ 00 đến 99 để bạn có thể tham khảo, logan trên ứng dụng xổ số của xoso.com được tra cứu theo dãy số, tất cả các giải, theo đầu, đuôi, theo giải đặc biệt.</div>