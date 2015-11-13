<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  Nguyen Xuan Hung
 * @email   hungnguyen@vietnambiz.com
 * @date    19.11.2010
 */

// Init all settings 2 main module : client and admin
function init_settings()
{
    global $CI;
    
    $module     = $CI->router->fetch_module();
    $controller = $CI->router->class;
    $method     = $CI->router->method;

    if($module == 'admin') {
        /*
        |--------------------------------------------------------------------------
        | Check permission in admin cp
        |--------------------------------------------------------------------------
        */
        if($controller == 'auth') return;
        
        if(!isset($_SESSION['_admin'])) {
            admin_redirect('login'); exit;
        }
        // NOT check in home controller, home alway allow
        elseif($controller != 'home') {
            
            $CI->load->model('admin/auth_model');
            $allow = $CI->auth_model->check_permission($controller, $method);
            
            if(!$allow) {
                $CI->message->add('error', 'Bạn không có quyền sử dụng chức năng này !');
                admin_redirect('home'); exit;
            }
        }
    }
}
