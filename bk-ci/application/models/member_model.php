<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    function logout() {
        session_destroy();
        unset($_SESSION['_member']);
        delete_cookie('_member_id');
        return true;
    }

}
