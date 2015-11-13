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
    <b id="tit_content">Thống kê các bộ số được đánh giá cao nhất</b>
    <div class="noidung">
        <table>
            <tr>
                <th>Cặp số</th>
                <th>Ngày về gần nhất</th>
                <th>Số lần xuất hiện</th>
                <th>Số lần chưa về</th>
            </tr>
            <?php
            foreach ($items['high'] as $k => $v) {
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><strong><?php echo $v['number']; ?></strong></td>
                    <td><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                    <td><?php echo $v['count']; ?></td>
                    <td><?php echo $v['not_count']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="thongbao">
    <b id="tit_content">Thống kê các bộ số ưu tiên khác thấp hơn</b>
    <div class="noidung">
        <table>
            <tr>
                <th>Cặp số</th>
                <th>Ngày về gần nhất</th>
                <th>Số lần xuất hiện</th>
                <th>Số lần chưa về</th>
            </tr>
            <?php
            foreach ($items['priority'] as $k => $v) {
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><strong><?php echo $v['number']; ?></strong></td>
                    <td><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                    <td><?php echo $v['count']; ?></td>
                    <td><?php echo $v['not_count']; ?></td>
                </tr>
            <?php } ?>	
        </table>
    </div>
</div>

<div class="thongbao">
    <b id="tit_content">Thống kê các bộ số có thể ra lô rơi</b>
    <div class="noidung">
        <table>
            <tr>
                <th>Cặp số</th>
                <th>Ngày về gần nhất</th>
                <th>Số lần xuất hiện</th>
                <th>Số lần chưa về</th>
            </tr>
            <?php
            foreach ($items['plots_fall'] as $k => $v) {
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><strong><?php echo $v['number']; ?></strong></td>
                    <td><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                    <td><?php echo $v['count']; ?></td>
                    <td><?php echo $v['not_count']; ?></td>
                </tr>
            <?php } ?>	
        </table>
    </div>
</div>

<div class="thongbao">
    <b id="tit_content">Thống kê các bộ số nên thận trọng hôm nay</b>
    <div class="noidung">
        <table>
            <tr>
                <th>Cặp số</th>
                <th>Ngày về gần nhất</th>
                <th>Số lần xuất hiện</th>
                <th>Số lần chưa về</th>
            </tr>
            <?php
            foreach ($items['cautious'] as $k => $v) {
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><strong><?php echo $v['number']; ?></strong></td>
                    <td><?php echo date('d/m/Y', strtotime($v['date'])); ?></td>
                    <td><?php echo $v['count']; ?></td>
                    <td><?php echo $v['not_count']; ?></td>
                </tr>
            <?php } ?>	
        </table>
    </div>
</div>
<div class="msg">Thống kê tổng hợp đưa ra các bộ số được đánh giá có khả năng cao sẽ về, các bộ số có khả năng sẽ không về, thống kê này sẽ giúp người chơi cẩn trọng hơn và có cơ sở để lựa chọn cho mình con số hợp lý nhất.</div>
