<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class datso extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_result_model', 'xs_loto_online_model', 'xs_loto_onlinetk_model'));
    }

    function index() {
        $date = date('Y-m-d');
        $nextday = $date;

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $so = (isset($_POST['range']) ? trim($_POST['range']) : '');
            $diem = (isset($_POST['bet']) ? $_POST['bet'] : 0);
            $ngay = (isset($_POST['ngay']) ? $_POST['ngay'] : '');
            $ngay = date('Y-m-d', strtotime(str_replace('/', '-', $ngay)));
            $userid = (isset($_POST['userid']) ? $_POST['userid'] : 0);
            $created = (isset($_POST['created']) ? $_POST['created'] : time());
            $created = strtotime(str_replace('/', '-', $created));

            if ($so != '' && $diem > 0) {
                $arr_so = explode(',', $so);
                $arr_so = array_unique($arr_so);

                foreach ($arr_so as $i => $value) {
                    if (strlen($value) > 2)
                        unset($arr_so[$i]);
                    elseif (!is_numeric($value))
                        unset($arr_so[$i]);
                }                

                $taikhoan = 0;
                $loto_online = $this->db->select("taikhoan")
                                ->from("xs_loto_online")
                                ->where('quay', 1)
                                ->where("userid", $userid)
                                ->order_by('ngay', 'DESC')
                                ->get()->row();

                if ($loto_online)
                    $taikhoan = $loto_online->taikhoan;

                $loto_online = $this->db->select("id")
                                ->from("xs_loto_online")
                                ->where('quay', 2)
                                ->where('ngay', $ngay)
                                ->where("userid", $userid)
                                ->get()->row();

                if ($loto_online) {
                    foreach ($arr_so as $value) {
                        $loto_onlinetk = $this->db->select("id")
                                        ->from("xs_loto_onlinetk")
                                        ->where("lo_id", $loto_online->id)
                                        ->where("lo", $value)
                                        ->get()->row();
//                    echo $this->db->last_query();
                        if ($loto_onlinetk) {
                            $this->xs_loto_onlinetk_model->update($loto_onlinetk->id, array('diem' => $diem));
                        } else {
                            $data = array(
                                'lo_id' => $loto_online->id,
                                'lo' => $value,
                                'diem' => $diem,
                                'created' => time(),
                            );
                            $this->xs_loto_onlinetk_model->insert($data);
                        }
                    }
                } else {
                    $data = array(
                        'ngay' => $ngay,
                        'userid' => $userid,
                        'taikhoan' => $taikhoan,
                        'created' => $created,
                        'quay' => 2,
                    );

                    $this->xs_loto_online_model->insert($data);
                    $lo_id = $this->db->insert_id();
                    foreach ($arr_so as $value) {
                        $data = array(
                            'lo_id' => $lo_id,
                            'lo' => $value,
                            'diem' => $diem,
                            'created' => time(),
                        );
                        $this->xs_loto_onlinetk_model->insert($data);
                    }
                }
            }
        }

        $user_list = $this->db->select("*")
                        ->from('users')
                        ->order_by('username', 'ASC')
                        ->get()->result();

        $this->data['user_list'] = $user_list;

        $this->data["nextday"] = $nextday;
        $this->data["date"] = $date;
        $this->data['tpl_file'] = 'datso/index';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_loto_online_model->get($id)) {
            $this->xs_loto_onlinetk_model->delete_by(array('lo_id' => $id));
            if ($this->xs_loto_online_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

    public function betlist() {
        $ngay = (isset($_GET['ngay']) ? $_GET['ngay'] : date('Y-m-d'));

        $loto_online = $this->db->select("a.id,a.ngay,a.taikhoan,a.created,b.fullname")
                        ->from("xs_loto_online AS a")
                        ->join("users AS b", "a.userid=b.id")
                        ->where('(ngay < \'' . $ngay . '\' AND (a.quay=2 OR a.quay=3))')
                        ->order_by('a.ngay', 'DESC')
                        ->limit(10)
                        ->get()->result();
//        echo $this->db->last_query();
        $out_str = '';
        if ($loto_online) {
            foreach ($loto_online as $item) {
                $loto_onlinetk = $this->db->select("lo,diem,nhay")
                                ->from("xs_loto_onlinetk")
                                ->where('lo_id', $item->id)
                                ->order_by('created', 'ASC')
                                ->get()->result();

                if ($loto_onlinetk) {
                    $out_str .= date('d-m-Y',strtotime($item->ngay)) . '~';
                    foreach ($loto_onlinetk as $value) {
                        $out_str .= $value->lo . ':' . $value->diem . ':' . $item->id . ',';
                    }
                    $out_str = substr($out_str, 0, -1);
                    $out_str .= '~' . $item->fullname;
                    $out_str .= '~' . date('d-m-Y H:i:s',$item->created) . '|';
                }
            }
        }
        if ($out_str != '') {
            $out_str = substr($out_str, 0, -1);
            echo $out_str;
        }
        die;
    }

    public function betupdate() {
        $so = (isset($_GET['range']) ? trim($_GET['range']) : '');
        $diem = (isset($_GET['bet']) ? $_GET['bet'] : 0);
        $ngay = (isset($_GET['ngay']) ? $_GET['ngay'] : '');

        if (!isset($_SESSION['user']['id']) || $diem > 2000 || $ngay == '')
            die;

        $today = date('Y-m-d');
        $hour = date('H');
        if ($ngay == $today && $hour > 18) {
            $loto_onlinetk = $this->db->select("a.id,b.lo,b.diem")
                            ->from("xs_loto_online AS a")
                            ->join("xs_loto_onlinetk AS b", "a.id=b.lo_id")
                            ->where("a.ngay", $ngay)
                            ->where("a.userid", $_SESSION['user']['id'])
                            ->get()->result();
            $out_str = '';
            if ($loto_onlinetk) {
                foreach ($loto_onlinetk as $value) {
                    $out_str.=$value->lo . ':' . $value->diem . '|';
                }
            }
            if ($out_str != '') {
                $out_str = substr($out_str, 0, -1);
                echo $out_str;
            }

            die;
        }

        if ($so != '' && $diem > 0 && $ngay >= $today) {
            $arr_so = explode(',', $so);
            $arr_so = array_unique($arr_so);

            foreach ($arr_so as $i => $value) {
                if (strlen($value) > 2)
                    unset($arr_so[$i]);
                elseif (!is_numeric($value))
                    unset($arr_so[$i]);
            }
//            $ngay = date('Y-m-d', strtotime($ngay));

            $taikhoan = 0;
            $loto_online = $this->db->select("taikhoan")
                            ->from("xs_loto_online")
                            ->where('quay', 1)
                            ->where("userid", $_SESSION['user']['id'])
                            ->order_by('ngay', 'DESC')
                            ->get()->row();

            if ($loto_online)
                $taikhoan = $loto_online->taikhoan;

            $loto_online = $this->db->select("id")
                            ->from("xs_loto_online")
                            ->where('quay', 0)
                            ->where('ngay', $ngay)
                            ->where("userid", $_SESSION['user']['id'])
                            ->get()->row();

            if ($loto_online) {
                foreach ($arr_so as $value) {
                    $loto_onlinetk = $this->db->select("id")
                                    ->from("xs_loto_onlinetk")
                                    ->where("lo_id", $loto_online->id)
                                    ->where("lo", $value)
                                    ->get()->row();
//                    echo $this->db->last_query();
                    if ($loto_onlinetk) {
                        $this->xs_loto_onlinetk_model->update($loto_onlinetk->id, array('diem' => $diem));
                    } else {
                        $data = array(
                            'lo_id' => $loto_online->id,
                            'lo' => $value,
                            'diem' => $diem,
                            'created' => time(),
                        );
                        $this->xs_loto_onlinetk_model->insert($data);
                    }
                }
            } else {
                $data = array(
                    'ngay' => $ngay,
                    'userid' => $_SESSION['user']['id'],
                    'taikhoan' => $taikhoan,
                    'created' => time(),
                );
                $this->xs_loto_online_model->insert($data);
                $lo_id = $this->db->insert_id();
                foreach ($arr_so as $value) {
                    $data = array(
                        'lo_id' => $lo_id,
                        'lo' => $value,
                        'diem' => $diem,
                        'created' => time(),
                    );
                    $this->xs_loto_onlinetk_model->insert($data);
                }
            }
        } elseif ($so != '' && $diem == 0 && $ngay >= $today) {
            $arr_so = explode(',', $so);
            $arr_so = array_unique($arr_so);

            $id_list = '';
            $out_str = '';
            foreach ($arr_so as $i => $value) {
                if (strlen($value) > 2)
                    unset($arr_so[$i]);
                elseif (!is_numeric($value))
                    unset($arr_so[$i]);
                else {
                    $id_list.='\'' . $value . '\',';
                    $out_str.=$value . ':0|';
                }
            }
            if ($id_list != '') {
                $id_list = substr($id_list, 0, -1);
                $loto_online = $this->db->select("id")
                                ->from("xs_loto_online")
                                ->where('quay', 0)
                                ->where("ngay", $ngay)
                                ->where("userid", $_SESSION['user']['id'])
                                ->get()->row();

                if ($loto_online) {
                    $query = "DELETE FROM `xs_loto_onlinetk` WHERE lo_id=" . $loto_online->id . " AND lo IN(" . $id_list . ")";
                    $this->db->query($query);
//                    echo $this->db->last_query();
                }
            }

            if ($out_str != '') {
                $out_str = substr($out_str, 0, -1);
                echo $out_str;
            }

            die;
        }

        $loto_onlinetk = $this->db->select("a.id,b.lo,b.diem")
                        ->from("xs_loto_online AS a")
                        ->join("xs_loto_onlinetk AS b", "a.id=b.lo_id")
                        ->where("a.ngay", $ngay)
                        ->where("a.userid", $_SESSION['user']['id'])
                        ->get()->result();
        $out_str = '';
        if ($loto_onlinetk) {
            foreach ($loto_onlinetk as $value) {
                $out_str.=$value->lo . ':' . $value->diem . '|';
            }
        }
        if ($out_str != '') {
            $out_str = substr($out_str, 0, -1);
            echo $out_str;
        }

        die;
    }

    public function betkq() {
        $ngay = (isset($_GET['ngay']) ? $_GET['ngay'] : '');

        if (!isset($_SESSION['user']['id']) || $ngay == '')
            die;

        $str = '';
        $loto_online = $this->db->select("id")
                        ->from("xs_loto_online")
                        ->where("ngay", $ngay)
                        ->where("quay", 1)
                        ->where("userid", $_SESSION['user']['id'])
                        ->get()->row();
        if ($loto_online) {
            $loto_onlinetk = $this->db->select("*")
                            ->from("xs_loto_onlinetk")
                            ->where('lo_id', $loto_online->id)
                            ->where('nhay >', 0)
                            ->get()->result();
            if ($loto_onlinetk) {
                $str = '';
                foreach ($loto_onlinetk as $item) {
                    $str .=$item->lo . ':' . $item->nhay . '|';
                }
            }
            echo $str . 'finish';
        }

        die;
    }

}
