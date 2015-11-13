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
    <b id="tit_content">Các số xuất hiện trong <?php echo $time_turn ?> lần quay XS <?php echo $lname ?></b>
    <div>
        <table>
            <tr>
                <th>Cặp số</th>
                <th><div class="thanh1">Lần xuất hiện</div></th>
            </tr>
            <?php
            foreach ($items['value'] as $k => $v):
                $phantram = '0.00';
                $phantram_w = 0;
                if ($v['count'] > 0) {
                    $phantram = round(($v['count'] / $items['total']) * 100, 2);
                    $phantram = number_format($phantram, 2, '.', '');

                    $phantram_w = round(($v['count'] / $items['phantram_count']) * 100, 2);
                    $phantram_w = number_format($phantram_w, 2, '.', '');
                }
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><?php echo $v['number']; ?></td>
                    <td>
                        <div class="thanh1">
                            <div class="thongso">
                                <div class="hienthi" style="width: <?php echo $phantram_w . '%'; ?>"><p><?php echo $phantram . '% (' . $v['count'] . ')'; ?></p></div> 
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<div class="msg">Thống kê tổng hai số cuối tổng từ 00 đến 99, giúp người chơi có những con số cụ thể về một cặp loto hoặc số đề (2 số cuối giải đặc biệt) của tỉnh thành mở thưởng trong khoảng thời gian mà bạn muốn xem, cặp số xuất hiện nhiều nhất, bạn có thể chọn số lần quay, chọn 2 số cuối các giải hoặc chỉ riêng giải đặc biệt.</div>