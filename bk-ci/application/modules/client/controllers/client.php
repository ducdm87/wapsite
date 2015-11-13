<?php

class Client extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
//        $this->load->helper('cookie');
//        $this->load->model(array('user_model', 'session_model', 'meta_model', 'xs_location_model', 'banner_model', 'xs_keyword_model', 'xs_loto_online_model', 'xs_loto_onlinetk_model', 'xs_loto_top_model'));
//        $this->load->library('simple_cache');

       

        $query = "SELECT id,userid,created FROM `sessions`";
        $sessions = $this->db->query($query)->result();
        $arr_user = array();
        if ($sessions) {
            foreach ($sessions as $item) {
                $time = $time_end - $item->created;
                if ($time > (60 * 60)) {
                    $this->session_model->delete($item->id);
                } else {
                    $arr_user[] = $item->userid;
                }
            }
        }

         $client_data['layout_header'] = 'block/header';
            $client_data['layout_footer'] = 'block/footer';
            $client_data['layout_col_left'] = 'col_left';
            $client_data['layout_sms'] = 'sms';
            $client_data['thongke_block'] = 'thongke_block';
         
        $this->data = array_merge($this->data, $client_data);

        header("Cache-Control: max-age=30");
        header_remove("Pragma");
        header_remove("Expires");
    }

}
