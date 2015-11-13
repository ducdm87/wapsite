<?php

class mobile extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_result_model', 'xs_location_model'));
        define('CLIENT_VIEW_DIR', APPPATH . 'modules/mobile/views/');

        $this->data['c_module'] = $this->router->class;
        $this->data['c_func'] = $this->router->method;

        $this->data['uri_root'] = site_url();
        $this->data['xs_location_menu'] = $this->xs_location_model->getLocation();
    }

}