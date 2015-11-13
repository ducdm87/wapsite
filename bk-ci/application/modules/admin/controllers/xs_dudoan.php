<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_dudoan extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_dudoan_model', 'xs_location_model'));
        $this->xs_location_model->order_by('ordering', 'ASC');
        $this->xs_location_model->order_by('id', 'DESC');
        $this->data['xs_location'] = $this->xs_location_model->get_many_by(array("status" => 1));
        $this->load->helper(array('upload'));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if ($title = $this->input->get('title')) {
            $this->db->like("title", $title);
        }
        if (isset($_GET["lid"]) && $_GET["lid"] != "") {
            $this->db->where("lid", $_GET["lid"]);
        }
        if (isset($_GET["start_date"]) && isset($_GET["end_date"]) && isset($_GET["date"]) && $_GET["date"] == 1) {
            $start_date = $_GET["start_date"];
            $end_date = $_GET["end_date"];
            $start_date = convert_from_vn_date_to_mysql_date($start_date);
            $end_date = convert_from_vn_date_to_mysql_date($end_date);
            $this->db->where("DATE(date) >=", $start_date);
            $this->db->where("DATE(date) <=", $end_date);
        }
        $this->db->stop_cache();

        $rows = $this->db->select("id,title,title_link,lid,order,date,active")->from("xs_dudoan")
