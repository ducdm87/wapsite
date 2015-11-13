<h1>Quản lý nhóm</h1>
    <div class="toppage">
    	<span class="left">
    		<!-- 
        	<select style="width:130px;">
            	<option value="1">Action</option>
                <option value="2">Edit</option>
                <option value="3">Delete</option>
            </select>
            <input type="submit" name="" value="Apply" class="btn" />
        	<font class="number">(9)</font> <a href="javascript:;">Tour Style</a><font class="line">|</font><font class="number">(1120)</font> <a href="javascript:;"><font color="#0b9901">Active</font></a><font class="line">|</font><font class="number">(5)</font> <a href="javascript:;"><font color="#c60001">Pending</font></a> -->
        </span>
        <?php if($ADD_ACTION == TRUE):?>
        	<span class="btnadd"><a href="<?php echo admin_url('group/add');?>"><?php echo lang('GROUP_ADD_NEW');?></a></span>
        <?php endif;?>
    </div>
    

    <div class="tableout">
		<div class="title1">
        	<div class="column ta-center" style="width:4%;"><?php echo lang('STT');?></div>
            <div class="column ta-center" style="width:54%;"><?php echo lang('GROUP_NAME');?></div>
            <div class="column ta-center" style="width:10%;"><?php echo lang('GROUP_DECENTRAL');?></div>
            <div class="column ta-center" style="width:10%;">admin</div>
            <div class="column ta-center" style="width:10%;">Số thành viên</div>
        </div>
        <?php foreach($rows as $k => $row):?>
        <div class="linecate">
        	<div class="column ta-center" style="width:4%;"><?php echo ($k+1);?></div>
            <div class="column" style="width:54%;" onmouseover="Hovercat('<?php echo $row->id;?>')" onmouseout="Outcat('<?php echo $row->id;?>')">
            	<a href="<?php echo($row->admin == 1 ? admin_url('user') : admin_url('user_member'))."?group=".$row->id;?>" class="menu1"><h2><?php echo $row->name;?></h2></a><br />
                <div class="action" id="neocat-<?php echo $row->id;?>">
                    <?php if($EDIT_ACTION == TRUE):?>
                    <img src="<?php echo img_link('edit.gif','admin')?>" /><a href="<?php echo admin_url('group/edit/'.$row->id);?>" onclick =""><?php echo lang('EDIT');?></a>
                    <?php endif;?>
                    <?php if($DELETE_ACTION == TRUE):?>
                    |<img src="<?php echo img_link('delete.gif','admin')?>" /><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url('group/delete/'.$row->id);?>"><font color="#be0000"><?php echo lang('DELETE');?></font></a>
                    <?php endif;?>
                </div>
            </div>
            <div class="column ta-center" style="width:10%;">
            	<a href="<?php echo admin_url('module/assign/'.$row->id);?>"><?php echo lang('GROUP_DECENTRAL');?></a>
            </div>
            
            <div class="column ta-center" style="width: 10%;">
	            <?php if($row->admin == 0): ?>
				<a href="<?php echo admin_url($module.'/set_admin/'.$row->id.'/1')?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
	            <?php else: ?>
				<a href="<?php echo admin_url($module.'/set_admin/'.$row->id.'/0')?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
	            <?php endif; ?>
            </div>
            <div class="column ta-center" style="width:10%;">
            	<a href="<?php echo($row->admin == 1 ? admin_url('user') : admin_url('user_member'))."?group=".$row->id;?>" class="menu1">Thành viên</a>(<?php echo $row->count;?>)
            </div>
            
        </div>
        
        <?php endforeach;?>
               
        </div>

    </div>