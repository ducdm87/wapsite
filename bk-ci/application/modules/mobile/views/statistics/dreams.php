<?php
$limit = $limit + 20;
if ($limit > $total_rows)
    $limit = $total_rows;
?>
<div class="thongbao">
    <b id="tit_content">Kết quả giải đáp giấc mơ</b>
    <div class="noidung">
        <table>
            <tr>
                <th>STT</th>
                <th>Nội dung giấc mơ</th>
                <th>Bộ số tương ứng</th>
            </tr>
            <?php
            foreach ($rows as $k => $row):
                $class = '';
                if ($k % 2 != 0)
                    $class = ' id="chan"';
                ?>
                <tr<?php echo $class ?>>
                    <td><?php echo ($k + 1); ?></td>
                    <td><?php echo $row->title ?></td>
                    <td><?php echo $row->str_number ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="xemtiep">
    <a href="<?php echo $uri_root . 'mobile/dreams/?limit=' . $limit . '&title=' . $title ?>">
        <b id="xemtiep">Xem tiếp</b>
    </a>
</div>