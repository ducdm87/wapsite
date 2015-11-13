<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_location extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_location_model');
        $this->xs_location_model->order_by('ordering', 'ASC');
        $this->xs_location_model->order_by('id', 'DESC');
        $this->data['xs_location'] = $this->xs_location_model->get_many_by(array("status" => 1));
    }

    function index($page = 1) {
        $limit = 50;
        $offset = ($page - 1) * $limit;

        $rows = $this->db->select("id,name,subdomain,id_tinh,code,area,time,ordering,status")->from("xs_location")
                ->order_by("ordering", "ASC")
                ->limit($limit, $offset)
                ->get()
                ->result();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_location")->get()->row()->cnt;
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
        $this->data['tpl_file'] = 'xs_location/index';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL) {
        $row = $this->xs_location_model->get($id);
        $re = FALSE;
        $submit = array();

        if ($row) {
            $submit['name'] = $row->name;
            $submit['subdomain'] = $row->subdomain;
            $submit['alias'] = $row->alias;
            $submit['code'] = $row->code;
            $submit['id_tinh'] = $row->id_tinh;
            $submit['area'] = $row->area;
            $submit['lich'] = $row->lich;
//            $row->description = str_replace('<br/>', "", $row->description);
            $submit['description'] = $row->description;
            $submit['thongke'] = $row->thongke;
            $submit['time'] = $row->time;
            $submit['ordering'] = $row->ordering;
            $submit['status'] = $row->status;
            $submit['lid_list'] = $row->lid_list;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($this->input->post('name'));
            $subdomain = trim($this->input->post('subdomain'));
            $alias = trim($this->input->post('alias'));
            $code = trim($this->input->post('code'));
            $id_tinh = trim($this->input->post('id_tinh'));
            $area = trim($this->input->post('area'));
            $lich = trim($this->input->post('lich'));
            $description = trim($this->input->post('description'));
            $thongke = trim($this->input->post('thongke'));
            $time = trim($this->input->post('time'));
            $ordering = $this->input->post('ordering');
            $status = (int) $this->input->post('status');
            $lid_list = $this->input->post('lid_list');
            $str_lid_list = implode(',', $lid_list);

            $submit['name'] = $name;
            $submit['subdomain'] = $subdomain;
            $submit['alias'] = $alias;
            $submit['code'] = $code;
            $submit['id_tinh'] = $id_tinh;
            $submit['area'] = $area;
            $submit['lich'] = $lich;
            $submit['description'] = $description;
            $submit['thongke'] = $thongke;
            $submit['time'] = $time;
            $submit['ordering'] = $ordering;
            $submit['status'] = $status;
            $submit['lid_list'] = $str_lid_list;

            $this->form_validation->set_rules('name', 'Tỉnh/TP', 'required');
            $this->form_validation->set_rules('code', 'Mã giải', 'required');

            if ($this->form_validation->run() == TRUE) {
//                $description = str_replace("\r\n", '<br/>', $description);
                if ($alias == '')
                    $alias = cleanName($name);
                $data = array(
                    'name' => $name,
                    'subdomain' => $subdomain,
                    'alias' => $alias,
                    'code' => $code,
                    'id_tinh' => $id_tinh,
                    'area' => $area,
                    'lich' => $lich,
                    'description' => $description,
                    'thongke' => $thongke,
                    'time' => $time,
                    'ordering' => $ordering,
                    'status' => $status,
                    'type' => 1,
                    'lid_list' => ',' . $str_lid_list . ',',
                );

                if ($row) {
                    $this->db->where('alias', $alias);
                    $this->db->where('id <>', $id);
                    $this->db->from('xs_location');
                    if ($this->db->count_all_results() == 0) {
                        $this->xs_location_model->update($id, $data);
                        $re = TRUE;
                    } else {
                        $this->message->add('error', '<p>Trùng Alias</p>');
                    }
                } else {
                    $this->db->where('alias', $alias);
                    $this->db->from('xs_location');
                    if ($this->db->count_all_results() == 0) {
                        $this->xs_location_model->insert($data);
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
        if ($row = $this->xs_location_model->get($id)) {
            if ($this->xs_location_model->update($id, array("status" => $status))) {
                //delete cache
                $this->simple_cache->delete_item('client_data');
                admin_redirect($this->data["_request_index"]);
            }
        }
    }

//    function delete($id) {
//        if ($this->xs_location_model->delete($id)) {
//            //delete cache
//            $this->simple_cache->delete_item('client_data');
//            redirect(admin_url($this->data['_request_index']));
//        }
//    }

}
