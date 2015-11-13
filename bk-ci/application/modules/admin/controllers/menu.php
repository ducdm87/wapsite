<?php

require_once 'admin' . EXT;

class Menu extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array($this->data["module"] . "_model"));
        $rows = $this->menu_model->get_trees();
        $this->data["rows"] = $rows;
    }

    function index() {
        $this->data['tpl_file'] = $this->data['module'] . '/index';
        $this->load->view('layout/default', $this->data);
    }

    function update($id = NULL) {
        $row = $this->menu_model->get($id);

        $targets = array("_blank" => "Blank", "_self" => "Self", "_parent" => "Parent", "_top" => "Top", "framename" => "Framename");
        $this->data["targets"] = $targets;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->form_validation->set_rules('name', lang("MENU_NAME"), "required");

            if ($this->form_validation->run() == TRUE) {
                $name = $this->input->post('name');
                $name_alias = $this->input->post('name_alias');
                $active = $this->input->post('active');
                $link = $this->input->post('link');
                $order = $this->input->post('order');
                $pid = $this->input->post('pid');
                $target = $this->input->post("link_target");
                $data = array(
                    "name" => $name,
                    "name_alias" => $name_alias,
                    "link" => $link,
                    "pid" => $pid,
                    "active" => $active,
                    "order" => $order,
                    "target" => $target
                );

                if ($row) {
                    $this->menu_model->update($id, $data);
                } else {
                    $this->menu_model->insert($data);
                }
                die('yes');
            } else {
                die(validation_errors());
            }
        }

        $this->data["row"] = $row;

        $this->load->view($this->data["module"] . "/update", $this->data);
    }

    function active($id = NULL, $active = 0) {
        if ($row = $this->menu_model->get($id)) {
            if ($this->menu_model->update($id, array("active" => $active))) {
                admin_redirect($this->data["module"]);
            }
        }
    }

    function delete($id = NULL, $active = 0) {
        if ($row = $this->menu_model->get($id)) {
            if ($this->menu_model->delete($id)) {
                admin_redirect($this->data["module"]);
            }
        }
    }

}