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
                        <span class="left"><b>Chọn loại hình xổ số<font color="red">(*)</font></b></span>
                        <span class="right">
                            <select name="type" style="width: 200px;">
                                <option <?php echo(isset($submitted['type']) && $submitted['type'] == 'DT123' ? 'selected="selected"' : ''); ?> value="DT123">Xổ số điện toán 123</option>
                                <option <?php echo(isset($submitted['type']) && $submitted['type'] == 'TT' ? 'selected="selected"' : ''); ?> value="TT">Xổ số thần tài</option>
                                <option <?php echo(isset($submitted['type']) && $submitted['type'] == 'DT6x36' ? 'selected="selected"' : ''); ?> value="DT6x36">Xổ số điện toán 6x36</option>
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
                        <span class="left"><b>Kết quả</b></span>
                        <span class="right"><input type="text" name="data" value="<?php echo(isset($submitted['data']) ? $submitted['data'] : ''); ?>" style="margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Alias</b></span>
                        <span class="right"><input type="text" name="alias" value="<?php echo(isset($submitted['alias']) ? $submitted['alias'] : ''); ?>" style="width:60%;margin:0" /></span>
                    </li>
                    <li>
                        <span class="left"><b><?php echo lang('ACTIVE'); ?></b></span>
                        <span class="right">
                            <input name="status" <?php echo (isset($submitted['status']) && $submitted['status'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/> 
                        </span>
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
