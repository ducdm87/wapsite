<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('admin'.EXT);
/**
 * @author  Nguyen Viet Manh
 * @email   manhnv@binhoang.com
 * @date    09.02.2011
 */

class Member extends admin {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model','loto_model','group_model','member_main_account_model'));
        $this->data['group_rows']	=	$this->group_model->get_all();
    }
    
    function index($page = 1)
    {
        $limit  = $this->config->item('user', 'limit');
        $offset = ($page - 1) * $limit;
        
        $this->data['page'] = $page;
        $this->data['limit'] = $limit;
        $members	=	array();
        
        $where	=	array();
        
        $where['is_member']	=	1;
        
        if($status = $this->input->get('status')) {
        	 $members	=	$this->user_model->limit($limit, $offset)->get_many_by('status', $status);
        }
        else {
        	$members	= 	$this->user_model->limit($limit, $offset)->get_many_by($where);
        }
        
        $conf =	array(
        		'base_url'		=> admin_url($this->router->class).'/index',
        		'total_rows'	=> $this->user_model->count_by($where),
        		'per_page'		=> $limit,
        		'cur_page'		=> $page,
        );
        $this->pagination->initialize($conf);
        //$this->data['pagnav'] = $this->pagination->display_query_string();
        $this->data['pagnav'] = $this->pagination->display();
        
        //print_r($members);
        
        foreach($members as $k => $v)
        {
        	//print_r($main_account);die();
        	//echo $v->user_id;
        	if($main_account	=	$this->member_main_account_model->get_by(array('member_id' => $v->user_id)))
        	{
        		//print_r($main_account);
        		$members[$k]->balances_main_account	=	$main_account->balances;
        	}
        	else
        	{
        		if($main_account_id = $this->member_main_account_model->insert(array('member_id' => $v->user_id)))
        		{
        			$members[$k]->balances_main_account	=	0;
        		}
        	}
        }
        
        $this->data['user_list']	=	$members;
 
    	if($this->input->is_ajax_request()) {
			$this->load->view('member/list', $this->data);
		}
		else {
			$this->data['tpl_file']	= 'member/index';
			$this->load->view('layout/default', $this->data);
		}
    }
    
    function list_loto($member_id = NULL)
    {
    	$this->load->model(array('member_model','bet_info_model','bet_model','loto_type_model'));
    	$member	=	$this->member_model->get($member_id);
    	$this->data['member']	=	$member;
    	
    	$page	=	(isset($_GET['p']) ? $_GET['p'] : 1);
    	$limit	=	10;
    	$offset	=	($page-1)*$limit;
    	
    	$where	=	array();
    	$where['member_id']	=	$member_id;
    	if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year']))
    	{
    		$where['DATE(bet_time)']	=	$_GET['year'].'-'.$_GET['month'].'-'.$_GET['day'];
    	}
    	else
    	{
    		$where['DATE(bet_time)']	=	date('Y-m-d');
    	}
    	
    	$result		=	$this->bet_model->count_by($where);
    	
    	$url	=	current_link();//admin_url($this->router->class).'/on_money'
    	$conf =	array(
    			'base_url'		=> $url,
    			'total_rows'	=> $result['count'],
    			'per_page'		=> $limit,
    			'cur_page'		=> $page,
    	);
    	$this->data['total']	=	$result['total'];
    	$this->pagination->initialize($conf);
    	$this->data['pagnav']	=	$this->pagination->display_query_string();
    	$this->data['rows']		=	$this->bet_model->order_by('date','DESC')->get_many_by($where);
    	
    	if($this->input->is_ajax_request()) {
    		$this->load->view('member/list_loto_member_ajax', $this->data);
    	}
    	else {
    		$this->data['tpl_file']	= 'member/list_loto_member';
    		$this->load->view('layout/default', $this->data);
    	}
    	
    }
    
    function loto_rebet($bet_info_id = NULL)
    {
    	$this->load->model(array('bet_info_model','loto_type_model','bet_model','member_model'));
    	$row	=	$this->bet_info_model->get($bet_info_id);
    	$submit	=	array();
    	
    	if($row)
    	{
    		$submit['numbers']	=	$row->numbers;
    		$submit['bet_values']	=	$row->bet_values;
    	}
    	
    	
    	if($_SERVER['REQUEST_METHOD'] == 'POST')
    	{
    		$numbers	=	$this->input->post('number');
    		$bet_values	=	$this->input->post('money');
    		
    		$submit['numbers']		=	$numbers;
    		$submit['bet_values']	=	$bet_values;
    			if($bet	=	$this->bet_model->get($row->bet_id))
    			{
    				//die('===='.$bet->member_id);
    				if($member = $this->member_model->get($bet->member_id))
    				{
    					
    					$balances	=	($member->balances-$bet_values)+$row->bet_values;
    					if($bet_values > $member->balances)
    					{
    						die('Số tiền chơi phải <= số tiền có trong tài khoàn.');
    					}
    					
    					if($bet_values % 1000 != 0)
    					{
    						die('Số tiền chơi phải là bội số của 1000.');
    					}
    					
    					$tmp	=	explode('-', $numbers);
    					foreach($tmp as $k => $v)
    					{
    						if(!is_numeric($v) || strlen($v) != 2)
    						{
    							die('Số đặt không hợp lệ!');
    						}
    					}
    					
    					
    					try{
    						if($this->member_model->update($member->user_id, array('balances' => $balances)))
    						{
    							if($this->bet_info_model->update($row->id, $submit)) die('yes');
    						}
    						
    					}
    					catch(Exception $ex){
    						die($ex);
    					}
    				}
    			}
    	}
    	
    	if($row)
    	{
    		$this->data['loto_type']	=	$this->loto_type_model->get($row->loto_type_id);
    	}
    	
    	$this->data['submit']	=	$submit;
    	$this->data['row']	=	$row;
    	$this->load->view('member/loto_rebet', $this->data);
    }
    
    function loto_edit_bet_date($bet_id = NULL)
    {
    	$this->load->model(array('bet_model'));
    	$row	=	$this->bet_model->get($bet_id);
    	$submit	=	array();
    	
    	if($row)
    	{
    		$submit['date']	=	$row->date;
    		$submit['bet_time']	=	$row->bet_time;
    		
    		if($_SERVER['REQUEST_METHOD'] == "POST")
    		{
    			$date	=	$this->input->post('date');
    			$bet_time	=	$this->input->post('bet_time');
    			
    			$submit['date']	=	$date;
    			$submit['bet_time']	=	$bet_time;
    			
    			if($this->bet_model->update($bet_id, $submit))
    			{
    				die('yes');
    			}
    		}
    	}
    	
    	$this->data['submit']	=	$submit;
    	$this->data['row']	=	$row;
    	$this->load->view('member/loto_edit_bet_date', $this->data);
    }
    
    function recharge($member_id = NULL)
    {
    	//echo "".$member_id;
    	$this->load->model(array('recharge_model','member_model','member_main_account_model'));
    	$this->load->library('form_validation');
    	
    	if($member = $this->member_model->get($member_id))
    	{
    		//print_r($member);
    		if($_SERVER['REQUEST_METHOD'] == 'POST')
    		{
    			$account_from	=	$this->input->post('account_from');
    			$account_to		=	$this->input->post('account_to');
    			$account_type		=	$this->input->post('account_type');
    			$values			=	$this->input->post('values');
    			$message		=	$this->input->post('message');
    			$this->form_validation->set_rules('values','Số tiền chuyển','required|numeric|callback__check_money');
    			
    			if($this->form_validation->run()==TRUE){
    			
    				$data	=	array(
    						'account_from'	=>	$account_from,
    						'account_to'	=>	$account_to,
    						'amount_transfer'		=>	$values,
    						'message'		=>	$message,
    						'client_ip'		=>	'',
    						'date_transfer'	=>	date('Y-m-d H:i:s'),
    						'status'		=>	'success',
    						'member_id'		=>	$member_id,
    						'account_type'	=>	$account_type
    				);
    				 
    				//print_r($data);
    				 
    				if($this->recharge_model->insert($data))
    				{
    					if($account_type == 'loto')
    					{
    						if($this->member_model->update($member_id, array('balances' => ($values+$member->balances))))
    							die('yes');
    					}
    					elseif($account_type == 'main')
    					{
    						if($main_account	=	$this->member_main_account_model->get_by(array('member_id' => $member_id)))
    						{
    							$this->member_main_account_model->update($main_account->id, array('balances' => ($values+$main_account->balances)));
    							die('yes');
    						}
    						else
    						{
    							if(!$main_account_id = $this->member_main_account_model->insert(array('member_id' => $member_id, 'balances' => $values)))
    							{
    								die('Có lỗi trong quá trình xử lý dữ liệu!');
    							}
    						}
    					}
    					
    				}
    				
    				die('no');
    			}
    			else
    			{
    				die(validation_errors());
    			}
    			
    		}
    	}
    	
    	$this->load->view('member/recharge', $this->data);
    }
    
    function _check_money($money = NULL)
    {
    	if($money % 1000 != 0)
    	{
    		$this->form_validation->set_message('_check_money','%s phải là bội số của 1000!');
    		return false;
    	}
    	
    	return true;
    }
    
    function balance()
    {
    	$p	=	(isset($_GET['p']) ? $_GET['p'] : 1);
    	$limit	=	20;
    	$offset	=	($p-1) * $limit;
    	$users	=	$this->user_model->limit($limit, $offset)->get_all();
    	//print_r($users);
    	$this->data['rows']	=	$users;
    	foreach($users as $k => $v)
    	{
    		$users[$k]->statistic	=	$this->loto_model->statistic_by_user_id($v->user_id);
    	}
    	$this->data['tpl_file']		=	"member/balance";
    	$this->load->view('layout/default', $this->data);
    }
    
    function history($user_id = NULL, $p = 1)
    {
    	$limit	=	1;
    	$offset	=	($p - 1) * $limit;
    	$result	=	$this->loto_model->history($user_id, $limit, $offset);//ajax_url
    	$url	=	admin_url("member/ajax_history/".$user_id);
    	$conf	=	array(
    		'base_url'		=>	$url,
    		'total_rows'	=>	$result['total'],
    		'per_page'		=>	$limit,
    		'cur_page'		=>	$p
    	);
    	$this->pagination->initialize($conf);
    	$this->data['pagnav']		=	$this->pagination->ajax_url();		
    	$rows	=	$result['rows'];
    	foreach($rows as $k => $v){
    		switch($v->result_status)
    		{
    			case 'winner':
    				$rows[$k]->result_status	=	"Thắng";
    				break;
    			case 'lost':
    				$rows[$k]->result_status	=	"Thua";
    				break;
    			default:
    				$rows[$k]->result_status	=	"Đang chơi";
    		}
    	}
    	$this->data['rows']	=	$rows;
    	$this->load->view('member/history', $this->data);
    }
    
    function ajax_history($user_id = NULL, $p = 1)
    {
    	$limit	=	1;
    	$offset	=	($p - 1) * $limit;
    	$result	=	$this->loto_model->history($user_id, $limit, $offset);//ajax_url
    	$url	=	admin_url("member/ajax_history/".$user_id);
    	$conf	=	array(
    			'base_url'		=>	$url,
    			'total_rows'	=>	$result['total'],
    			'per_page'		=>	$limit,
    			'cur_page'		=>	$p
    	);
    	$this->pagination->initialize($conf);
    	$this->data['pagnav']		=	$this->pagination->ajax_url();
    	$rows	=	$result['rows'];
    	foreach($rows as $k => $v){
    		switch($v->result_status)
    		{
    			case 'winner':
    				$rows[$k]->result_status	=	"Thắng";
    				break;
    			case 'lost':
    				$rows[$k]->result_status	=	"Thua";
    				break;
    			default:
    				$rows[$k]->result_status	=	"Đang chơi";
    		}
    	}
    	$this->data['rows']	=	$rows;
    	$this->load->view('member/ajax_history', $this->data);
    }
    
    function change_pass()
    {
    	if($_SERVER['REQUEST_METHOD'] == 'POST') 
    	{
    		$this->form_validation->set_rules('old_password','Mật khẩu cũ','required|trim|xss_clean|callback__check_login');	
    		$this->form_validation->set_rules('new_password','Mật khẩu mới','required|trim|xss_clean|min_length[6]|max_length[12]');
    		$this->form_validation->set_rules('c_password','Mật khẩu xác nhận','required|trim|xss_clean|matches[new_password]');
    		
    		if($this->form_validation->run()===TRUE)
    		{
    			$this->user_model->update($_SESSION['_admin']['user_id'],array('password' => md5($this->input->post('new_password'))));
    			redirect(base_url().'acp_admin/login/');
    			#echo "adasd";
    		}
    		else
    		{
    			$this->message->error	=	$this->form_validation->get_error_array();
    			#echo "false";
    		}
    	}
    	
    	$this->data['tpl_file']		=	'admin/member/change_pass';
    	$this->load->view('layout/default', $this->data);
    }
    
    function _check_login($pass)
    {
    	if(!$this->user_model->get_by(array('username' => $_SESSION['_admin']['username'],'password' => md5($pass),'status' => 'active')))
    	{
    		$this->form_validation->set_message('_check_login','The %s is incorrect!');
    		return FALSE;
    	}
    	return TRUE;
    }
    
    function add()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
    		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean')
    		                      ->set_rules('password', 'Password', 'required|matches[re_password]|trim|xss_clean')
    		                      ->set_rules('email', 'Email', 'required|valid_email|trim|xss_clean');    		                      ;

    		if($this->form_validation->run() == TRUE)
            {
                $data = array(
                    'username'    => $this->input->post('username'),
                    'password'    => md5($this->input->post('password')),
                    'created_date'  => date('Y-m-d H:i:s'),
                		'fullname'	=>	$this->input->post('fullname'),
                		'address'	=>	$this->input->post('address'),
                		'gender'	=>	$this->input->post('gender'),
                		'mobile'	=>	$this->input->post('mobile'),
                		'identity_card'	=>	$this->input->post('identity_card'),
                		'date_of_birth'	=>	$this->input->post('date_of_birth'),
                		'email'       => $this->input->post('email'),
                		'group_id'    => $this->input->post('permission'),
                		'active'      => $this->input->post('active'),
                		'is_member'	  =>	'1'
                );
                
                if($this->user_model->check_exist($data['username'])) {// Tồn tại username
                    die('This username not available !');
                }
                else {
                    if($member_id = $this->user_model->insert($data))
                    {
                    	$this->member_main_account_model->insert(array('member_id' => $member_id, 'balances' => 0));
                    	die('yes');
                    }
                }
            }
            else {
                die(validation_errors());
            }
        }
        
        //$data = array();
        //$this->data['group_list'] = $this->user_model->get_group_list();
        $this->load->view('member/add', $this->data);
    }
    
    function edit($user_id = '')
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
    		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|xss_clean'); 

    		$pass	=	$this->input->post('password');
    		if($pass != '')
    		{
    			$this->form_validation->set_rules('password', 'Password', 'matches[re_password]|trim|xss_clean');
    		}

    		if($this->form_validation->run() == TRUE) {
                $data = array(
                	'fullname'	=>	$this->input->post('fullname'),
                	'address'	=>	$this->input->post('address'),
                	'gender'	=>	$this->input->post('gender'),
                	'mobile'	=>	$this->input->post('mobile'),
                	'identity_card'	=>	$this->input->post('identity_card'),
                	'date_of_birth'	=>	$this->input->post('date_of_birth'),
                    'email'       => $this->input->post('email'),
                    'group_id'    => $this->input->post('permission'),
                    'active'      => $this->input->post('active'),
                );
                
                if($pass = $this->input->post('password')) {
                    $data['password'] = md5($pass);
                }
                
                $this->user_model->update($user_id, $data);
                if(!$this->member_main_account_model->get($user_id))
                {
                	$this->member_main_account_model->insert(array('member_id' => $user_id, 'balances' => 0));
                }
				die('yes');
            }
            else {
                die(validation_errors());
            }
        }

        $data = array();
        $this->data['user']       = $this->user_model->get_by(array('user_id' => $user_id));
        
        $this->load->view('member/edit', $this->data);
    }

	/**
	 * @date	11.03.2011
	 */
	function delete()
	{
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$id = $this->input->post('id');
	        if(is_numeric($id)) {
	            $this->user_model->delete($id);
	        }
	        else { // multi : user_id is array
	            $this->user_model->delete_many($id);
	        }
            die('yes');
        }
	}

	/**
	 * @date	11.03.2011
	 */
    function load_row($id = null)
    {
    	$member	=	$this->user_model->get($id);
    	if($main_account	=	$this->member_main_account_model->get_by(array('member_id' => $member->user_id)))
    	{
    		//print_r($main_account);
    		$member->balances_main_account	=	$main_account->balances;
    	}
    	else
    	{
    		if($main_account_id = $this->member_main_account_model->insert(array('member_id' => $member->user_id)))
    		{
    			$member->balances_main_account	=	0;
    		}
    	}
    	
        $this->data['user'] = $member;
        $this->load->view('member/row', $this->data);
    }
    
	/**
	 * @date	11.03.2011
	 */
	function do_action()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$id_list = $this->input->post('id');
			$action  = $this->input->post('action');
            
			if($action == 'delete') {
				$this->delete();
			}
			elseif($action == 'yes') {
                $this->user_model->update_many($id_list, array('active' => 'yes'));
			}
			elseif($action == 'no') {
				$this->user_model->update_many($id_list, array('active' => 'no'));
			}
			
			die('yes');
		}
	}
    
	/**
	 * @date	11.03.2011
	 */
    function change_status()
    {
		$id     = $this->input->post('user_id');
		$status = $this->input->post('status');
        
		$this->user_model->update_many($id, array('active' => $status));
		die('yes');
    }
}
