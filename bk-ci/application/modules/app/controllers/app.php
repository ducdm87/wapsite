<?php

class app extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();

        $this->load->model(array('xs_location_model'));
        define('CLIENT_VIEW_DIR', APPPATH . 'modules/app/views/');

        $this->data['c_module'] = $this->router->class;
        $this->data['c_func'] = $this->router->method;
        
        if (!isset($_GET['UUbQpHAK']) && $this->data['c_func'] != 'xstt' && $this->data['c_func'] != 'loadKq')
            die;

        $this->data['uri_root'] = site_url();
        $this->data['mxoso'] = 'http://m.xoso.com/';
        $this->data['xs_location_menu'] = $this->xs_location_model->getLocation();

        $this->data['url_mienbac'] = config_item('url_mienbac');
        $this->data['url_mientrung'] = config_item('url_mientrung');
        $this->data['url_miennam'] = config_item('url_miennam');

        $date = strval(date('w') + 1);
        $this->data['location_menu'] = array();
        $this->data['location_today'] = array();
        foreach ($this->data['xs_location_menu'] as $value) {
            $this->data['location_menu'][$value->area][] = $value;
            if (strpos($value->lich, strval($date)) !== false)
                $this->data['location_today'][$value->area][] = $value;
        }
        
        header("Cache-Control: max-age=300");
        header_remove("Pragma");
        header_remove("Expires");
    }

}