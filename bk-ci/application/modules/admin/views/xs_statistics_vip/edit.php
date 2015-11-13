<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/jscal2.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/jscal/src/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/jscal/src/js/lang/en.js"></script>
<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;"><?php echo lang('EDIT'); ?></div>
    </div>
    <form enctype="multipart/form-data" method="post" action="" id="articles_form">
        <div class="editcate_ct">
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang('EDIT'); ?>" class="btn" />        
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
                        <span class="left"><b>Tỉnh/TP<font color="red">(*)</font></b></span>
                        <span class="right">
                            <select name="lid" style="width: 200px;">
                                <?php foreach ($xs_location as $k => $v): ?>
                                    <option <?php echo(isset($submitted['lid']) && $submitted['lid'] == $v->id ? 'selected="selected"' : ''); ?> value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li> 
                    <li>
                        <span class="left"><b>Ngày<font color="red">(*)</font></b></span>
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
                        <span class="left"><b>Đặc biệt</b></span>
                        <span class="right"><input type="text" name="dac_biet" value="<?php echo(isset($submitted['dac_biet']) ? $submitted['dac_biet'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Cầu Loto VIP</b></span>
                        <span class="right"><input type="text" name="cau_loto" value="<?php echo(isset($submitted['cau_loto']) ? $submitted['cau_loto'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Loto Xiên</b></span>
                        <span class="right"><input type="text" name="lo_xien" value="<?php echo(isset($submitted['lo_xien']) ? $submitted['lo_xien'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Loto về nhiều</b></span>
                        <span class="right"><input type="text" name="ve_nhieu" value="<?php echo(isset($submitted['ve_nhieu']) ? $submitted['ve_nhieu'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Loto lâu không về</b></span>
                        <span class="right"><input type="text" name="lau_ve" value="<?php echo(isset($submitted['lau_ve']) ? $submitted['lau_ve'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b><?php echo lang('ACTIVE'); ?>:</b></span>
                        <span class="right">
                            <input name="status" <?php echo (isset($submitted['status']) && $submitted['status'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/> 
                        </span>
                    </li>

                </ul>
            </div>
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang('EDIT'); ?>" class="btn" />

            </div>
        </div>
    </form>
</div>
