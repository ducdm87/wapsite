<?php
function add_log($crime_id, $msg)
{
	$CI =& get_instance();
	$CI->load->model("log_model");
	return $CI->log_model->add($crime_id, $msg);
}