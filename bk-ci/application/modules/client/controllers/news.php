<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'client' . EXT;

class news extends Client {

    function __construct() {
        parent::__construct();
        $this->load->model(array('news_model', 'xs_redirectlinks_model', 'help_model'));
        $this->load->library('pagination');
    }

    public function index($category_alias = '', $page = 1) {
//        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $url = base_url() . 'tin-xo-so.html';
        $url_alias = base_url() . 'tin-xo-so';

        $this->db->start_cache();
        if ($category_alias != '') {
            $this->db->where("c.name_link", $category_alias);
            $url = base_url() . 'tin-xo-so/danh-muc-' . $category_alias . '.html';
            $url_alias = base_url() . 'tin-xo-so/danh-muc-' . $category_alias;
        }
        $this->db->where("n.active", "yes");
        $this->db->stop_cache();

        $rows = $this->db->select("n.*,c.name AS cname")->from("c_news AS n")
                ->join('c_news_categories AS c', 'n.catid = c.id', 'left')
                ->order_by("n.order", "ASC")
                ->order_by("n.id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();

        $total_rows = $this->db->select("count(n.id) as cnt")->from("c_news AS n")->join('c_news_categories AS c', 'n.catid = c.id', 'left')->get()->row()->cnt;
        $this->db->flush_cache();
//            echo $this->db->last_query();

        $this->data['news'] = $rows;

        $conf = array(
            'cur_page' => $page,
            'base_url' => $url,
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_class' => 'currentpage',
            'prev_class' => 'prevnext',
            'next_class' => 'prevnext',
            'first_link' => 'Trang đầu',
            'last_link' => 'Trang cuối',
            'next_link' => '&gt;&gt;',
            'prev_link' => '&lt;&lt;',
            'show_total' => 'no',
            'show_first_last' => 'yes'
        );

        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_ul_li_router($url_alias);

        $this->data['_meta'] = $this->meta_model->show_title('news');

        $this->data['category_alias'] = $category_alias;
        $this->data['tmpl'] = 'news/index';
        $this->load->view('default', $this->data);
    }

    public function help($category_alias = '', $page = 1) {
//        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $url = base_url() . 'tro-giup.html';
        $url_alias = base_url() . 'tro-giup';

        $this->db->start_cache();
        if ($category_alias != '') {
            $this->db->where("c.name_link", $category_alias);
            $url = base_url() . 'tro-giup/danh-muc-' . $category_alias . '.html';
            $url_alias = base_url() . 'tro-giup/danh-muc-' . $category_alias;
        }
        $this->db->where("n.active", "yes");
        $this->db->stop_cache();

        $rows = $this->db->select("n.*,c.name AS cname")->from("help AS n")
                ->join('help_categories AS c', 'n.catid = c.id', 'left')
                ->order_by("n.order", "ASC")
                ->order_by("n.id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();

        $total_rows = $this->db->select("count(n.id) as cnt")->from("help AS n")->join('help_categories AS c', 'n.catid = c.id', 'left')->get()->row()->cnt;
        $this->db->flush_cache();
//            echo $this->db->last_query();

        $this->data['help'] = $rows;

        $conf = array(
            'cur_page' => $page,
            'base_url' => $url,
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_class' => 'currentpage',
            'prev_class' => 'prevnext',
            'next_class' => 'prevnext',
            'first_link' => 'Trang đầu',
            'last_link' => 'Trang cuối',
            'next_link' => '&gt;&gt;',
            'prev_link' => '&lt;&lt;',
            'show_total' => 'no',
            'show_first_last' => 'yes'
        );

        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_ul_li_router($url_alias);

        $this->data['_meta'] = $this->meta_model->show_title('help');

        $this->data['category_alias'] = $category_alias;
        $this->data['tmpl'] = 'news/help';
        $this->load->view('default', $this->data);
    }

    function detail($category_alias = '', $title_link = '') {
        $xs_redirectlinks = $this->xs_redirectlinks_model->get_by(array('md5_link' => md5($title_link . '.html'), 'published' => 1));
        if ($xs_redirectlinks) {
            redirect($this->data['uri_root'] . 'tin-xo-so/' . $xs_redirectlinks->rlink);
        }
        $row_news = $this->news_model->get_by(array('title_link' => $title_link, 'active' => 'yes'));

        if ($row_news) {
            $data = array('view' => $row_news->view + 1);
            $this->news_model->update($row_news->id, $data);

            $row_news->title = trim($row_news->title);
            $row_news->content = trim($row_news->content);
            $this->data['row_news'] = $row_news;

            $category = null;
            if ($category_alias != '') {
                $this->load->model('news_category_model');
                $category = $this->news_category_model->get($row_news->catid);
                $this->data['related_news'] = $this->news_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('catid' => $category->id, 'active' => 'yes', 'created_date <=' => $row_news->created_date, 'id <>' => $row_news->id));
                $this->data['new_news'] = $this->news_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('catid' => $category->id, 'active' => 'yes', 'id <>' => $row_news->id));
            } else {
                $this->data['related_news'] = $this->news_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('active' => 'yes', 'created_date <=' => $row_news->created_date, 'id <>' => $row_news->id));
                $this->data['new_news'] = $this->news_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('active' => 'yes', 'id <>' => $row_news->id));
            }

