<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<h1>Quản lý log</h1>
<div class="toppage"></div>
<div class="tableout">
    <div class="title1">
        <div class="column ta-center" style="width:4%;">ID</div>
        <div class="column ta-center" style="width:52%;">Hành động</div>
        <div class="column ta-center" style="width:20%;">Người thực hiện</div>
        <div class="column ta-center" style="width:20%;">Thời gian</div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column ta-center" style="width:4%;"><?php echo $row->id ?></div>
            <div class="column" style="width:52%;">
                <?php
                if ($row->msg == 1)
                    echo '<a href="' . admin_url('crime/update/' . $row->crime_id) . '">Thêm đối tượng truy nã có mã: ' . $row->crime_id . '</a>';
                elseif ($row->msg == 0)
                    echo 'Xoá đối tượng truy nã có mã: ' . $row->crime_id;
                elseif ($row->msg == 2)
                    echo '<a href="' . admin_url('crime/update/' . $row->crime_id) . '">Sửa đối tượng truy nã có mã: ' . $row->crime_id . '</a>';
                ?>
            </div>
            <div class="column" style="width:20%;">
                <a onclick="open_form('<?php echo admin_url('user_member/edit/' . $row->user_id); ?>')" href="javascript:;"><?php echo $row->username ?></a>
            </div>
            <div class="column ta-center" style="width: 20%;">
                <?php echo date("H:i:s d/m/Y", $row->created); ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="bottom1">
        <div class="pagination">
            <?php echo (isset($pagnav) ? $pagnav : ''); ?>
        </div>
    </div>        
</div>