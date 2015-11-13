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
    <b id="tit_content">Đầu số xuất hiện trong <?php echo $time_turn ?> lần quay XS <?php echo $lname ?></b>
    <div>
        <table>
            <tr>
                <th>Đặc biệt</th>
                <th><div class="thanh1">Lần xuất hiện</div></th>
            </tr>
            <?php
            foreach ($items['dau'] as $k => $v):
                $phantram_dacbiet = '0.00';
                $phantram_db_w = 0;
                if ($items['dau_dacbiet'][$k] > 0) {
                    $phantram_dacbiet = round(($items['dau_dacbiet'][$k] / $items['total_dacbiet_dau']) * 100, 2);
                    $phantram_dacbiet = number_format($phantram_dacbiet, 2, '.', '');

                    $phantram_db_w = round(($items['dau_dacbiet'][$k] / $items['phantram_dacbiet_dau']) * 100, 2);
                    $phantram_db_w = number_format($phantram_db_w, 2, '.', '');
                }
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><?php echo $k ?></td>
                    <td>
                        <div class="thanh1">
                            <div class="thongso">
                                <div class="hienthi" style="width: <?php echo $phantram_db_w . '%'; ?>"><p><?php echo $phantram_dacbiet . '% (' . $items['dau_dacbiet'][$k] . ')'; ?></p></div> 
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Loto</th>
                <th><div class="thanh1">Lần xuất hiện</div></th>
            </tr>
            <?php
            foreach ($items['dau'] as $k => $v):
                $phantram = '0.00';
                $phantram_w = 0;
                if ($v > 0) {
                    $phantram = round(($v / $items['total_loto_dau']) * 100, 2);
                    $phantram = number_format($phantram, 2, '.', '');

                    $phantram_w = round(($v / $items['phantram_loto_dau']) * 100, 2);
                    $phantram_w = number_format($phantram_w, 2, '.', '');
                }
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><?php echo $k ?></td>
                    <td>
                        <div class="thanh1">
                            <div class="thongso">
                                <div class="hienthi" style="width: <?php echo $phantram_w . '%'; ?>"><p><?php echo $phantram . '% (' . $v . ')'; ?></p></div> 
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="thongbao">
    <b id="tit_content">Đuôi số xuất hiện trong <?php echo $time_turn ?> lần quay XS <?php echo $lname ?></b>
    <div>
        <table>
            <tr>
                <th>Đặc biệt</th>
                <th><div class="thanh1">Lần xuất hiện</div></th>
            </tr>
            <?php
            foreach ($items['duoi'] as $k => $v):
                $phantram_dacbiet = '0.00';
                $phantram_db_w = 0;
                if ($items['duoi_dacbiet'][$k] > 0) {
                    $phantram_dacbiet = round(($items['duoi_dacbiet'][$k] / $items['total_dacbiet_duoi']) * 100, 2);
                    $phantram_dacbiet = number_format($phantram_dacbiet, 2, '.', '');

                    $phantram_db_w = round(($items['duoi_dacbiet'][$k] / $items['phantram_dacbiet_duoi']) * 100, 2);
                    $phantram_db_w = number_format($phantram_db_w, 2, '.', '');
                }
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><?php echo $k ?></td>
                    <td>
                        <div class="thanh1">
                            <div class="thongso">
                                <div class="hienthi" style="width: <?php echo $phantram_db_w . '%'; ?>"><p><?php echo $phantram_dacbiet . '% (' . $items['dau_dacbiet'][$k] . ')'; ?></p></div> 
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Loto</th>
                <th><div class="thanh1">Lần xuất hiện</div></th>
            </tr>
            <?php
            foreach ($items['duoi'] as $k => $v):
                $phantram = '0.00';
                $phantram_w = 0;
                if ($v > 0) {
                    $phantram = round(($v / $items['total_loto_duoi']) * 100, 2);
                    $phantram = number_format($phantram, 2, '.', '');

                    $phantram_w = round(($v / $items['phantram_loto_duoi']) * 100, 2);
                    $phantram_w = number_format($phantram_w, 2, '.', '');
                }
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><?php echo $k ?></td>
                    <td>
                        <div class="thanh1">
                            <div class="thongso">
                                <div class="hienthi" style="width: <?php echo $phantram_w . '%'; ?>"><p><?php echo $phantram . '% (' . $v . ')'; ?></p></div> 
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<div class="msg">Thống kê đưa ra tần suất xuất hiện theo biểu đồ của đầu đuôi các bộ số dựa vào số lần quay thưởng</div>