            $search = array('[TITLE]', '[CONTENT]', '[KEYWORD]');

            $description = '';
            $keywords = '';

            if ($row_news->meta_description != '')
                $description = $row_news->meta_description;
            else
                $description = trim(short_text(view_title(strip_tags($row_news->content)), 170));

            if ($row_news->meta_keywords != '')
                $keywords = $row_news->meta_keywords;
            else
                $keywords = 'tin xo so, thong tin so xo, tin xa hoi, tin tuc, tin kinh te';

            $replace = array($row_news->title, $description, $keywords);
            $this->data['_meta'] = $this->meta_model->show_title('news_detail', $search, $replace);

            $pattern = '/(<a .*?<\/a>)/i';
            //ma hoa link
            if (preg_match_all($pattern, $row_news->short_desc, $tmp)) {
                foreach ($tmp[0] as $value) {
                    $row_news->short_desc = str_replace($value, '[BEGIN_BHM_BASECODE]' . base64_encode($value) . '[END_BHM_BASECODE]', $row_news->short_desc);
                }
            }
            if (preg_match_all($pattern, $row_news->content, $tmp)) {
                foreach ($tmp[0] as $value) {
                    $row_news->content = str_replace($value, '[BEGIN_BHM_BASECODE]' . base64_encode($value) . '[END_BHM_BASECODE]', $row_news->content);
                }
            }

            $replacement = '<a target="_blank" title="Xo So - kết quả xổ số trực tiếp ba miền bắc, trung, nam" href="' . $this->data['uri_root'] . '">$1</a>';
            $row_news->short_desc = preg_replace('/(xổ số)/i', $replacement, $row_news->short_desc);
            $row_news->content = preg_replace('/(xổ số)/i', $replacement, $row_news->content);

            //giai ma link
            if (preg_match_all('/\[BEGIN_BHM_BASECODE\](.*?)\[END_BHM_BASECODE\]/i', $row_news->short_desc, $tmp)) {
                foreach ($tmp[1] as $value) {
                    $row_news->short_desc = str_replace('[BEGIN_BHM_BASECODE]' . $value . '[END_BHM_BASECODE]', base64_decode($value), $row_news->short_desc);
                }
            }
            if (preg_match_all('/\[BEGIN_BHM_BASECODE\](.*?)\[END_BHM_BASECODE\]/i', $row_news->content, $tmp)) {
                foreach ($tmp[1] as $value) {
                    $row_news->content = str_replace('[BEGIN_BHM_BASECODE]' . $value . '[END_BHM_BASECODE]', base64_decode($value), $row_news->content);
                }
            }
        } else {
            redirect($this->data['uri_root'] . '404_override');
        }
        $this->data['category'] = $category;
        $this->data['tmpl'] = 'news/detail';
        $this->load->view('default', $this->data);
    }

    public function helpdetail($category_alias = '', $title_link = '') {
        $row_news = $this->help_model->get_by(array('title_link' => $title_link, 'active' => 'yes'));

        if ($row_news) {
            $data = array('view' => $row_news->view + 1);
            $this->help_model->update($row_news->id, $data);

            $row_news->title = trim($row_news->title);
            $row_news->content = trim($row_news->content);
            $this->data['row_news'] = $row_news;

            $category = null;
            if ($category_alias != '') {
                $this->load->model('help_category_model');
                $category = $this->help_category_model->get($row_news->catid);
                $this->data['related_news'] = $this->help_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('catid' => $category->id, 'active' => 'yes', 'created_date <=' => $row_news->created_date, 'id <>' => $row_news->id));
                $this->data['new_news'] = $this->help_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('catid' => $category->id, 'active' => 'yes', 'id <>' => $row_news->id));
            } else {
                $this->data['related_news'] = $this->help_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('active' => 'yes', 'created_date <=' => $row_news->created_date, 'id <>' => $row_news->id));
                $this->data['new_news'] = $this->help_model->order_by('created_date', 'DESC')->limit($this->config->item('page_limit_5'))->get_many_by(array('active' => 'yes', 'id <>' => $row_news->id));
            }

            $search = array('[TITLE]', '[CONTENT]', '[KEYWORD]');

            $description = '';
            $keywords = '';

            if ($row_news->meta_description != '')
                $description = $row_news->meta_description;
            else
                $description = trim(short_text(view_title(strip_tags($row_news->content)), 170));

            if ($row_news->meta_keywords != '')
                $keywords = $row_news->meta_keywords;
            else
                $keywords = 'tro giup xo so, thong tin so xo';

            $replace = array($row_news->title, $description, $keywords);
            $this->data['_meta'] = $this->meta_model->show_title('help_detail', $search, $replace);
        } else {
            redirect($this->data['uri_root'] . '404_override');
        }
        $this->data['category'] = $category;
        $this->data['tmpl'] = 'news/helpdetail';
        $this->load->view('default', $this->data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */