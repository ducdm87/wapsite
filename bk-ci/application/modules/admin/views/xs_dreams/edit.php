<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;">Sửa</div>
    </div>
    <form method="post" action="" id="articles_form">
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
                        <span class="left"><b>Danh mục giấc mơ<font color="red">(*)</font></b></span>
                        <span class="right">
                            <select name="catid" style="width: 200px;">
                                <?php foreach ($xs_dreams_categories as $k => $v): ?>
                                    <option <?php echo(isset($submitted['catid']) && $submitted['catid'] == $v->id ? 'selected="selected"' : ''); ?> value="<?php echo $v->id; ?>"><?php echo $v->title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>  
                    <li>
                        <span class="left"><b>Nội dung giấc mơ<font color="red">(*)</font></b></span>
                        <span class="right"><input type="text" name="title" value="<?php echo(isset($submitted['title']) ? $submitted['title'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Bộ số tương ứng</b></span>
                        <span class="right"><input type="text" name="str_number" value="<?php echo(isset($submitted['str_number']) ? $submitted['str_number'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b><?php echo lang('ACTIVE'); ?></b></span>
                        <span class="right">
                            <input name="published" <?php echo (isset($submitted['published']) && $submitted['published'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/> 
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
