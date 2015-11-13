<?php
function show_prize($prize = null)
{
	$arr = explode('-',$prize);
	$str = '';
	foreach($arr as $_k => $_v)
	{
		if($_k % 2 == 0)
		{
			$str .= '<p>'.$_v.($_k == count($arr)-1 ? '' : '<span>-</span>');
		}
		else
		{
			$str .= $_v.'</p>';
		}
	}
	return $str;
}

function show_extension($extension = null)
{
	$arr = explode(',',$extension);
	$str = '';
	foreach($arr as $k => $v)
	{
		$str .= '<span>'.$v.'</span>';
	}
	return $str;
}

function write_transaction($member_id = NULL, $values = 0, $comment = '')
{
	die('+++++');
	$CI	=&	get_instance();
	$CI->load->model('transaction_model');
	if($CI->transaction_model->insert(array('member_id' => $member_id, 'values' => $values, 'comment' => $comment, 'time' => date('Y-m-d H:i:s'))))
	{
		return TRUE;
	}
	return FALSE;
}

