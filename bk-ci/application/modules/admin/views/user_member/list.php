<?php
$MODULE = "USER";
?> 
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/jscal2.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/border-radius.css" />
<script src="<?php echo base_url(); ?>public/jscal/src/js/jscal2.js"></script>
<script src="<?php echo base_url(); ?>public/jscal/src/js/lang/en.js"></script>   
<div class="toppage">
    <span class="left">
        <form method="get" action="">
            <input placeholder="Nhập user hoặc email..." name="name" value="<?php echo (isset($_GET['name']) ? $_GET['name'] : ''); ?>"/>
            <select name="gender">
                <option value="">---Thành viên---</option>
                <option value="0" <?php echo (isset($_GET["gender"]) && $_GET["gender"] === '0' ? 'selected="selected"' : ''); ?>>Thường</option>
                <option value="1" <?php echo (isset($_GET["gender"]) && $_GET["gender"] == 1 ? 'selected="selected"' : ''); ?>>VIP</option>
            </select>
            <select name="group">
                <option value="0">---Nhóm---</option>
                <?php foreach ($group_rows as $k => $v): ?>
                    <option value="<?php echo $v->id; ?>" <?php echo (isset($_GET["group"]) && $_GET["group"] == $v->id ? 'selected="selected"' : ''); ?>><?php echo $v->name; ?></option>
                <?php endforeach; ?>
            </select>
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
            <a href="javascript:;">Tổng số: </a><font class="number">&nbsp;(<?php echo $total; ?>)</font>
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
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd">
            <a onclick="open_form('<?php echo action_link('add'); ?>')" href="javascript:void(0)"><?php echo lang($MODULE . '_ADD_NEW'); ?></a>
        </span>
    <?php endif; ?>
</div>
<style type="text/css">
    .linecate2,.linecate2 .column{height:25px}
</style>
<div class="bottom1">
    <div class="column" style="width: 2%;">&nbsp;</div>
    <div class="column" style="width: 50%;">&nbsp;</div>
    <span class="right1">
        <div class="pagination">
            <?php echo (isset($pagnav) ? $pagnav : ''); ?>
        </div>
    </span>
</div>
<div class="tableout">
    <?php echo $this->message->display(); ?>
    <form method="post" action="<?php echo action_link('do_action'); ?>" id="action_form">
        <div class="title1">
            <div class="column ta-center" style="width: 4%;"><?php echo lang('STT'); ?></div>
            <div class="column ta-center" style="width: 20%;">Tên đăng nhập</div>
            <div class="column ta-center" style="width: 15%;">Họ tên</div>
            <div class="column ta-center" style="width: 20%;">Email</div>
            <div class="column ta-center" style="width: 8%;">Mobile</div>
            <div class="column ta-center" style="width: 10%;">Thành viên</div>
            <div class="column ta-center" style="width: 7%;">Nhóm</div>
            <div class="column ta-center" style="width: 8%;">Ngày tạo</div>
            <div class="column ta-center" style="width: 6%;">Kích hoạt</div>
        </div>

        <?php if (count($user_list) > 0): ?>
            <?php //$limit = $; ?>
            <?php foreach ($user_list as $i => $user): ?>
                <div class="linecate2">
                    <div class="column ta-center" style="width: 4%;"><?php echo ($page - 1) * $limit + $i + 1; ?></div>

                    <div id="row_<?php echo $user->id; ?>">

                        <div class="column" style="width: 20%;position:relative">
                            <?php echo $user->username ?>
                            <div style="position:absolute;right:5px;top:0">
                                <a href="javascript:void(0)" onclick="open_form('<?php echo action_link('edit/' . $user->id); ?>')">Sửa</a>
                                &nbsp;|&nbsp;<a href="javascript:void(0)" onclick="member_delete('<?php echo $user->id; ?>')"><font color="#be0000">Xóa</font></a>
                            </div>
                        </div>
                        <div class="column" style="width: 15%;">
                            <?php echo $user->fullname; ?>
                        </div>
                        <div class="column" style="width: 20%;">
                            <?php echo $user->email; ?>
                        </div>
                        <div class="column ta-center" style="width: 8%;">
                            <?php echo $user->mobile; ?>
                        </div>
                        <div class="column ta-center" style="width: 10%;">
                            <?php echo $user->gender == 1 ? 'VIP (từ ' . date('d/m/Y', $user->time_active) . ')' : 'Thường' ?>
                        </div>
                        <div class="column ta-center" style="width: 7%;">
                            <?php
                            $group = $this->group_model->get_by(array('id' => $user->group_id));
                            if ($group) {
                                echo $group->name;
                            }
                            ?>
                        </div>
                        <div class="column ta-center" style="width: 8%;"><font class="date"><?php echo date('d-m-Y', strtotime($user->created_date)); ?></font></div>

                        <div class="column ta-center" style="width: 6%;">
                            <?php if ($user->active != 'yes'): ?>
                                <a href="javascript:void(0);" onclick="member_status('<?php echo $user->id; ?>', 'yes')"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
                            <?php else: ?>
                                <a href="javascript:void(0);" onclick="member_status('<?php echo $user->id; ?>', 'no')"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="bottom1">
            <div class="column" style="width: 2%;">&nbsp;</div>
            <div class="column" style="width: 50%;">&nbsp;</div>
            <span class="right1">
                <div class="pagination">
                    <?php echo (isset($pagnav) ? $pagnav : ''); ?>
                </div>
            </span>
        </div>
    </form>
</div>

<script>
    $('#action_form').iframer({
        onComplete: function (msg) {
            if (msg == 'yes') {
                load_content('user_list', '<?php echo current_link(); ?>', true);
            }
            else
                show_error('div_message', msg)
        }
    });
</script>