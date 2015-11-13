<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class help extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('help_model', 'help_category_model'));
        $this->data['cats_tree'] = $this->help_category_model->get_cat_trees_name();
        $this->load->helper(array('upload'));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $catids = array();
        if (isset($_GET["catid"]) && $_GET["catid"] != "") {
            $tmp = $this->help_category_model->get_many_by(array('pid' => $_GET["catid"]));
            $catids[] = $_GET["catid"];
            foreach ($tmp as $k => $v) {
                $catids[] = $v->id;
            }
        }

        $this->db->start_cache();
        if ($catids) {
            $this->db->where_in("catid", $catids);
        }
        $this->db->stop_cache();

        $rows = $this->db->select("id,title,title_link,catid,order,created_date,active,is_resize")->from("help")
                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("help")->get()->row()->cnt;
        $this->db->flush_cache();

        foreach ($rows as $k => $row) {
            $cat = $this->help_category_model->get($row->catid);
            if ($cat) {
                $rows[$k]->cat_name = $cat->name;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
            //var_dump($ids);
            //var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->help_model->update($id, array("order" => $orders[$k]));
            }

            admin_redirect($this->data['module']);
        }

        $conf = array(
            'base_url' => admin_url($this->router->class)
            . '/index?x=1'
            . (isset($_GET["catid"]) ? "&catid=" . $_GET["catid"] : ""),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'help/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];
        $submit['author'] = $_SESSION['_admin']['username'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $title = trim($this->input->post('title'));
            $title_link = cleanName($title);
            $catid = $this->input->post('catid');
            $short_desc = $this->input->post('short_desc');
            $content = $this->input->post('content');
            $source = $this->input->post('source');
            $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
            $author = $this->input->post('author');
//            $title_link_old1 = $this->input->post('title_link_old1');
//            $title_link_old2 = $this->input->post('title_link_old2');
//            $title_link_old3 = $this->input->post('title_link_old3');
//            $title_link_old4 = $this->input->post('title_link_old4');
            $meta_keywords = trim($this->input->post('meta_keywords'));
            $meta_description = trim($this->input->post('meta_description'));
            $tags = trim($this->input->post('tags'));

            $submit['title'] = $title;
            $submit['short_desc'] = $short_desc;
            $submit['content'] = $content;
            $submit['active'] = $active;
            $submit['author'] = $author;
            $submit['source'] = $source;
//            $submit['catid'] = $catid;
//            $submit['title_link_old1'] = $title_link_old1;
//            $submit['title_link_old2'] = $title_link_old2;
//            $submit['title_link_old3'] = $title_link_old3;
//            $submit['title_link_old4'] = $title_link_old4;
            $submit['meta_keywords'] = $meta_keywords;
            $submit['meta_description'] = $meta_description;
            $submit['tags'] = $tags;

            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('short_desc', 'Mô tả ngắn', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');

            if ($this->form_validation->run() == TRUE) {
//                $title_link_old = '';
//                if ($title_link_old1 > 0)
//                    $title_link_old .= $title_link_old1 . ',';
//                if ($title_link_old2 > 0)
//                    $title_link_old .= $title_link_old2 . ',';
//                if ($title_link_old3 > 0)
//                    $title_link_old .= $title_link_old3 . ',';
//                if ($title_link_old4 > 0)
//                    $title_link_old .= $title_link_old4 . ',';

                $data = array(
                    'title' => $title,
                    'title_link' => $title_link,
//                    'title_link_old' => ',' . $title_link_old,
                    'short_desc' => $short_desc,
                    'content' => $content,
                    'active' => $active,
                    'created_date' => date('Y-m-d H:i:s'),
                    'source' => $source,
                    'author' => $author,
                    'meta_keywords' => $meta_keywords,
                    'meta_description' => $meta_description,
                    'tags' => $tags,
                    'catid' => $catid,
                    'is_resize' => ($this->input->post('is_resize') == 1 ? 1 : 0)
                );

                if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                    // Upload images
                    $album_dir = "uploads/help/";
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

                if ($this->help_model->get_by(array('title_link' => $title_link))) {
                    $data['title_link'] = $title_link . '-' . time();
                }
                if ($this->help_model->insert($data)) {
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
        $this->data['tpl_file'] = 'help/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->help_model->get($id);
        $MODULE = $this->data['MODULE'];
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['title_link'] = $row->title_link;
//            $submit['title_link_old'] = $row->title_link_old;
            $submit['short_desc'] = $row->short_desc;
            $submit['content'] = $row->content;
            $submit['active'] = $row->active;
            $submit['image'] = $row->image;
            $submit['source'] = $row->source;
            $submit['catid'] = $row->catid;
            $submit['is_resize'] = $row->is_resize;
            $submit['meta_keywords'] = $row->meta_keywords;
            $submit['meta_description'] = $row->meta_description;
            $submit['tags'] = $row->tags;

//            $submit['title_link_old1'] = '';
//            $submit['title_link_old2'] = '';
//            $submit['title_link_old3'] = '';
//            $submit['title_link_old4'] = '';
//            if ($row->title_link_old != '') {
//                $arr_type = explode(',', $row->title_link_old);
//                if (in_array(1, $arr_type))
//                    $submit['title_link_old1'] = 1;
//                if (in_array(2, $arr_type))
//                    $submit['title_link_old2'] = 2;
//                if (in_array(3, $arr_type))
//                    $submit['title_link_old3'] = 3;
//                if (in_array(4, $arr_type))
//                    $submit['title_link_old4'] = 4;
//            }


            if ($action == 'yes' || $action == 'no') {
                $this->help_model->update($id, array('active' => $action));
                $re = true;
            } else {

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = $this->input->post('title');
                    $title_link = cleanName($title);
//                    $title_link_old = $this->input->post('title_link_old');
                    $catid = $this->input->post('catid');
                    $short_desc = $this->input->post('short_desc');
                    $content = $this->input->post('content');
                    $source = $this->input->post('source');
                    $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
                    $auhor = $this->input->post('author');
//                    $title_link_old1 = $this->input->post('title_link_old1');
//                    $title_link_old2 = $this->input->post('title_link_old2');
//                    $title_link_old3 = $this->input->post('title_link_old3');
//                    $title_link_old4 = $this->input->post('title_link_old4');
                    $meta_keywords = trim($this->input->post('meta_keywords'));
                    $meta_description = trim($this->input->post('meta_description'));
                    $tags = trim($this->input->post('tags'));

                    $submit['title'] = $title;
//                    $submit['title_link_old'] = $title_link_old;
                    $submit['title_link'] = $title_link;
                    $submit['short_desc'] = $short_desc;
                    $submit['content'] = $content;
                    $submit['active'] = $active;
                    $submit['catid'] = $catid;
                    $submit['source'] = $source;
//                    $submit['title_link_old1'] = $title_link_old1;
//                    $submit['title_link_old2'] = $title_link_old2;
//                    $submit['title_link_old3'] = $title_link_old3;
//                    $submit['title_link_old4'] = $title_link_old4;
                    $submit['meta_keywords'] = $meta_keywords;
                    $submit['meta_description'] = $meta_description;
                    $submit['tags'] = $tags;

                    $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
                    $this->form_validation->set_rules('short_desc', 'Mô tả ngắn', 'required');
                    $this->form_validation->set_rules('content', 'Nội dung', 'required');

                    if ($this->form_validation->run() == TRUE) {
//                        $title_link_old = '';
//                        if ($title_link_old1 > 0)
//                            $title_link_old .= $title_link_old1 . ',';
//                        if ($title_link_old2 > 0)
//                            $title_link_old .= $title_link_old2 . ',';
//                        if ($title_link_old3 > 0)
//                            $title_link_old .= $title_link_old3 . ',';
//                        if ($title_link_old4 > 0)
//                            $title_link_old .= $title_link_old4 . ',';

                        $data = array(
                            'title' => $title,
                            'title_link' => $title_link,
//                            'title_link_old' => ',' . $title_link_old,
                            'short_desc' => $short_desc,
                            'content' => $content,
                            'active' => $active,
                            //'created_date'	=>	date('Y-m-d H:i:s'),
                            'source' => $source,
                            'author' => $auhor,
                            'catid' => $catid,
                            'meta_keywords' => $meta_keywords,
                            'meta_description' => $meta_description,
                            'tags' => $tags,
                            'is_resize' => ($this->input->post('is_resize') == 1 ? 1 : 0)
                        );

                        if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                            // Upload images
                            $album_dir = "uploads/help/";
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

                        if ($this->help_model->get_by(array('id <>' => $id, 'title_link' => $title_link))) {
                            $data['title_link'] = $title_link . '-' . time();
                        }
                        if ($this->help_model->update($id, $data)) {
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

        $this->data['tpl_file'] = 'help/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->help_model->get($id)) {
            if ($this->help_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

    function resize($id = NULL, $type = 1) {
        if ($row = $this->help_model->get($id)) {
            if ($this->help_model->update($id, array("is_resize" => $type))) {
                admin_redirect($this->data['module']);
            }
        }
    }

    function category_index() {
        $rows = $this->help_category_model->get_cat_trees();
        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = 'help/category_index';
        $this->load->view('layout/default', $this->data);
    }

    function category_add() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $this->input->post('name');
            $name_link = cleanName($name);
            $pid = $this->input->post('pid');
            $data = array(
                'name' => $name,
                'name_link' => $name_link,
                'order' => $this->input->post('order'),
                'active' => ($this->input->post('active') == 'yes' ? 'yes' : 'no'),
                'pid' => $pid
            );

            if ($this->help_category_model->insert($data)) {
                $re = true;
            }
        }

        if ($re == true) {
            //delete cache
            $this->simple_cache->delete_item('client_data');
            redirect(admin_url($this->data['module'] . '/category_index'));
        }

        $this->data['tpl_file'] = 'help/category_add';
        $this->load->view('layout/default', $this->data);
    }

    function category_edit($id = NULL, $action = '') {
        $re = false;
        $row = $this->help_category_model->get($id);
        if ($row) {
            if ($action == 'yes' || $action == 'no') {
                $this->help_category_model->update($id, array('active' => $action));
                $re = true;
            } else {

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $this->input->post('name');
                    $name_link = cleanName($name);
                    $pid = $this->input->post('pid');
                    $data = array(
                        'name' => $name,
                        'name_link' => $name_link,
                        'order' => $this->input->post('order'),
                        'active' => ($this->input->post('active') == 'yes' ? 'yes' : 'no'),
                        'pid' => $pid
                    );

                    if ($this->help_category_model->update($id, $data)) {
                        $re = true;
                    }
                }
            }
        }

        if ($re == true) {
            //delete cache
            $this->simple_cache->delete_item('client_data');
            redirect(admin_url($this->data['module'] . '/category_index'));
        }

        $this->data['row'] = $row;

        $this->data['tpl_file'] = 'help/category_edit';
        $this->load->view('layout/default', $this->data);
    }

    function category_delete($id = NULL) {
        $row = $this->help_category_model->get($id);
        if ($row) {
            if ($this->help_category_model->delete($id)) {
                //delete cache
                $this->simple_cache->delete_item('client_data');
                redirect(admin_url($this->data['module'] . '/category_index'));
            }
        }
    }

}
