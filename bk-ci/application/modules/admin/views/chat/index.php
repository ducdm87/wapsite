<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<h1>Quản lý Chat</h1>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/border-radius.css" />
<script src="<?php echo base_url(); ?>public/jscal/src/js/jscal2.js"></script>
<script src="<?php echo base_url(); ?>public/jscal/src/js/lang/en.js"></script>   
<div class="toppage">
    <span class="left">
        <form method="get" action="">
            <input placeholder="Nhập user hoặc email..." name="name" value="<?php echo (isset($_GET['name']) ? $_GET['name'] : ''); ?>"/>
            <select name="status">
                <option value="">---Trạng thái---</option>
                <option <?php echo (isset($_GET["status"]) && $_GET["status"] == "yes" ? 'selected="selected"' : ''); ?> value="yes">Kích hoạt</option>
                <option <?php echo (isset($_GET["status"]) && $_GET["status"] == "no" ? 'selected="selected"' : ''); ?> value="no">Chưa kích hoạt</option>
            </select>
            <span style="float: left; margin-left: 2px;">Lọc theo ngày</span>
            <input name="date" <?php echo (isset($_GET["date"]) && $_GET["date"] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/>
            <input id="f_rangeStart1" type="text" name="start_date"  value="<?php echo (isset($_GET["start_date"]) ? $_GET["start_date"] : date("d/m/Y")); ?>" style="width:100px;" />
            <input style="border: none;" type="image" id="f_rangeStart_trigger1" onclick="return false;" src="<?php echo img_link('date.gif') ?>"/>
            <input id="f_rangeStart2" type="text" name="end_date"  value="<?php echo (isset($_GET["end_date"]) ? $_GET["end_date"] : date("d/m/Y")); ?>" style="width:100px;" />
            <input style="border: none;" type="image" id="f_rangeStart_trigger2" onclick="return false;" src="<?php echo img_link('date.gif') ?>"/>
            <input value="Apply" class="btn" type="submit">
        </form>
        <script type="text/javascript">
            new Calendar({
                inputField: "f_rangeStart1",
                dateFormat: "%d/%m/%Y",
                trigger: "f_rangeStart_trigger1",
                bottomBar: false,
                onSelect: function () {
                    var date = Calendar.intToDate(this.selection.get());
                    //LEFT_CAL.args.min = date;
                    //LEFT_CAL.redraw();
                    this.hide();
                }
            });

            new Calendar({
                inputField: "f_rangeStart2",
                dateFormat: "%d/%m/%Y",
                trigger: "f_rangeStart_trigger2",
                bottomBar: false,
                onSelect: function () {
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
            }
            ;
        </script>
    </span>
</div>

<div class="toppage">
    <div style="float:left;font-size:13px"><a href="javascript:;" style="color:#2195C8;text-decoration:none"><strong>Tổng số:</strong> </a><font class="number"><?php echo $count; ?></font></div>
    <div class="pagination">
        <?php echo (isset($pagnav) ? $pagnav : ''); ?>
    </div>
</div>
<style type="text/css">
    .linecate{font-weight:normal}
</style>
<div class="tableout">
    <div class="title1">
        <div class="column ta-center" style="width:4%;"><?php echo lang('STT'); ?></div>
        <div class="column ta-center" style="width:46%;">Nội dung</div>
        <div class="column ta-center" style="width:15%;">Username</div>
        <div class="column ta-center" style="width:15%;">Fullname</div>
        <div class="column ta-center" style="width:8%;">Ngày gửi</div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column ta-center" style="width:4%;"><?php echo ($offset + $k + 1); ?></div>
            <div class="column" style="width:46%;">
                <?php echo $row->sms ?>
            </div>
            <div class="column" style="width:15%;">
                <?php echo $row->username ?>
            </div>
            <div class="column" style="width:15%;">
                <?php echo $row->fullname ?>
            </div>
            <div class="column" style="width:8%;text-align:center">
                <?php echo date('d/m/Y H:i:s', $row->created) ?>
            </div>
            <div class="column ta-center" style="width:10%;">
                <?php if ($EDIT_ACTION == TRUE): ?>
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>" /><a href="javascript:;" onclick ="open_form('<?php echo admin_url($module . '/edit/' . $row->id); ?>');"><?php echo lang('EDIT'); ?></a>
                <?php endif; ?>
                <?php if ($EDIT_ACTION == TRUE): ?>
                    |&nbsp;<img src="<?php echo img_link('delete.gif', 'admin'); ?>" /><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module . '/delete/' . $row->id) ?>"><font color="#be0000"><?php echo lang('DELETE'); ?></font></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="bottom1">
        <div class="pagination">
            <?php echo (isset($pagnav) ? $pagnav : ''); ?>
        </div>
    </div>
</div>