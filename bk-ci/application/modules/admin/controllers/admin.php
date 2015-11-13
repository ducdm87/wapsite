<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author  Nguyen Viet Manh
 * @email   manhnv85@gmail.com
 * @date    31.08.2011
 */
class admin extends CI_Controller {

    var $data = array();

    function __construct() {
        parent::__construct();
//        error_reporting(-1);
        
        $this->load->helper('cookie');
        $this->load->model(array('user_model', 'module_model', 'group_model'));
        //Load file language
        $this->lang->load('admin_text', 'vi');
        $this->lang->load('form_validation', 'vi');
        $this->load->helper(array('language', 'log'));
        $this->load->library(array("pagination", 'simple_cache'));

        if (!$_SESSION['user']) {
            if ($mid = get_cookie('__user')) {
                if ($user = $this->user_model->get_by_id_to_array($mid)) {
                    $_SESSION['user'] = $user;
                }
            }
        } else {
            //echo $_SESSION["user"]["username"];
            if (!$row = $this->db->select()->from("users u")->join("c_groups g", "g.id=u.group_id")->where(array("username" => $_SESSION["user"]["username"], "g.admin" => 1))->get()->row()) {
                echo "<script>alert('Bạn không có quyền truy cập.');location.href='" . base_url() . "';</script>";
            }

            $cur_time = time();

            $time_login = $_SESSION["user"]["time_login"];

            $limit_time_login = 1200;
            //echo "$cur_time-$time_login|";
            //echo $cur_time-$time_login."|";
            //die(round(($cur_time-$time_login)/(60)));

            if ((int) round(($cur_time - $time_login) / (60)) > (int) $limit_time_login) {
                admin_redirect('logout');
            } else {
                $_SESSION["user"]["time_login"] = time();
            }
            //echo $this->db->last_query();
        }

        if (!isset($_SESSION['user'])) {
            admin_redirect('login');
        }
        //Load file language

        if (!$this->_function_public()) {
            $per = $this->module_model->check_per_module();

            if (!$per) {
                echo "<script>alert('Bạn không có quyền truy cập vào module " . $this->router->class . "!');location.href='" . admin_url('home') . "';</script>";
                //admin_redirect('home');
            } else {
                $actions = $this->module_model->get_actions($this->router->class);
//                var_dump($actions);die;

                if ($_SESSION["user"]["group_id"] == 1) {
                    $this->data["SUPER_admin"] = TRUE;
                } else {
                    $this->data["SUPER_admin"] = FALSE;
                }

                if ($actions == 'all') {
                    $this->data['ADD_ACTION'] = TRUE;
                    $this->data['EDIT_ACTION'] = TRUE;
                    $this->data['DELETE_ACTION'] = TRUE;
                } else {
                    $actions = explode(',', $actions);
                    foreach ($actions as $k => $v) {
                        if ($v == 'edit') {
                            $this->data['EDIT_ACTION'] = TRUE;
                        }
                        if ($v == 'add') {
                            $this->data['ADD_ACTION'] = TRUE;
                        }
                        if ($v == 'delete') {
                            $this->data['DELETE_ACTION'] = TRUE;
                        }
                    }
                }
            }
        }



        $_admin = 0;
        if ($_SESSION["user"]["group_id"] == 1) {
            $_admin = 1;
        }

        $this->data["_admin"] = $_admin;

        $this->data['module'] = $this->router->class;
        $this->data['MODULE'] = strtoupper($this->router->class);
        $this->data['act'] = $this->router->class;
        $this->data['func'] = $this->router->method;
        $this->data['_request'] = strtolower($this->router->class . '/' . $this->router->method);
        $this->data["_request_index"] = strtolower($this->router->class . '/' . 'index');
        $this->data["_request_update"] = strtolower($this->router->class . '/' . 'update');
        $this->data["_request_delete"] = strtolower($this->router->class . '/' . 'delete');
        $this->data["_request_custom"] = strtolower($this->router->class . '/');
    }

    function set_custom($method) {
        $this->data["_request_custom"] = $this->data["_request_custom"] . strtolower($method);
    }

    private function _function_public() {
        $arr = array("user/change_pass");
        foreach ($arr as $k => $v) {
            $tmp = explode("/", $v);
            if ($this->router->class == $tmp[0] && $this->router->method == $tmp[1]) {
                return true;
            }
        }
        return false;
    }

    function index() {
        die('admin Default');
    }

}
