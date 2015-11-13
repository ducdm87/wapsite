<h1><?php echo lang($MODULE.'_MANAGER');?></h1>
    <div class="toppage">
    	<span class="left">
        	
        	<!-- <font class="number">(9)</font> <a href="javascript:;">Tour Style</a><font class="line">|</font><font class="number">(1120)</font> <a href="javascript:;"><font color="#0b9901">Active</font></a><font class="line">|</font><font class="number">(5)</font> <a href="javascript:;"><font color="#c60001">Pending</font></a> -->
        </span>
        <?php if($ADD_ACTION == TRUE):?>
        	<span class="btnadd"><a href="<?php echo admin_url('module/add');?>"><?php echo lang($MODULE.'_ADD_NEW');?></a></span>
        <?php endif;?>
    </div>
    

    <div class="tableout">
		<div class="title1">
        	<div class="column" style="width:4%;">#</div>
            <div class="column" style="width:54%;"><?php echo lang($MODULE.'_NAME');?></div>
            <div class="column" style="width:10%;"><?php echo lang('FUNCTION_ADD_NEW');?></div>
            <div class="column">Vị trí</div>
        </div>
        <?php foreach($rows as $k => $row):?>
        <div class="linecate">
        	<div class="column" style="width:4%;"><?php echo ($k+1);?></div>
            <div class="column" style="width:54%;" onmouseover="Hovercat('<?php echo $row->id;?>')" onmouseout="Outcat('<?php echo $row->id;?>')">
            	<a href="javascript:;" class="menu1"><h2><?php echo $row->name;?></h2></a><br />
                <div class="action" id="neocat-<?php echo $row->id;?>">
                    <?php if($EDIT_ACTION == TRUE):?>
                    <img src="<?php echo img_link('edit.gif','admin');?>" /><a href="<?php echo admin_url('module/edit/'.$row->id);?>" onclick =""><?php echo lang('EDIT');?></a>
                    <?php endif;?>
                    <?php if($EDIT_ACTION == TRUE):?>
                    |<img src="<?php echo img_link('delete.gif','admin');?>" /><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module.'/delete/'.$row->id)?>"><font color="#be0000"><?php echo lang('DELETE');?></font></a>
                    <?php endif;?>
                </div>
            </div>
            <div class="column" style="width:10%;">
            	<?php if($ADD_ACTION == TRUE):?>
                <a href="<?php echo admin_url('module/function_add/'.$row->id);?>">Thêm chức năng</a>
                <?php endif;?>
            </div>
            
             <div class="column" style="width:10%;">
             	<?php echo $row->order;?>
             </div>
           
        </div>
        
        <?php 
        $sub_rows	=	$this->module_model->get_many_by(array('pid' => $row->id));
        ?>
        <?php if($sub_rows):?>
        <?php foreach($sub_rows as $k_sub => $sub):?>
        <?php if($k_sub==0):?>
        <div class="subcate" id="sub1">
        <?php endif;?>
        <?php if($k_sub==count($sub_rows)-1):?>
        </div>
        <?php endif;?>
        	<div class="linesubcate">
            	<div class="column" style="width:4%;">&nbsp;</div>
                <div class="column" style="width:54%;" onmouseover="Hovercat('<?php echo $sub->id;?>')" onmouseout="Outcat('<?php echo $sub->id;?>')">
                	<a href="#"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;".$sub->name;?></a><br />
                    <div class="action" id="neocat-<?php echo $sub->id;?>">
                    	<?php if($EDIT_ACTION == TRUE):?>
	                    <img src="<?php echo img_link('edit.gif','admin');?>" /><a href="<?php echo admin_url('module/function_edit/'.$sub->id);?>" onclick ="">Edit</a>
	                    <?php endif;?>
	                    <?php if($EDIT_ACTION == TRUE):?>
	                    |<img src="<?php echo img_link('delete.gif','admin');?>" /><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module.'/function_delete/'.$sub->id)?>"><font color="#be0000">Delete</font></a>
	                    <?php endif;?>
                	</div>
                </div>
                
            </div>
        <?php endforeach;?>
        <?php endif;?>
        
        <?php endforeach;?>
               
        </div>

    </div>