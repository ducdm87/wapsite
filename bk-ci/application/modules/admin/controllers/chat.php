<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class chat extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_loto_chat_model');
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if ($name = $this->input->get('name')) {
            $this->db->where("(b.username LIKE '%" . $name . "%' OR b.fullname LIKE '%" . $name . "%' OR b.email LIKE '%" . $name . "%')");
        }

        if (isset($_GET["status"]) && $_GET["status"] <> "")
            $this->db->where("b.active", $_GET["status"]);

        if (isset($_GET["start_date"]) && isset($_GET["end_date"]) && isset($_GET["date"]) && $_GET["date"] == 1) {
            $start_date = $_GET["start_date"];
            $end_date = $_GET["end_date"];
            $this->db->where("a.created >=", strtotime(str_replace('/', '-', $start_date . ' 00:00:00')));
            $this->db->where("a.created <=", strtotime(str_replace('/', '-', $end_date . ' 23:59:59')));
        }
        $this->db->where('a.receiver_id', 0);
        $this->db->stop_cache();

        $rows = $this->db->select("a.*,b.username,b.fullname,b.email")
                ->from("xs_loto_chat AS a")
                ->join("users AS b", "a.userid=b.id")
//                ->where('b.active', 'yes')
                ->order_by('a.created', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();

        $total_rows = $this->db->select("count(a.id) as cnt")
                        ->from("xs_loto_chat AS a")
                        ->join("users AS b", "a.userid=b.id")
                        ->get()->row()->cnt;
        $this->db->flush_cache();

        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index' . "?name=" . (isset($_GET['name']) ? '' . $_GET['name'] : '') . "&status=" . (isset($_GET["status"]) ? $_GET["status"] : "") . (isset($_GET["date"]) && $_GET["date"] == 1 ? '&date=' . $_GET["date"] . "&start_date=" . $_GET["start_date"] . "&end_date=" . $_GET["end_date"] : ''),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'chat/index';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id) {
        if ($this->xs_loto_chat_model->delete($id)) {
            redirect(admin_url($this->data['_request_index']));
        }
    }

    function edit($id = NULL) {
        $row = $this->xs_loto_chat_model->get($id);
        $submit = array();

        if ($row) {
            $submit['sms'] = $row->sms;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sms = trim($this->input->post('sms'));

            $submit['sms'] = $sms;
            $this->form_validation->set_rules('sms', 'Nội dung', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array('sms' => $sms);

                if ($row) {
                    $this->xs_loto_chat_model->update($id, $data);
                }
                die('yes');
            } else {
                die(validation_errors());
            }
        }

        $this->data['submitted'] = $submit;
        $this->load->view($this->data["module"] . "/edit", $this->data);
    }

}
