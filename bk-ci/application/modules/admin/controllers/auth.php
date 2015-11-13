<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  Nguyen Xuan Hung
 * @email   hungnguyen@vietnambiz.com
 * @date    19.11.2010
 */

class Auth extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    
    function login()
    {
        // loged in
        if(isset($_SESSION['_admin'])) {
            admin_redirect('home');exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user   = trim($this->input->post('username'));
            $pass   = ($this->input->post('password'));
            $re_pass	=	$this->input->post('re_pass');
            
            $result = $this->user_model->login($user, $pass, $re_pass, true);
            //print_r($result);echo "addsasds";
            
            if(!$result) {
                $this->message->add('error', 'Tên đăng nhập hoặc mật khẩu không chính xác !');
            }
            else {
                admin_redirect('home');exit;
            }
        }
        
        $d_view['tpl_file'] = 'auth/login';
        $this->load->view('auth/login', $d_view);
    }
    
    function logout()
    {
        $this->user_model->logout();
        admin_redirect('login');
    }
}
