<style type="text/css">
    .tbl-xs td{padding:10px 5px}
    #wrapper{font-size:11px}
</style>
<br/>
<div class="tit-xs clearfix"><strong class="title-xs">Thống kê giải đặc biệt theo tuần Xổ Số <?php echo $lname ?></strong></div>
<div class="block_content">
    <div class="box-result">							
        <table class="tbl-xs">
            <tr>
                <th>T2</th>
                <th>T3</th>
                <th>T4</th>
                <th>T5</th>
                <th>T6</th>
                <th>T7</th>
                <th class="last">CN</th>
            </tr>
            <?php foreach ($items as $w => $list) { ?>
                <tr>
                    <?php
                    for ($i = 2; $i < 9; $i++) {
                        if ($w % 2 == 0) {
                            $class = $i % 2 ? 'bg-gray' : '';
                            if ($i == 8)
                                $class = 'last';
                        }else {
                            $class = $i % 2 ? '' : 'bg-gray';
                            if ($i == 8)
                                $class = 'bg-gray last';
                        }
                        $value = isset($list[$i]->data) ? $list[$i]->data : '';
                        $date = isset($list[$i]->extra) ? date('d/m', strtotime(str_replace('/', '-', $list[$i]->extra))) : '';
                        ?>
                        <td class="<?php echo $class ?>">
                            <strong><?php echo $value ?></strong><br />
                            <span class="font10 t-gray"><?php echo $date ?></span>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>