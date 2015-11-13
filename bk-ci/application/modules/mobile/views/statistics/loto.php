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
    <b id="tit_content">Thống kê Loto theo Tỉnh/Thành Xổ số <?php echo $lname ?></b>
    <div>
        <?php
        if ($items) {
            $fromdate = date('d/m/Y', strtotime($fromdate));
            $todate = date('d/m/Y', strtotime($todate));
            echo '<table class="tbl-ds">';
            foreach ($items as $key => $value) {
                ?>
                <tr id="chan"><td colspan="2" id="dam">Thống kê dãy số <?php echo $key ?> xổ số <?php echo $lname ?> từ ngày: <?php echo $fromdate ?> - <?php echo $todate ?></td></tr>
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
                        $item->data = str_replace($key . '-', '<strong class="red">' . $key . '</strong>-', $item->data);
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
                            <td>' . $item->date . '</td>
                            <td><div>' . $giai . ': ' . $item->data . '</div></td>
                        </tr>';
                    }
                }
            }
            echo '</table>';
        }
        ?>
    </div>
</div>
<div class="msg">Thống kê đưa ra cặp số xuất hiện ở mỗi giải mà ngày đó cặp số đó xuất hiện tính trong khoảng thời thời gian bạn chọn, theo tỉnh, thành phố mở thưởng cho các bộ số bạn quan tâm, từ đó bạn có thể chọn các thống kê khác để đưa ra quyết định hợp lý, chúc bạn may mắn.</div>