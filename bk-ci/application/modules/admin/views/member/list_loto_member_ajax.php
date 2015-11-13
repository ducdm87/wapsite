<div class="editcate_top">
    <h2>Danh sách các số đã đặt của thành viên <?php echo $member->username;?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>


	<script>
		function on_submit()
		{
			$('#action_form').submit();
		}
	</script>
	<form action="<?php echo current_url();?>" method="get" id="action_form">
	
    <div class="tableout">
    	
    	<div class="title_bet">
        	<div class="column ta-center" style="width:4%; border-left: none;">&nbsp;</div>
        	<div class="column" style="width:15%;">
            	<select name="day" onchange="on_submit();">
            		<?php for($i=1; $i <= 31; $i++):?>
            		<option <?php echo((isset($_GET['day']) && $_GET['day'] == $i) || (!isset($_GET['day']) && date('d') == $i) ? 'selected="selected"' :  '');?> value="<?php echo add_zero_to_number($i);?>"><?php echo add_zero_to_number($i);?></option>
            		<?php endfor;?>
            	</select>
            	<select name="month" onchange="on_submit();">
            		<?php for($i=1; $i <= 12; $i++):?>
            		<option <?php echo((isset($_GET['month']) && $_GET['month'] == $i) || (!isset($_GET['month']) && date('m') == $i)  ? 'selected="selected"' : '');?> value="<?php echo add_zero_to_number($i);?>"><?php echo add_zero_to_number($i);?></option>
            		<?php endfor;?>
            	</select>
            	<select name="year" onchange="on_submit();">
            		<?php for($i=date('Y'); $i >= date('Y')-10; $i--):?>
            		<option <?php echo((isset($_GET['year']) && $_GET['year'] == $i) || (!isset($_GET['year']) && date('Y') == $i)  ? 'selected="selected"' : '');?> value="<?php echo $i;?>"><?php echo $i;?></option>
            		<?php endfor;?>
            	</select>
            </div>
            <div class="column" style="width:10%;">&nbsp;</div>
            <div class="column" style="width:10%;">&nbsp;</div>
            <div class="column" style="width:10%;">
            	<select onchange="on_submit();" name="bet_value" style="float: right; width: 100%;">
            		<option value="0">---Tất cả---</option>
            		<?php for($i = 10000; $i <= 1000000; $i+=10000):?>
            		<option <?php echo (isset($_GET['bet_value']) && $_GET['bet_value'] == $i ? 'selected="selected"' : '');?> value="<?php echo $i;?>"><?php echo number_format($i,0);?></option>
            		<?php endfor;?>
            	</select>
            </div>
            <div class="column" style="width:15%;">
            	<select onchange="on_submit();" name="win_value" style="float: right; width: 100%;">
            		<option value="0">---Tất cả---</option>
            		<?php for($i = 10000; $i <= 1000000; $i+=10000):?>
            		<option <?php echo (isset($_GET['win_value']) && $_GET['win_value'] == $i ? 'selected="selected"' : '');?> value="<?php echo $i;?>"><?php echo number_format($i,0);?></option>
            		<?php endfor;?>
            	</select>
            </div>
            
            <div class="column" style="width:10%;">
            	<select name="status" style="width:100%;" onchange="on_submit();">
		            	<option <?php echo (isset($_GET['status']) && $_GET['status'] == 'all' ? 'selected="selected"' : '');?> value="all">Tất cả</option>
		                <option <?php echo (isset($_GET['status']) && $_GET['status'] == 'winner' ? 'selected="selected"' : '');?> value="winner">Thắng</option>
		                <option <?php echo (isset($_GET['status']) && $_GET['status'] == 'lost' ? 'selected="selected"' : '');?> value="lost">Thua</option>
		                <option <?php echo (isset($_GET['status']) && $_GET['status'] == 'waiting' ? 'selected="selected"' : '');?> value="waiting">Chưa có kết quả</option>
		        </select>
            </div>
            <div class="column" style="width:10%;">
            	Cập nhật
            </div>
        </div>
        
		<div class="title_bet">
        	<div class="column ta-center" style="width:4%; border-left: none;">#</div>
        	<div class="column" style="width:15%;">Ngày đặt</div>
            <div class="column" style="width:10%;">Loại hình xs</div>
            <div class="column" style="width:10%;">Số đặt</div>
            <div class="column" style="width:10%;">Số tiền đặt(<?php echo get_currency();?>)</div>
            <div class="column" style="width:15%;">Số tiền trúng thưởng(<?php echo get_currency();?>)</div>
            
            <div class="column" style="width:10%;">Trạng thái</div>
            <div class="column" style="width:10%;">&nbsp;</div>
        </div>
        
        <?php foreach($rows as $k => $row):?>
        <?php if($row->result_status == 'winner'):?>
        <div class="linecate_bet<?php echo ($k==0 ? ' first' : '')?>">
        	<div class="column ta-center" style="width:4%;"><?php echo ($k+1);?></div>
            
            <div class="column ta-right" style="width:10%;">
            	<?php echo $row->loto_type->name;?>
            </div>
            <div class="column ta-right" style="width:10%;">
            	<?php echo $row->numbers;?>
            </div>
            <div class="column ta-right" style="width:10%;">
            	<?php echo show_money($row->bet_values,0);?>
            </div>
            
            <div class="column ta-right" style="width:15%;">
            	<?php echo show_money($row->win_values,0);?>
            </div>
            
            <div class="column ta-center" style="width:15%;">
            	<?php echo show_short_vn_date($row->bet_time);?>
            </div>
            
            <div class="column ta-center" style="width:10%;">
            	<?php echo show_bet_status($row->result_status);?>
            </div>
            <div class="column" style="width:10%;">
            	&nbsp;
            </div>
           
        </div>
        
        <?php else :?>
        	<div class="linesubcate_bet<?php echo ($k==0 ? ' first' : '')?>">
            	<div class="column ta-center" style="width:4%;"><?php echo ($k+1);?></div>
            	
                <div class="column ta-center" style="width:15%;">
	            	<?php echo show_short_vn_date($row->bet_time);?>
	            </div>
                
                <div class="column ta-right" style="width:10%;">
	            	<?php echo $row->loto_type->name;?>
	            </div>
	            <div class="column ta-right" style="width:10%;">
	            	<?php //echo $row->numbers;?>
	            </div>
	            <div class="column ta-right" style="width:10%;">
	            	<?php //echo show_money($row->bet_values,0);?>
	            </div>
	            
	            <div class="column ta-right" style="width:15%;">
	            	<?php //echo show_money($row->win_values,0);?>
	            </div>
	            
	            
	            
	            <div class="column ta-center" style="width:10%;">
	            	<?php //echo show_bet_status($row->result_status);?>
	            </div>
	            <div class="column ta-center" style="width:10%;">
	            	<a href="javascript:;" onclick="open_form('<?php echo action_link('loto_edit_bet_date/'.$row->id); ?>')">Sửa</a>
	            </div>
                
            </div>
            
            <?php 
            $where	=	array();
            $where['bet_id']	=	$row->id;
            
            if(isset($_GET['status']) && $_GET['status'] != 'all')
            {
            	$where['result_status']	=	$_GET['status'];
            }
            
            if(isset($_GET['bet_value']) && $_GET['bet_value'] != '0')
            {
            	$where['bet_values <=']	=	$_GET['bet_value'];
            }
            
            if(isset($_GET['win_value']) && $_GET['win_value'] != '0')
            {
            	$where['win_values <=']	=	$_GET['win_value'];
            }
            $bet_info	=	$this->bet_info_model->get_many_by($where);
            
            $total	=	$this->db->select('sum(win_values) as wins, sum(bet_values) as bets')->from('a_game_bet b')->join('a_game_bet_info bi','bi.bet_id=b.id')->where('member_id',$member->user_id)->get()->row();
            $s_win	=	0;
            $s_bet	=	0;
            ?>
            <?php foreach($bet_info as $k1 => $v1):?>
            <?php 
            $s_win+=$v1->win_values;
            $s_bet+=$v1->bet_values;
            $loto_type	=	$this->loto_type_model->get($v1->loto_type_id);
            ?>
            <div class="<?php echo ($v1->result_status == 'winner' ? 'linecate_bet' : 'linesubcate_bet');?>">
            	<div class="column ta-right" style="width:4%;">&nbsp;&nbsp;L&nbsp;&nbsp;<?php echo ($k+1).".".($k1+1);?></div>
            	
                <div class="column ta-center" style="width:15%;">
	            	<?php //echo show_short_vn_date($row->bet_time);?>
	            </div>
                
                <div class="column ta-right" style="width:10%;">
	            	<?php echo $loto_type->name;?>
	            </div>
	            <div class="column ta-right" style="width:10%;">
	            	<?php echo $v1->numbers;?>
	            </div>
	            <div class="column ta-right" style="width:10%;">
	            	<?php echo show_money($v1->bet_values,0);?>
	            </div>
	            
	            <div class="column ta-right" style="width:15%;">
	            	<?php echo show_money($v1->win_values,0);?>
	            </div>
	            
	            
	            
	            <div class="column ta-center" style="width:10%;">
	            	<?php echo show_bet_status($v1->result_status);?>
	            </div>
	            <div class="column ta-center" style="width:10%;">
	            	<a href="javascript:;" onclick="open_form('<?php echo action_link('loto_rebet/'.$v1->id); ?>')">Cập nhật</a>
	            </div>
                
            </div>
            <?php endforeach;?>
        <?php endif;?>
        
        <?php endforeach;?>
        <div class="linecate_bet<?php echo ($k==0 ? ' first' : '')?>">
        	<div class="column" style="width:4%;">&nbsp;</div>
            <div class="column" style="width:15%;" onmouseover="Hovercat('<?php echo $row->id;?>')" onmouseout="Outcat('<?php echo $row->id;?>')">
            	Tổng trang hiện tại
                
            </div>
            <div class="column ta-right" style="width:10%;">
            	&nbsp;
            </div>
            <div class="column ta-right" style="width:10%;">
            	&nbsp;
            </div>
            <div class="column ta-right" style="width:10%;">
            	<?php echo show_money($s_bet,0);?>
            </div>
            
            <div class="column ta-right" style="width:15%;">
            	<?php echo show_money($s_win,0);?>
            </div>
            
            <div class="column" style="width:10%;">
            	&nbsp;
            </div>
            
            <div class="column" style="width:10%;">
            	&nbsp;
            </div>
           
        </div>
        <div class="linecate_bet<?php echo ($k==0 ? ' first' : '')?>">
        	<div class="column" style="width:4%;">&nbsp;</div>
            <div class="column" style="width:15%;" onmouseover="Hovercat('<?php echo $row->id;?>')" onmouseout="Outcat('<?php echo $row->id;?>')">
            	Tổng tất cả
                
            </div>
            <div class="column ta-right" style="width:10%;">
            	&nbsp;
            </div>
            <div class="column ta-right" style="width:10%;">
            	&nbsp;
            </div>
            <div class="column ta-right" style="width:10%;">
            	<?php echo show_money($total->bets,0);?>
            </div>
            
            <div class="column ta-right" style="width:15%;">
            	<?php echo show_money($total->wins,0);?>
            </div>
            
            <div class="column" style="width:10%;">
            	&nbsp;
            </div>
            
            <div class="column" style="width:10%;">
            	&nbsp;
            </div>
           
        </div>
        
        <div class="bottom1">
        	<div class="column" style="width: 2%;">&nbsp;</div>
            <div class="column" style="width: 50%;">
            	
            </div>
            <span class="right1">
            	
                <div class="pagination">
                	
                    <ul>
                    <?php echo $pagnav; ?>
                    </ul>
                </div>
            </span>
        </div>       
	</div>
	</form>
<script>
$('#loto_form').iframer({
    onComplete: function(msg){
        //alert(msg);
    	if(msg == 'yes') {
    		$('#light_adct').hide();$('#fade_adct').hide();
    		load_content('user_list', window.location.href, true);
    	}
    	else show_error('div_message', msg)
    }
});
</script>