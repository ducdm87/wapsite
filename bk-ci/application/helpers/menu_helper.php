<?php
function get_menu_left()
{
	$CI	=&	get_instance();
	$CI->load->config('menu_conf');
	return $CI->config->item('menu_left');
}

function get_menu_top()
{
	$CI	=&	get_instance();
	$CI->load->config('menu_conf');
	return $CI->config->item('menu_top');
}