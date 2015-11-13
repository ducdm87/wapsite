<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/jscal2.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/jscal/src/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/jscal/src/js/lang/en.js"></script>
<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;">Thêm mới</div>
    </div>
    <form method="post" action="<?php echo action_link('add'); ?>" id="articles_form">
        <div class="editcate_ct">
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang('ADD'); ?>" class="btn" />
            </div>
            <div class="boxadd">
                <ul class="lineadd2"> 
                    <?php if ($this->message->has('error')): ?>
                        <li>
                            <span class="left">&nbsp;</span>
                            <span class="right">
                                <?php echo $this->message->display(); ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <li>
                        <span class="left"><b>Khu vực<font color="red">(*)</font></b></span>
                        <span class="right">
                            <select name="lid" style="width: 200px;">
                                <?php foreach ($xs_location as $k => $v): ?>
                                    <option <?php echo(isset($submitted['lid']) && $submitted['lid'] == $v->id ? 'selected="selected"' : ''); ?> value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li> 
                    <li>
                        <span class="left"><b>Ngày mở thưởng<font color="red">(*)</font></b></span>
                        <span class="right">
                            <input type="text" id="f_rangeStart" name="date" value="<?php echo(isset($submitted['date']) ? date('d/m/Y', strtotime($submitted['date'])) : date("d/m/Y")); ?>" />
                            <input style="border: none;" type="image" id="f_rangeStart_trigger" onclick="return false;" src="<?php echo img_link('date.gif') ?>"/>
                        </span>
                        <script type="text/javascript">
                            new Calendar({
                                inputField: "f_rangeStart",
                                dateFormat: "%d/%m/%Y",
                                trigger: "f_rangeStart_trigger",
                                bottomBar: false,
                                onSelect: function() {
                                    var date = Calendar.intToDate(this.selection.get());
                                    this.hide();
                                }
                            });
                        </script>
                    </li>
                    <li>
                        <span class="left"><b>Giải đặc biệt</b></span>
                        <span class="right"><input type="text" name="a0" value="<?php echo(isset($submitted['a0']) ? $submitted['a0'] : ''); ?>" style="margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải nhất</b></span>
                        <span class="right"><input type="text" name="a1" value="<?php echo(isset($submitted['a1']) ? $submitted['a1'] : ''); ?>" style="margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải nhì</b></span>
                        <span class="right"><input type="text" name="a2" value="<?php echo(isset($submitted['a2']) ? $submitted['a2'] : ''); ?>" style="margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải ba</b></span>
                        <span class="right"><input type="text" name="a3" value="<?php echo(isset($submitted['a3']) ? $submitted['a3'] : ''); ?>" style="width:30%;margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải tư</b></span>
                        <span class="right"><input type="text" name="a4" value="<?php echo(isset($submitted['a4']) ? $submitted['a4'] : ''); ?>" style="width:40%;margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải năm</b></span>
                        <span class="right"><input type="text" name="a5" value="<?php echo(isset($submitted['a5']) ? $submitted['a5'] : ''); ?>" style="width:30%;margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải sáu</b></span>
                        <span class="right"><input type="text" name="a6" value="<?php echo(isset($submitted['a6']) ? $submitted['a6'] : ''); ?>" style="margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải bảy</b></span>
                        <span class="right"><input type="text" name="a7" value="<?php echo(isset($submitted['a7']) ? $submitted['a7'] : ''); ?>" style="margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Giải tám</b></span>
                        <span class="right"><input type="text" name="a8" value="<?php echo(isset($submitted['a8']) ? $submitted['a8'] : ''); ?>" style="margin:0" /></span>
                    </li>
                </ul>
            </div>
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang('ADD'); ?>" class="btn" />
            </div>
        </div>
    </form>
</div>
