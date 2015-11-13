<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_tttt extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_result_model');
    }

    function index() {
        
    }

    function mb() {
        $area = 0;
        $date = date('Y-m-d');
        $row = $this->xs_result_model->read_xml_home($area, $date, 0);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = $this->input->post('db');
            $g1 = $this->input->post('g1');
            $g2 = $this->input->post('g2');
            $g3 = $this->input->post('g3');
            $g4 = $this->input->post('g4');
            $g5 = $this->input->post('g5');
            $g6 = $this->input->post('g6');
            $g7 = $this->input->post('g7');

            $data = array();
            $data_b = array();
            $arr_loto = array();

            $data[0] = $db;
            $data[1] = $g1;
            $data[2] = implode('-', $g2);
            $data[3] = implode('-', $g3);
            $data[4] = implode('-', $g4);
            $data[5] = implode('-', $g5);
            $data[6] = implode('-', $g6);
            $data[7] = implode('-', $g7);

            $sub = substr($db, -2, 2);
            $arr_loto[] = $sub;
            $data_b[0] = $sub;

            $sub = substr($g1, -2, 2);
            $arr_loto[] = $sub;
            $data_b[1] = $sub;

            foreach ($g2 as $so) {
                $sub = substr($so, -2, 2);
                $arr_loto[] = $sub;

                if (!isset($data_b[2]))
                    $data_b[2] = $sub;
                else
                    $data_b[2] .= ',' . $sub;
            }

            foreach ($g3 as $so) {
                $sub = substr($so, -2, 2);
                $arr_loto[] = $sub;

                if (!isset($data_b[3]))
                    $data_b[3] = $sub;
                else
                    $data_b[3] .= ',' . $sub;
            }

            foreach ($g4 as $so) {
                $sub = substr($so, -2, 2);
                $arr_loto[] = $sub;

                if (!isset($data_b[4]))
                    $data_b[4] = $sub;
                else
                    $data_b[4] .= ',' . $sub;
            }

            foreach ($g5 as $so) {
                $sub = substr($so, -2, 2);
                $arr_loto[] = $sub;

                if (!isset($data_b[5]))
                    $data_b[5] = $sub;
                else
                    $data_b[5] .= ',' . $sub;
            }

            foreach ($g6 as $so) {
                $sub = substr($so, -2, 2);
                $arr_loto[] = $sub;

                if (!isset($data_b[6]))
                    $data_b[6] = $sub;
                else
                    $data_b[6] .= ',' . $sub;
            }

            foreach ($g7 as $so) {
                $sub = substr($so, -2, 2);
                $arr_loto[] = $sub;

                if (!isset($data_b[7]))
                    $data_b[7] = $sub;
                else
                    $data_b[7] .= ',' . $sub;
            }

            $data[8] = '';
            $data_b[8] = '';
            $row->cache->data->MB->data = $data;
            $row->cache->data->MB->data_b = $data_b;
            $row->cache->data->MB->extra = $this->xs_result_model->getExtra($arr_loto);
            
            $row->cache->data->MB = get_object_vars($row->cache->data->MB);
            $result = get_object_vars($row->cache->data);
            
            $_tmp = array();
            $_tmp['area'] = $area;
            $_tmp['data'] = $result;
            $this->xs_result_model->update_xml($area, $date, $_tmp, 0);

            redirect(admin_url($this->data['module'] . '/mb?msg=Cap nhat thanh cong'));
        }

        if (isset($_GET['msg']))
            echo '<script>alert(\'' . $_GET['msg'] . '\');</script>';

        $this->data['row'] = $row;
        $this->data['tpl_file'] = 'xs_tttt/mb';
        $this->load->view('layout/default', $this->data);
    }

    function mt() {
        $this->data['tpl_file'] = 'xs_tttt/mt_mn';
        $this->load->view('layout/default', $this->data);
    }

    function mn() {
        $this->data['tpl_file'] = 'xs_tttt/mt_mn';
        $this->load->view('layout/default', $this->data);
    }

}

?>
