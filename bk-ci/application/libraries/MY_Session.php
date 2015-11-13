<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  Nguyen Xuan Hung
 * @email   hungnguyen@vietnambiz.com
 * @date    19.11.2010
 */

class MY_Session extends CI_Session {
	
	function __construct()
	{
		parent::__construct();
		session_start();
	}
}