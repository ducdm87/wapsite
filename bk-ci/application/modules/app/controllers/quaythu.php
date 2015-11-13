<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'app' . EXT;

class quaythu extends app {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['lid'] = (isset($_GET['lid']) ? trim($_GET['lid']) : 1);

        $this->load->model('xs_result_model');

        $row = $this->db->select("a8,a7,a6,a5,a4,a3,a2,a1,a0")
                ->from("xs_result")
                ->where('lid', $this->data['lid'])
                ->order_by('date', 'DESC')
                ->get()
                ->row();

        $result = array();
        if ($row) {
            $i = 1;
            foreach ($row as $value) {
                if ($value == '')
                    continue;
                $items = explode('-', $value);
                foreach ($items as $v) {
                    $result[$i] = $v;
                    $i++;
                }
            }
        }
        $str_result = '';
        if ($result) {
            foreach ($result as $key => $value) {
                $max = strlen($value);
                switch ($max) {
                    case 2:
                        $value = rand(0, 99);
                        break;
                    case 3:
                        $value = rand(0, 999);
                        break;
                    case 4:
                        $value = rand(0, 9999);
                        break;
                    case 5:
                        $value = rand(0, 99999);
                        break;
                    case 6:
                        $value = rand(0, 999999);
                        break;

                    default:
                        break;
                }
                $value = sprintf('%0' . $max . 'd', $value);
                if ($key == 1)
                    $str_result.='"' . $key . '":"' . $value . '"';
                else
                    $str_result.=',"' . $key . '":"' . $value . '"';
            }
        }
        $this->data['str_result'] = $str_result;
        $this->data['name'] = '';
        $this->data['alias'] = '';
        $this->data['area'] = '';
        foreach ($this->data['location_menu'] as $items) {
            foreach ($items as $value) {
                if ($value->id == $this->data['lid']) {
                    $this->data['name'] = $value->name;
                    $this->data['alias'] = $value->alias;
                    $this->data['area'] = $value->area;
                    break;
                }
            }
        }
        
        $this->data['tmpl'] = 'layout/quaythu';
        $this->load->view('layout/index', $this->data);
    }

    public function loadKq() {
        $date = date('d-m-Y');
        $lid = $_POST['lid'];
        $name = $_POST['name'];
        $alias = $_POST['alias'];
        $area = $_POST['area'];
        ?>
        <ul class="gr-yellow">
            <h2 class="txt-center">Kết quả xổ số <?php echo $name ?> ngày <?php echo $date ?></h2>
        </ul>
        <?php
        if ($area == 'MB') {
            ?>
            <ul class="list-kqmb">
                <li class="pad5 clearfix">
                    <label class="fl">Giải bảy</label>
                    <div class="clearfix">
                        <span class="fl percent-25"><strong class="imgloadig" id="g1"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g2"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g3"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g4"></strong></span>
                    </div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="fl">Giải sáu</label>
                    <div class="clearfix">
                        <span class="fl percent-33"><strong class="imgloadig" id="g5"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g6"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g7"></strong></span>

                    </div>
                </li>
                <li class="pad5 clearfix">
                    <label class="fl">Giải năm</label>
                    <div class="clearfix">
                        <span class="fl percent-33"><strong class="imgloadig" id="g8"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g9"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g10"></strong></span>
                    </div>
                    <label class="fl" style="padding-top:0">&nbsp;</label>
                    <div class="clearfix" style="padding-top:0">
                        <span class="fl percent-33"><strong class="imgloadig" id="g11"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g12"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g13"></strong></span>
                    </div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="fl">Giải tư</label>
                    <div class="clearfix">
                        <span class="fl percent-25"><strong class="imgloadig" id="g14"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g15"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g16"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g17"></strong></span>
                    </div>
                </li>
                <li class="pad5 clearfix">
                    <label class="fl">Giải ba</label>
                    <div class="clearfix">
                        <span class="fl percent-33"><strong class="imgloadig" id="g18"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g19"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g20"></strong></span>
                    </div>
                    <label class="fl" style="padding-top:0">&nbsp;</label>
                    <div class="clearfix" style="padding-top:0">
                        <span class="fl percent-33"><strong class="imgloadig" id="g21"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g22"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g23"></strong></span>
                    </div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="fl">Giải nhì</label>
                    <div class="clearfix">
                        <span class="fl percent-50"><strong class="imgloadig" id="g24"></strong></span>
                        <span class="fl percent-50"><strong class="imgloadig" id="g25"></strong></span>

                    </div>
                </li>
                <li class="pad5 clearfix">
                    <label class="fl">Giải nhất</label>
                    <div class="aprize"><span><strong class="imgloadig" id="g26"></strong></span></div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="special fl">Đặc biệt</label>
                    <div class="aprize clred font18"><span><strong class="imgloadig" id="g27"></strong></span></div>
                </li>
            </ul>
            <?php
        } else {
            ?>
            <ul class="list-kqmb city-mn">
                <li class="bg_yellow pad5 clearfix">
                    <label class="fl">Giải tám</label>
                    <div class="aprize clred"><span><strong class="imgloadig" id="g1"></strong></span></div>
                </li>
                <li class="pad5 clearfix">
                    <label class="fl">Giải bảy</label>
                    <div class="aprize"><span><strong class="imgloadig" id="g2"></strong></span></div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="fl">Giải sáu</label>
                    <div class="clearfix">
                        <span class="fl percent-33"><strong class="imgloadig" id="g3"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g4"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g5"></strong></span>
                    </div>
                </li>
                <li class="pad5 clearfix">
                    <label class="fl">Giải năm</label>
                    <div class="aprize"><span><strong class="imgloadig" id="g6"></strong></span></div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="fl">Giải tư</label>
                    <div class="clearfix">
                        <span class="fl percent-25"><strong class="imgloadig" id="g7"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g8"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g9"></strong></span>
                        <span class="fl percent-25"><strong class="imgloadig" id="g10"></strong></span>
                    </div>
                    <label class="fl" style="padding-top:0">&nbsp;</label>
                    <div class="clearfix" style="padding-top:0">
                        <span class="fl percent-33"><strong class="imgloadig" id="g11"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g12"></strong></span>
                        <span class="fl percent-33"><strong class="imgloadig" id="g13"></strong></span>
                    </div>
                </li>
                <li class="pad5 clearfix">
                    <label class="fl">Giải ba</label>
                    <div class="clearfix">
                        <span class="fl percent-50"><strong class="imgloadig" id="g14"></strong></span>
                        <span class="fl percent-50"><strong class="imgloadig" id="g15"></strong></span>
                    </div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="fl">Giải nhì</label>
                    <div class="aprize">
                        <span><strong class="imgloadig" id="g16"></strong></span>
                    </div>
                </li>
                <li class="pad5 clearfix">
                    <label class="fl">Giải nhất</label>
                    <div class="aprize">
                        <span><strong class="imgloadig" id="g17"></strong></span>
                    </div>
                </li>
                <li class="bg_yellow pad5 clearfix">
                    <label class="special fl">Đặc biệt</label>
                    <div class="aprize clred font18">
                        <span><strong class="imgloadig" id="g18"></strong></span>
                    </div>
                </li>
            </ul>
            <?php
        }
        die;
    }

}