<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/border-radius.css" />
<link id="skin-win2k" title="Win 2K" type="text/css" rel="alternate stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/win2k/win2k.css" />
<link id="skin-steel" title="Steel" type="text/css" rel="alternate stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/steel/steel.css" />
<link id="skin-gold" title="Gold" type="text/css" rel="alternate stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/gold/gold.css" />
<link id="skin-matrix" title="Matrix" type="text/css" rel="alternate stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/matrix/matrix.css" />

<link id="skinhelper-compact" type="text/css" rel="alternate stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/reduce-spacing.css" />

<script src="<?php echo base_url(); ?>public/jscal/src/js/jscal2.js"></script>
<script src="<?php echo base_url(); ?>public/jscal/src/js/lang/en.js"></script>
<style type="text/css">
    .linecate{font-weight:normal}
</style>
<h1>Quản lý SMS</h1>
<div class="toppage">
    <span class="left">
        <ul>
            <li style="float: left;">
                <form method="get" action="">
                    <input name="mobile" placeholder="Điện thoại" value="<?php echo (isset($_GET["mobile"]) ? $_GET["mobile"] : ""); ?>"/>
                    <input type="checkbox" value="2" name="u_date" <?php echo (isset($_GET["u_date"]) && $_GET["u_date"] == 2 ? 'checked="checked"' : ''); ?>/>
                    <input id="f_rangeStart_1" type="text" name="start_date"  value="<?php echo (isset($_GET["start_date"]) ? $_GET["start_date"] : date("d/m/Y")); ?>" style="width:100px;" />
                    <input style="border: none;" type="image" id="f_rangeStart_trigger_1" onclick="return false;" src="<?php echo img_link('date.gif') ?>"/>
                    <input id="f_rangeStart_2" type="text" name="end_date"  value="<?php echo (isset($_GET["end_date"]) ? $_GET["end_date"] : date("d/m/Y")); ?>" style="width:100px;" />
                    <input style="border: none;" type="image" id="f_rangeStart_trigger_2" onclick="return false;" src="<?php echo img_link('date.gif') ?>"/>

                    <input type="submit" name="" value="Apply" class="btn" />
                </form>
            </li>
            </li>
        </ul>

        <script type="text/javascript">
            new Calendar({
                inputField: "f_rangeStart_1",
                dateFormat: "%d/%m/%Y",
                trigger: "f_rangeStart_trigger_1",
                bottomBar: false,
                onSelect: function() {
                    var date = Calendar.intToDate(this.selection.get());
                    //LEFT_CAL.args.min = date;
                    //LEFT_CAL.redraw();
                    this.hide();
                }
            });
            new Calendar({
                inputField: "f_rangeStart_2",
                dateFormat: "%d/%m/%Y",
                trigger: "f_rangeStart_trigger_2",
                bottomBar: false,
                onSelect: function() {
                    var date = Calendar.intToDate(this.selection.get());
                    //LEFT_CAL.args.min = date;
                    //LEFT_CAL.redraw();
                    this.hide();
                }
            });
            function clearRangeStart() {
                document.getElementById("f_rangeStart").value = "";
                //LEFT_CAL.args.min = null;
                //LEFT_CAL.redraw();
            };
        </script>
    </span>
</div>

<div class="toppage">
    <div style="float:left;font-size:13px"><a href="javascript:;" style="color:#2195C8;text-decoration:none"><strong>Tổng số:</strong> </a><font class="number"><?php echo $count; ?> SMS</font></div>
    <div class="pagination">
        <ul>
            <?php echo (isset($pagnav) ? $pagnav : ''); ?>
        </ul>
    </div>
</div>

<div class="tableout">
    <div class="title1">
        <div class="column ta-center" style="width:4%;"><?php echo lang('STT'); ?></div>
        <div class="column ta-center" style="width:10%;">Điện thoại</div>
        <div class="column ta-center" style="width:10%;">Đầu số</div>
        <div class="column ta-center" style="width:27%;">Nội dung</div>
        <div class="column ta-center" style="width:10%;">Mã tin nhắn</div>
        <div class="column ta-center" style="width:10%;">Tên nhà mạng</div>
        <div class="column ta-center" style="width:15%;">Thời gian gửi</div>
        <div class="column ta-center" style="width:8%;">Trạng thái</div>
    </div>
    <?php foreach ($orders as $k => $row): ?>
        <div class="linecate">
            <div class="column ta-center" style="width:4%;"><?php echo ((int) $offer + $k + 1) ?></div>
            <div class="column ta-center" style="width:10%;"><?php echo $row->Destination ?></div>
            <div class="column ta-center" style="width:10%;"><?php echo $row->SendFrom ?></div>
            <div class="column ta-center" style="width:27%;"><?php echo $row->InContent ?></div>
            <div class="column ta-center" style="width:10%;"><?php echo $row->Seqno ?></div>
            <div class="column ta-center" style="width:10%;"><?php echo $row->CommMethod ?></div>
            <div class="column ta-center" style="width:15%;"><?php echo date('m/d/Y h:i:s A', $row->created) ?></div>
            <div class="column ta-center" style="width: 8%;">
                <?php if ($row->status == 0): ?>
                    <img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Không thành công" alt="Không thành công" />
                <?php else: ?>
                    <img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Thành công" alt="Thành công" />
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="bottom1">
        <div class="pagination">
            <ul>
                <?php echo (isset($pagnav) ? $pagnav : ''); ?>
            </ul>
        </div>
    </div>

</div>
