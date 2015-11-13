<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class getcontent extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_result_model');
        $this->load->helper('rest');
    }

    public function index() {
        $rest = new REST;

        if (!isset($_GET['serviceCode']) || !isset($_GET['Type']) || ($_GET['Type'] != 1 && $_GET['Type'] != 2 && $_GET['Type'] != 3)) {
            $data = array('List' => array());
            $rest->response($rest->json($data), 204);
        }

        $Type = $_GET['Type'];
        $serviceCode = $_GET['serviceCode'];
        $content = '';

        switch ($serviceCode) {
            case 'XMB':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu KQXS Mien Bac, mien phi ngay dau tien, tu ngay thu 2 chi phi la 1.000/ngay. Huy nhan ket qua, soan tin HUY XMB gui 8979';
                    $content = $this->getKQXS(0, 1);
                } elseif ($Type == 2) {
                    $content = $this->getKQXS(0);
                } else {
                    $content = 'Ban da huy thanh cong dich vu nhan KQXS Mien Bac tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'XMN':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu KQXS Mien Nam, mien phi ngay dau tien, tu ngay thu 2 chi phi la 2.000/ngay. Huy nhan ket qua, soan tin HUY XMN gui 8979';
                    $content = $this->getKQXS(2, 1);
                } elseif ($Type == 2) {
                    $content = $this->getKQXS(2);
                } else {
                    $content = 'Ban da huy thanh cong dich vu nhan KQXS Mien Nam tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'XMT':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu KQXS Mien Trung, mien phi ngay dau tien, tu ngay thu 2 chi phi la 2.000/ngay. Huy nhan ket qua, soan tin HUY XMT gui 8979';
                    $content = $this->getKQXS(1, 1);
                } elseif ($Type == 2) {
                    $content = $this->getKQXS(1);
                } else {
                    $content = 'Ban da huy thanh cong dich vu nhan KQXS Mien Trung tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'TKB':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu thong ke XS Mien Bac, mien phi ngay dau tien, tu ngay thu 2 chi phi la 1.000/ngay. Huy nhan ket qua, soan tin HUY TKB gui 8979';
                    $content = $this->getTK(0);
                } elseif ($Type == 2) {
                    $content = $this->getTK(0);
                } else {
                    $content = 'Ban da huy thanh cong dich vu thong ke XS Mien Bac tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'TKN':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu thong ke XS Mien Nam, mien phi ngay dau tien, tu ngay thu 2 chi phi la 2.000/ngay. Huy nhan ket qua, soan tin HUY TKN gui 8979';
                    $content = $this->getTK(2);
                } elseif ($Type == 2) {
                    $content = $this->getTK(2);
                } else {
                    $content = 'Ban da huy thanh cong dich vu thong ke XS Mien Nam tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'TKT':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu thong ke XS Mien Trung, mien phi ngay dau tien, tu ngay thu 2 chi phi la 2.000/ngay. Huy nhan ket qua, soan tin HUY TKT gui 8979';
                    $content = $this->getTK(1);
                } elseif ($Type == 2) {
                    $content = $this->getTK(1);
                } else {
                    $content = 'Ban da huy thanh cong dich vu thong ke XS Mien Trung tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'XLMB':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu so may man Mien Bac, mien phi ngay dau tien, tu ngay thu 2 chi phi la 1.000/ngay. Huy nhan ket qua, soan tin HUY XLMB gui 8979';
                    $content = $this->getXL(0);
                } elseif ($Type == 2) {
                    $content = $this->getXL(0);
                } else {
                    $content = 'Ban da huy thanh cong dich vu con so may man XS Mien Bac tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'XLMN':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu so may man Mien Nam, mien phi ngay dau tien, tu ngay thu 2 chi phi la 2.000/ngay. Huy nhan ket qua, soan tin HUY XLMN gui 8979';
                    $content = $this->getXL(2);
                } elseif ($Type == 2) {
                    $content = $this->getXL(2);
                } else {
                    $content = 'Ban da huy thanh cong dich vu con so may man XS Mien Nam tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            case 'XLMT':
                if ($Type == 1) {
                    $content = 'Ban dang ky thanh cong dich vu so may man Mien Trung, mien phi ngay dau tien, tu ngay thu 2 chi phi la 2.000/ngay. Huy nhan ket qua, soan tin HUY XLMT gui 8979';
                    $content = $this->getXL(1);
                } elseif ($Type == 2) {
                    $content = $this->getXL(1);
                } else {
                    $content = 'Ban da huy thanh cong dich vu con so may man XS Mien Trung tu ngay ' . date('d/m');
                }
                break;
            //------------------------
            default:
                break;
        }

        if ($content != '') {
            $arr_data = explode('||', $content);
            $data = array();
            foreach ($arr_data as $value) {
                if ($value == '')
                    continue;
                $tmp = new stdClass();
                $tmp->Type = 'text';
                $tmp->Content = $value;
                $data[] = $tmp;
            }
            $data = array('List' => $data);
            $rest->response($rest->json($data), 200);
        }
        $data = array('List' => array());
        $rest->response($rest->json($data), 204);
    }

    function getKQXS($area_, $type = 0) {
        $area = '';
        if ($area_ == 0)
            $area = 'MB';
        elseif ($area_ == 1)
            $area = 'MT';
        elseif ($area_ == 2)
            $area = 'MN';

        if ($type == 1)
            $date = date('Y-m-d', strtotime('-1 days'));
        else
            $date = date('Y-m-d');
//        $date = '2013-07-07'; //test
        $this->db->where('r.date', $date);
        $this->db->where('l.area', $area);
        $this->db->where('l.status', 1);
        $data = $this->db->select('r.a0,r.a1,r.a2,r.a3,r.a4,r.a5,r.a6,r.a7,r.a8,l.name')
                ->from('xs_result AS r')
                ->join('xs_location AS l', 'r.lid = l.id', 'left')
                ->order_by('r.date', 'DESC')
                ->get()
                ->result();

        if (empty($data))
            return '';

        $content = '';
        foreach ($data as $item) {
            $content .= RemoveSign($item->name) . ' ' . date('d/m', strtotime($date)) . ":\n";
            $content .= 'DB:' . $item->a0 . "\n";
            $content .= '1:' . $item->a1 . "\n";
            $content .= '2:' . $item->a2 . "\n";
            $content .= '3:' . $item->a3 . "\n";
            if ($area_ == 0)
                $content .='||';
            $content .= '4:' . $item->a4 . "\n";
            $content .= '5:' . $item->a5 . "\n";
            $content .= '6:' . $item->a6 . "\n";
            $content .= '7:' . $item->a7 . "\n";
            if ($area != 'MB' && $item->a8 != '')
                $content .= '8:' . $item->a8;
            if ($area_ != 0)
                $content .='||';
        }
        return $content;
    }

    function getTK($area_) {
        $time_turn = 100;
        $content = '';
        if ($area_ == 0) {
            $content = 'Thong ke Mien Bac ngay ' . date('d/m') . ': ' . "\nBo so duoc danh gia cao: ";
            $lid = 1;
            $items = $this->xs_result_model->getitemsImportant($lid, $time_turn);
            foreach ($items['high'] as $k => $v) {
                $content .= $v['number'] . ',';
            }
            $content = substr($content, 0, strlen($content) - 1);

            $content .= "\nBo so uu tien thu 2: ";
            foreach ($items['priority'] as $k => $v) {
                $content .= $v['number'] . ',';
            }
            $content = substr($content, 0, strlen($content) - 1);

            $content .= "||Bo so co the ra lo roi: ";
            foreach ($items['plots_fall'] as $k => $v) {
                $content .= $v['number'] . ',';
            }
            $content = substr($content, 0, strlen($content) - 1);

            $content .= "\nBo so can than trong: ";
            foreach ($items['cautious'] as $k => $v) {
                $content .= $v['number'] . ',';
            }
            $content = substr($content, 0, strlen($content) - 1);
        } else {
            $this->load->model('xs_location_model');
            $xs_location_menu = $this->xs_location_model->getLocation();
            $date = strval(date('w') + 1);
            $location_today = array();
            foreach ($xs_location_menu as $value) {
                if (strpos($value->lich, strval($date)) !== false)
                    $location_today[$value->area][] = $value;
            }
            $area = 'MN';
            if ($area_ == 1)
                $area = 'MT';
            foreach ($location_today[$area] as $value) {
                $items = $this->xs_result_model->getitemsImportant($value->id, $time_turn);

                $content .= 'Thong ke ' . RemoveSign($value->name) . ' ngay ' . date('d/m') . ': ' . "\nBo so duoc danh gia cao: ";
                foreach ($items['high'] as $k => $v) {
                    $content .= $v['number'] . ',';
                }
                $content = substr($content, 0, strlen($content) - 1);

                if (count($items['priority'])) {
                    $content .= "\nBo so uu tien thu 2: ";
                    foreach ($items['priority'] as $k => $v) {
                        $content .= $v['number'] . ',';
                    }
                    $content = substr($content, 0, strlen($content) - 1);
                }

                $content .= "||Bo so co the ra lo roi: ";
                foreach ($items['plots_fall'] as $k => $v) {
                    $content .= $v['number'] . ',';
                }
                $content = substr($content, 0, strlen($content) - 1);

                $content .= "\nBo so can than trong: ";
                foreach ($items['cautious'] as $k => $v) {
                    $content .= $v['number'] . ',';
                }
                $content = substr($content, 0, strlen($content) - 1);

                $content .= "||";
            }
        }
        return $content;
    }

    function getXL($area_) {
        $kqmm = '';
        if ($area_ == 0) {
            $so1 = rand(0, 99);
            $so2 = rand(0, 99);
            while ($so2 == $so1)
                $so2 = rand(0, 99);
            $so3 = rand(0, 99);
            while ($so3 == $so1 || $so3 == $so2)
                $so3 = rand(0, 99);

            if ($so1 < 10)
                $so1 = '0' . $so1;
            if ($so2 < 10)
                $so2 = '0' . $so2;
            if ($so3 < 10)
                $so3 = '0' . $so3;

            $kqmm = 'Cap so may man Mien bac ngay ' . date('d/m') . ': ' . $so1 . '-' . $so2 . '-' . $so3;
        }else {
            $this->load->model('xs_location_model');
            $xs_location_menu = $this->xs_location_model->getLocation();
            $date = strval(date('w') + 1);
            $location_today = array();
            foreach ($xs_location_menu as $value) {
                if (strpos($value->lich, strval($date)) !== false)
                    $location_today[$value->area][] = $value;
            }
            $area = 'MN';
            if ($area_ == 1)
                $area = 'MT';
            foreach ($location_today[$area] as $value) {
                $so1 = rand(0, 99);
                $so2 = rand(0, 99);
                while ($so2 == $so1)
                    $so2 = rand(0, 99);
                $so3 = rand(0, 99);
                while ($so3 == $so1 || $so3 == $so2)
                    $so3 = rand(0, 99);

                if ($so1 < 10)
                    $so1 = '0' . $so1;
                if ($so2 < 10)
                    $so2 = '0' . $so2;
                if ($so3 < 10)
                    $so3 = '0' . $so3;

                $kqmm .= 'Cap so may man ' . RemoveSign($value->name) . ' ngay ' . date('d/m') . ': ' . $so1 . '-' . $so2 . '-' . $so3 . "\n";
            }
        }

        return $kqmm;
    }

}