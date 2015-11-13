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
if ($type == 0) {
    $title = 'đầu';
} else {
    $title = 'đuôi';
}
?>
<div class="thongbao">
    <?php
    if ($items):
        $fromdate = date('d/m/Y', strtotime($fromdate));
        $todate = date('d/m/Y', strtotime($todate));
        ?>
        <b id="tit_content">Thống kê theo <?php echo $title ?> số 0-9 Xổ Số <?php echo $lname ?> <?php echo $fromdate ?> - <?php echo $todate ?></b>
        <div>
            <table>
                <tr>
                    <th>Ngày</th>
                    <th><strong>0</strong></th>
                    <th><strong>1</strong></th>
                    <th><strong>2</strong></th>
                    <th><strong>3</strong></th>
                    <th><strong>4</strong></th>
                    <th><strong>5</strong></th>
                    <th><strong>6</strong></th>
                    <th><strong>7</strong></th>
                    <th><strong>8</strong></th>
                    <th><strong>9</strong></th>
                </tr>
                <?php
                $dem = 0;
                foreach ($items['value'] as $key => $value) {
                    $class = '';
                    if ($dem % 2 != 0)
                        $class = ' id="chan"';
                    ?>
                    <tr<?php echo $class ?>>
                        <td>
                            <?php echo date('d/m/Y', strtotime($key)) ?>
                        </td>
                        <?php
                        foreach ($value as $k => $v) {
                            echo '<td>' . $v . '</td>';
                        }
                        $dem++;
                        ?>
                    </tr>
                <?php } ?>
                <tr id="ts">
                    <td><strong>Tổng số</strong></td>
                    <?php
                    foreach ($items['total'] as $k => $value) {
                        echo '<td><strong>' . $value . '</strong></td>';
                    }
                    ?>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>
<div class="msg">Đầu số, đuôi số từ 0-9 xuất hiện bao nhiêu lần trong khoảng thời gian bạn chọn.</div>