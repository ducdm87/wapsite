<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Module extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('group_module_model'));
        $this->data['modules'] = $this->module_model->get_many_by(array('pid' => 0));
    }

    function index() {
        $rows = $this->module_model->order_by('order', 'ASC')->order_by('id', 'DESC')->get_many_by(array('pid' => 0));
        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = 'module/index';
        $this->load->view('layout/default', $this->data);
    }

    function function_add($id = NULL) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('name', lang('FUNCTION_NAME'), 'required');
            $this->form_validation->set_rules('name_alias', lang('FUNCTION_NAME_ALIAS'), 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'name_alias' => $this->input->post('name_alias'),
                    'order' => $this->input->post('order'),
                    'pid' => $id
                );

                if ($this->module_model->insert($data)) {
                    redirect(admin_url($this->data['module']));
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        $this->data['tpl_file'] = 'module/add_function';
        $this->load->view('layout/default', $this->data);
    }

    function function_edit($id = NULL) {
        $row = $this->module_model->get_by(array('id' => $id));
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('name', lang('FUNCTION_NAME'), 'required');
            $this->form_validation->set_rules('name_alias', lang('FUNCTION_NAME_ALIAS'), 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'name_alias' => $this->input->post('name_alias'),
                    'order' => $this->input->post('order')
                );

                if ($this->module_model->update($id, $data)) {
                    redirect(admin_url($this->data['module']));
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        $this->data['row'] = $row;

        $this->data['tpl_file'] = 'module/function_edit';
        $this->load->view('layout/default', $this->data);
    }

    function function_delete($id = NULL) {
        $row = $this->module_model->get_by(array('id' => $id));
        if ($row) {
            if ($this->module_model->delete($id)) {
                redirect(admin_url($this->data['module']));
            }
        }
    }

    function edit($id = NULL) {
        $row = $this->module_model->get_by(array('id' => $id));
        $this->data['row'] = $row;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->form_validation->set_rules('name', lang('MODULE_NAME'), 'required');
            $this->form_validation->set_rules('name_alias', lang('MODULE_NAME_ALIAS'), 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'name_alias' => $this->input->post('name_alias'),
                    'order' => $this->input->post('order')
                );

                if ($this->module_model->update($id, $data)) {
                    redirect(admin_url($this->data['module']));
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        $this->data['tpl_file'] = 'module/edit';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->form_validation->set_rules('name', lang('MODULE_NAME'), 'required');
            $this->form_validation->set_rules('name_alias', lang('MODULE_NAME_ALIAS'), 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'name_alias' => $this->input->post('name_alias'),
                    'order' => $this->input->post('order')
                );

                if ($this->module_model->insert($data)) {
                    redirect(admin_url($this->data['module']));
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        $this->data['tpl_file'] = 'module/add';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        $this->function_delete($id);
    }

    function assign($group_id = NULL) {
        $rows = $this->module_model->order_by('order', 'ASC')->order_by('id', 'DESC')->get_many_by(array('pid' => 0));
        $this->data['rows'] = $rows;

        $rows_assign = $this->group_module_model->get_many_by(array('group_id' => $group_id));

        if (!$rows_assign && $group_id > 0) {
            foreach ($rows as $k => $v) {
                $this->group_module_model->insert(array("group_id" => $group_id, "module_id" => $v->id));
            }
        }
        $this->data['rows_assign'] = $rows_assign;

        if ($rows_assign) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $mids = $this->input->post('mid');
                //var_dump($mids);die;
                foreach ($mids as $k => $v) {
                    $actions = '';
                    if ($this->input->post('a_all_' . $v) == 'all') {
                        $actions = "all";
                    } else {
                        $actions .=($this->input->post('a_add_' . $v) ? $this->input->post('a_add_' . $v) . ',' : '') . ($this->input->post('a_edit_' . $v) ? $this->input->post('a_edit_' . $v) . ',' : '') . ($this->input->post('a_delete_' . $v) ? $this->input->post('a_delete_' . $v) : '');
                    }

                    if ($this->module_model->check_by_group_module($group_id, $v)) {
                        $this->group_module_model->edit(array('group_id' => $group_id, 'module_id' => $v), array('actions' => $actions));
                        //die('++');
                    } else {
                        $this->group_module_model->insert(array('group_id' => $group_id, 'module_id' => $v, 'actions' => $actions));
                    }

                    //Functions
                    $fids = $this->input->post("fids_" . $v);
                    //var_dump($fids);
                    $ig = '';
                    if ($fids)
                        foreach ($fids as $k1 => $v1) {
                            if ($row = $this->module_model->get($v1)) {
                                if ($row->pid > 0) {
                                    if ($r = $this->group_module_model->get_by(array("group_id" => $group_id, "module_id" => $row->pid))) {
                                        //$ig = $r->ignore_actions;
                                        $ig.=$v1 . ",";
                                        //var_dump($ig);
                                        //if(!$this->check_ig_func($row->pid, $v, $group_id))
                                    }
                                }
                            }
                        }
                    $this->group_module_model->update_by(array("module_id" => $v, "group_id" => $group_id), array("ignore_actions" => $ig));
                    //End functions
                }//End foreach($mids)
                //var_dump($fids);
            }
        }

        $this->data['group_id'] = $group_id;
        $this->data['tpl_file'] = 'module/assign';
        $this->load->view('layout/default', $this->data);
    }

    function check_ig_func($mid = NULL, $fid = NULL, $group_id = NULL) {
        $ok = false;
        if ($row = $this->module_model->get($fid)) {
            if ($r = $this->group_module_model->get_by(array("group_id" => $group_id, "module_id" => $mid))) {
                $tmp = explode(",", $r->ignore_actions);
                foreach ($tmp as $k => $v) {
                    if ($fid == $v) {
                        $ok = true;
                        break;
                    }
                }
            }
        }
        return $ok;
    }

}
