<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_location_mb extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_location_mb_model');
        $this->xs_location_mb_model->order_by('ordering', 'ASC');
        $this->xs_location_mb_model->order_by('id', 'DESC');
        $this->data['xs_location_mb'] = $this->xs_location_mb_model->get_many_by(array("status" => 1));
    }

    function index($page = 1) {
        $limit = 50;
        $offset = ($page - 1) * $limit;

        $rows = $this->db->select("id,name,lich,alias,code,ordering,status")->from("xs_location_mb")
                ->order_by("ordering", "ASC")
                ->limit($limit, $offset)
                ->get()
                ->result();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_location_mb")->get()->row()->cnt;
        $this->db->flush_cache();

        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index',
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'xs_location_mb/index';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL) {
        $row = $this->xs_location_mb_model->get($id);
        $re = FALSE;
        $submit = array();

        if ($row) {
            $submit['name'] = $row->name;
            $submit['alias'] = $row->alias;
            $submit['code'] = $row->code;
            $submit['lich'] = $row->lich;
//            $row->description = str_replace('<br/>', "", $row->description);
            $submit['description'] = $row->description;
            $submit['ordering'] = $row->ordering;
            $submit['status'] = $row->status;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($this->input->post('name'));
            $alias = trim($this->input->post('alias'));
            $code = trim($this->input->post('code'));
            $lich = trim($this->input->post('lich'));
            $description = trim($this->input->post('description'));
            $ordering = $this->input->post('ordering');
            $status = (int) $this->input->post('status');

            $submit['name'] = $name;
            $submit['alias'] = $alias;
            $submit['code'] = $code;
            $submit['lich'] = $lich;
            $submit['description'] = $description;
            $submit['ordering'] = $ordering;
            $submit['status'] = $status;

            $this->form_validation->set_rules('name', 'Tỉnh/TP', 'required');
            $this->form_validation->set_rules('code', 'Mã giải', 'required');

            if ($this->form_validation->run() == TRUE) {
//                $description = str_replace("\r\n", '<br/>', $description);
                if ($alias == '')
                    $alias = cleanName($name);
                $data = array(
                    'name' => $name,
                    'alias' => $alias,
                    'code' => $code,
                    'lich' => $lich,
                    'description' => $description,
                    'ordering' => $ordering,
                    'status' => $status,
                );

                if ($row) {
                    $this->db->where('alias', $alias);
                    $this->db->where('id <>', $id);
                    $this->db->from('xs_location_mb');
                    if ($this->db->count_all_results() == 0) {
                        $this->xs_location_mb_model->update($id, $data);
                        $re = TRUE;
                    } else {
                        $this->message->add('error', '<p>Trùng Alias</p>');
                    }
                } else {
                    $this->db->where('alias', $alias);
                    $this->db->from('xs_location_mb');
                    if ($this->db->count_all_results() == 0) {
                        $this->xs_location_mb_model->insert($data);
                        $re = TRUE;
                    } else {
                        $this->message->add('error', '<p>Trùng Alias</p>');
                    }
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            //delete cache
            $this->simple_cache->delete_item('client_data');
            redirect(admin_url($this->data['module']));
        }

        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = $this->data["module"] . "/edit";
        $this->load->view('layout/default', $this->data);
    }

    function status($id = null, $status = null) {
        if ($row = $this->xs_location_mb_model->get($id)) {
            if ($this->xs_location_mb_model->update($id, array("status" => $status))) {
                //delete cache
                $this->simple_cache->delete_item('client_data');
                admin_redirect($this->data["_request_index"]);
            }
        }
    }

//    function delete($id) {
//        if ($this->xs_location_mb_model->delete($id)) {
//            //delete cache
//            $this->simple_cache->delete_item('client_data');
//            redirect(admin_url($this->data['_request_index']));
//        }
//    }

}