//                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_dudoan")->get()->row()->cnt;
        $this->db->flush_cache();

        foreach ($rows as $k => $row) {
            $cat = $this->xs_location_model->get($row->lid);
            if ($cat) {
                $rows[$k]->lname = $cat->name;
                $rows[$k]->lalias = '';
                if ($cat->area == 'MB')
                    $rows[$k]->lalias = 'du-doan-xo-so-mien-bac';
                elseif ($cat->area == 'MT')
                    $rows[$k]->lalias = 'du-doan-xo-so-mien-trung';
                elseif ($cat->area == 'MN')
                    $rows[$k]->lalias = 'du-doan-xo-so-mien-nam';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
            //var_dump($ids);
            //var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->xs_dudoan_model->update($id, array("order" => $orders[$k]));
            }

            admin_redirect($this->data['module']);
        }

        $conf = array(
            'base_url' => admin_url($this->router->class)
            . '/index?x=1'
            . (isset($_GET["title"]) ? "&title=" . $_GET["title"] : "")
            . (isset($_GET["lid"]) ? "&lid=" . $_GET["lid"] : "")
            . (isset($_GET["date"]) ? "&date=" . $_GET["date"] : "")
            . (isset($_GET["start_date"]) ? "&start_date=" . $_GET["start_date"] : "")
            . (isset($_GET["end_date"]) ? "&end_date=" . $_GET["end_date"] : ""),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'xs_dudoan/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $lid = $this->input->post('lid');
            $date = $this->input->post('date');
            $title = trim($this->input->post('title'));
            $title_link = cleanName($title);
            $short_desc = $this->input->post('short_desc');
            $content = $this->input->post('content');
            $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
            $meta_keywords = trim($this->input->post('meta_keywords'));
            $meta_description = trim($this->input->post('meta_description'));
            $tags = trim($this->input->post('tags'));

            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

            $submit['lid'] = $lid;
            $submit['date'] = $date;
            $submit['title'] = $title;
            $submit['short_desc'] = $short_desc;
            $submit['content'] = $content;
            $submit['active'] = $active;
            $submit['meta_keywords'] = $meta_keywords;
            $submit['meta_description'] = $meta_description;
            $submit['tags'] = $tags;

            $this->form_validation->set_rules('lid', 'Tỉnh/TP', 'required');
            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'lid' => $lid,
                    'date' => $date,
                    'title' => $title,
                    'title_link' => $title_link,
                    'short_desc' => $short_desc,
                    'content' => $content,
                    'active' => $active,
                    'created_date' => date('Y-m-d H:i:s'),
                    'meta_keywords' => $meta_keywords,
                    'meta_description' => $meta_description,
                    'tags' => $tags,
                );

                if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                    // Upload images
                    $album_dir = "uploads/dudoan/";
                    if (!is_dir($album_dir)) {
                        create_dir($album_dir);
                    }

                    $ext = get_ext($_FILES["image"]["name"]);
                    if (!in_array($ext, array('png', 'gif', 'jpg', 'jpeg'))) {
                        continue;
                    }

                    if ($_FILES['image']['error'] === 0) {
                        $new_path = $album_dir . $_FILES["image"]["name"];
                        move_uploaded_file($_FILES["image"]['tmp_name'], dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $new_path);
                        $sizes = config_item('thumb_img_article');
                        $data['image'] = createThumb($new_path, $sizes);
                    }
                }//End select image

                if ($this->xs_dudoan_model->get_by(array('title_link' => $title_link))) {
                    $data['title_link'] = $title_link . '-' . time();
                }
                if ($this->xs_dudoan_model->insert($data)) {
                    $re = TRUE;
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            redirect(admin_url($this->data['module']));
        }
        
        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = 'xs_dudoan/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->xs_dudoan_model->get($id);
        $MODULE = $this->data['MODULE'];
        $submit = array();
        if ($row) {
            $submit['lid'] = $row->lid;
            $submit['date'] = $row->date;
            $submit['title'] = $row->title;
            $submit['title_link'] = $row->title_link;
            $submit['short_desc'] = $row->short_desc;
            $submit['content'] = $row->content;
            $submit['active'] = $row->active;
            $submit['image'] = $row->image;
            $submit['meta_keywords'] = $row->meta_keywords;
            $submit['meta_description'] = $row->meta_description;
            $submit['tags'] = $row->tags;

            if ($action == 'yes' || $action == 'no') {
                $this->xs_dudoan_model->update($id, array('active' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $lid = $this->input->post('lid');
                    $date = $this->input->post('date');
                    $title = $this->input->post('title');
                    $title_link = cleanName($title);
                    $short_desc = $this->input->post('short_desc');
                    $content = $this->input->post('content');
                    $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
                    $meta_keywords = trim($this->input->post('meta_keywords'));
                    $meta_description = trim($this->input->post('meta_description'));
                    $tags = trim($this->input->post('tags'));

                    $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

                    $submit['lid'] = $lid;
                    $submit['date'] = $date;
                    $submit['title'] = $title;
                    $submit['title_link'] = $title_link;
                    $submit['short_desc'] = $short_desc;
                    $submit['content'] = $content;
                    $submit['active'] = $active;
                    $submit['meta_keywords'] = $meta_keywords;
                    $submit['meta_description'] = $meta_description;
                    $submit['tags'] = $tags;

                    $this->form_validation->set_rules('lid', 'Tỉnh/TP', 'required');
                    $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
                    $this->form_validation->set_rules('content', 'Nội dung', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'lid' => $lid,
                            'date' => $date,
                            'title' => $title,
                            'title_link' => $title_link,
                            'short_desc' => $short_desc,
                            'content' => $content,
                            'active' => $active,
                            'meta_keywords' => $meta_keywords,
                            'meta_description' => $meta_description,
                            'tags' => $tags,
                        );

                        if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                            // Upload images
                            $album_dir = "uploads/dudoan/";
                            if (!is_dir($album_dir)) {
                                create_dir($album_dir);
                            }

                            $ext = get_ext($_FILES["image"]["name"]);
                            if (!in_array($ext, array('png', 'gif', 'jpg', 'jpeg'))) {
                                continue;
                            }

                            if ($_FILES['image']['error'] === 0) {
                                $new_path = $album_dir . $_FILES["image"]["name"];
                                move_uploaded_file($_FILES["image"]['tmp_name'], dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $new_path);
                                $sizes = config_item('thumb_img_article');
                                $data['image'] = createThumb($new_path, $sizes);
                            }
                        }//End select image

                        if ($this->xs_dudoan_model->get_by(array('id <>' => $id, 'title_link' => $title_link))) {
                            $data['title_link'] = $title_link . '-' . time();
                        }
                        if ($this->xs_dudoan_model->update($id, $data)) {
                            $re = TRUE;
                        }
                    } else {
                        $this->message->add('error', validation_errors());
                    }
                }
            }
        }

        if ($re == true) {
            redirect(admin_url($this->data['module'] . '/index'));
        }

        $this->data['row'] = $row;
        $this->data['submitted'] = $submit;

        $this->data['tpl_file'] = 'xs_dudoan/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_dudoan_model->get($id)) {
            if ($this->xs_dudoan_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
