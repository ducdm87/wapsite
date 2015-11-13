<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Live extends CI_Controller {

    function __construct() {
        parent::__construct();

        header("Cache-Control: max-age=0");
        header_remove("Pragma");
        header_remove("Expires");

        $time = date('H:i');
        if ($time > '16:00' && $time < '19:00')
            header("Cache-Control: max-age=3");
    }

    function crawcau() {
        $this->load->model(array('xs_statistics_model'));

        $this->data['limit'] = 3;
        $this->data['exactlimit'] = 0;
        $this->data['ngay'] = date('d-m-Y', strtotime('+1 days'));
        $this->data['nhay'] = 2;
        $this->data['db'] = 0;
        $this->data['lon'] = 1;

        $lid = 1;
        $arr_rs = $this->xs_statistics_model->soiCauNew($lid, $this->data['ngay'], $this->data['db'], $this->data['lon'], $this->data['nhay'], $this->data['limit']);
        $this->data['ngay'] = $arr_rs['ngay'];
        $this->data['max_cau'] = $arr_rs['max_cau'];
        $data = $arr_rs['data'];
        $this->data['data_limit'] = $arr_rs['data_limit'];
        $this->data['data_nextlimit'] = $arr_rs['data_nextlimit'];

        if ($this->data['limit'] > $this->data['max_cau']) {
            $this->data['limit'] = $this->data['max_cau'];
            foreach ($data as $vitri => $value) {
                if ($value['cau'] == $this->data['limit'])
                    $this->data['data_limit'][$vitri] = $value['so'];
            }
        }

        asort($this->data['data_limit']);

        $list_cau = array();
        foreach ($this->data['data_limit'] as $vitri => $value) {
            if ($this->data['lon'] == 0) {
                $list_cau[$value]['cau'] = $list_cau[$value]['cau'] + 1;
                $list_cau[$value]['so'] = $value;
                $list_cau[$value]['order'] = $value;
            } else {
                $arr = str_split($value);
                if ($arr[0] != $arr[1]) {
                    if ($arr[0] > $arr[1]) {
                        $list_cau[$arr[1] . $arr[0] . ',' . $arr[0] . $arr[1]]['cau'] = $list_cau[$arr[1] . $arr[0] . ',' . $arr[0] . $arr[1]]['cau'] + 1;
                        $list_cau[$arr[1] . $arr[0] . ',' . $arr[0] . $arr[1]]['so'] = $arr[1] . $arr[0] . ',' . $arr[0] . $arr[1];
                        $list_cau[$arr[1] . $arr[0] . ',' . $arr[0] . $arr[1]]['order'] = $arr[1] . $arr[0];
                    } else {
                        $list_cau[$arr[0] . $arr[1] . ',' . $arr[1] . $arr[0]]['cau'] = $list_cau[$arr[0] . $arr[1] . ',' . $arr[1] . $arr[0]]['cau'] + 1;
                        $list_cau[$arr[0] . $arr[1] . ',' . $arr[1] . $arr[0]]['so'] = $arr[0] . $arr[1] . ',' . $arr[1] . $arr[0];
                        $list_cau[$arr[0] . $arr[1] . ',' . $arr[1] . $arr[0]]['order'] = $arr[0] . $arr[1];
                    }
                } else {
                    $list_cau[$value]['cau'] = $list_cau[$value]['cau'] + 1;
                    $list_cau[$value]['so'] = $value;
                    $list_cau[$value]['order'] = $value;
                }
            }
        }
        foreach ($list_cau as $key => $value) {
            $sort_so[$key] = $value['order'];
            $sort_cau[$key] = $value['cau'];
        }
        array_multisort($sort_cau, SORT_DESC, $sort_so, SORT_ASC, $list_cau);

        $rs = array();
        foreach ($list_cau as $item)
            $rs[] = $item['so'];

        $this->load->library(array('simple_cache'));
        $this->simple_cache->cache_item('data_cau', $rs);
        die('OK');
    }

    public function index() {
        die('...');
        $this->load->library(array('simple_html_dom', 'simple_cache'));
        $this->load->model(array('xs_result_model'));

        $time_start = time();

//        if (getenv('UPDATEXOSO') != false) {
//            die('Craw đang hoạt động, vui lòng thử lại sau'); 
//        } else {
//            putenv('UPDATEXOSO=TRUE');
//        }
//        Không giới hạn thời gian craw data
        set_time_limit(56);
        ini_set('max_execution_time', 56);
        ignore_user_abort(false); //true = Script vẫn chạy dù Client request chạy script bị ngắt kết nối
//        Khởi tạo output buffering
        ob_end_clean();

        if (ob_get_level() == 0) {
            ob_start();
        }

        echo '<pre>';
        $i = 0;
        while ($i < 12) {
            $this->xs_result_model->craw();
            sleep(5);
            $i++;
            $time = date('d/m/Y H:i:s');
            echo '<p>' . $i . '=>' . $time . '</p>';
            flush();
            ob_flush();

            $time_end = time();
            $time = $time_end - $time_start;
            if ($time >= 56) {
                echo $time . ' - Success...';
                echo '</pre>';
                unset($i, $time, $time_start, $time_end);
                ob_end_flush();
                die;
            }
        }

        echo $time . ' - Success...';
        echo '</pre>';
        unset($i, $time, $time_start, $time_end);
//        var_dump((get_defined_vars()));
        ob_end_flush();
        die;
    }

    public function sendsms() {
        if (!isset($_GET['UUbQpHAK']))
            die('0');

        $this->load->model(array('xs_result_model', 'xs_sms_model'));
        require('sms/nusoap.php');
        $area = (int) $_GET['area'];
        $this->xs_result_model->sendsms($area);
        die('1');
    }

    public function saveresult() {
        if (!isset($_GET['UUbQpHAK']))
            die('0');

        $this->load->model('xs_result_model');
        $area = (int) $_GET['area'];
        $this->xs_result_model->saveresult($area);
        die('1');
    }

//    public function update($area = 'MB') {
//        $this->load->model("xs_statistics_model");
//        $this->xs_statistics_model->updateStatistics($area);
//    }
//    function cCache($lid, $today) {//xoa cache tren 213        
//        $this->load->library('simple_cache');
//        $this->simple_cache->delete_item('home_data');
//        $this->simple_cache->delete_item('demo_date_' . $lid . '_' . $today);
//
//        $this->simple_cache->cache_dir = FCPATH . 'xoso_mobile/application/';
//        $this->simple_cache->delete_item('home_data');
//        echo 'OK.';
//    }

    public function craw($task = '') {
        die;
        $this->load->library("simple_html_dom");
        $this->load->model("xs_craw_model");

//        Không giới hạn thời gian craw data
        set_time_limit(0);
        ignore_user_abort(true);

//        Khởi tạo output buffering
        ob_end_clean();

        if (ob_get_level() == 0) {
            ob_start();
        }

        echo "<pre>";
        $date = date('Y-m-d', strtotime("-1 day"));
        if ($task == 'xsdt') {
            $this->xs_craw_model->getXSMB($date);
        } else {
            $this->xs_craw_model->crawLink($date);
        }
        echo "</pre>";
        ob_end_flush();
        exit;
    }

    public function crawxs() {
        //client/live/crawxs?UUbQpHAK=1&alias=quangnam&d=01&m=01&y=2006
        if (!isset($_GET['UUbQpHAK']))
            die;

        $this->load->library("simple_html_dom");
        $this->load->model("xs_crawxs_model");

//        Không giới hạn thời gian craw data
        set_time_limit(0);
        ignore_user_abort(true);

//        Khởi tạo output buffering
        ob_end_clean();

        if (ob_get_level() == 0) {
            ob_start();
        }

        echo '<pre>';

        $url_alias = (isset($_GET['alias']) ? $_GET['alias'] : 'mienbac');
        $day = (isset($_GET['d']) ? $_GET['d'] : date('d'));
        $month = (isset($_GET['m']) ? $_GET['m'] : date('m'));
        $year = (isset($_GET['y']) ? $_GET['y'] : date('Y'));

        $next_date = date('Y-m-d', strtotime("+1 day", strtotime($year . '-' . $month . '-' . $day)));
        $next_d = date('d', strtotime($next_date));
        $next_m = date('m', strtotime($next_date));
        $next_y = date('Y', strtotime($next_date));

        $url = 'http://xoso.congdong.net.vn/' . $url_alias . '/' . $year . '/' . $month . '/' . $day . '/';
        $url_next = base_url() . 'client/live/crawxs?UUbQpHAK=1&alias=' . $url_alias . '&d=' . $next_d . '&m=' . $next_m . '&y=' . $next_y;

        $lid = 0;
        if ($url_alias == 'daklak')
            $url_alias = 'daclac';
        elseif ($url_alias == 'daknong')
            $url_alias = 'dacnong';
        foreach ($this->data['xs_location_menu'] as $value) {
            $alias = str_replace(array('xo-so-', '-'), array('', ''), $value->alias);
            $pos = strpos($alias, $url_alias);
            if ($pos !== false) {
                $lid = $value->id;
                break;
            }
        }
        echo '=> ' . $lid . ': ' . $url . '<br/>';
        if ($lid == 0) {
            ob_end_flush();
            die('<div style="color:red">Khong tim thay Tinh/TP</div>');
        }

        $opts = array('http' => array('header' => "User-Agent:User-Agent:Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0", 'timeout' => 5));
        $context = stream_context_create($opts);
        $html = file_get_html($url, false, $context);

        if (!$html) {
            ob_end_flush();
            echo '<div style="color:red">Empty content</div><script>location.href=\'' . $url_next . '\'</script>';
            die('<div style="color:red">Empty content</div>');
        }

        $block_xs = $html->find('div[class=m0664] table[class=m0806] table[class=e0882 m0816]');

        if (empty($block_xs)) {
            $html->clear();
            $html = NULL;
            unset($html);
            ob_end_flush();
            echo '<div style="color:red">Empty block</div><script>location.href=\'' . $url_next . '\'</script>';
            die('<div style="color:red">Empty block</div>');
        }

        $first_block = $block_xs[0];
        $tr = $first_block->find('tr');

        $pattern = '/'
                . '([0-9]{2})'            // 2 digits
                . '\/'      // /
                . '([0-9]{2})'            // 2 digits
                . '\/'      // /
                . '([0-9]{4})'            // 4 digits
                . '/';
        $ngay = '';
        $ma_giai = 0;
        $data = array();
        $data_b = array();
        $arr_loto = array();
        $data[8] = '';
        $data_b[8] = '';
        foreach ($tr as $count => $v) {
            if (preg_match($pattern, $v->text(), $regs)) {
                $ngay = $regs[3] . '-' . $regs[2] . '-' . $regs[1];

                if ($ngay != $year . '-' . $month . '-' . $day) {
                    $html->clear();
                    $html = NULL;
                    unset($html);
                    ob_end_flush();
                    echo '<div style="color:red">' . $day . '/' . $month . '/' . $year . ' khong co du lieu</div><script>location.href=\'' . $url_next . '\'</script>';
                    die('<div style="color:red">' . $day . '/' . $month . '/' . $year . ' khong co du lieu</div>');
                }
            } elseif ($td = $v->find('table[class=m0816 e0884] img')) {
                if (isset($td[0])) {
                    $code = str_replace(array('/data/image/', '/'), array('', ''), $td[0]->src);
                    $giai = substr($code, -2);
                    $tmp = hexdec(substr($code, 0, strlen($code) - 2));
                    $giai = substr($tmp, 3) . $giai;

                    $data[0] = $giai;
                    $sub = substr($giai, -2, 2);
                    $arr_loto[] = $sub;
                    $data_b[0] = $sub;
                    $ma_giai = 1;
                }
            } else {
                $td = $v->find('table[class=m0816 e0884]');
                if (isset($td[0]) && $td[0]->text() != '') {
                    $giai = '';
                    if ($ma_giai == 1 || $ma_giai == 8) {
                        $giai = $td[0]->text();
                        $sub = substr($giai, -2, 2);
                        $arr_loto[] = $sub;
                        $data_b[$ma_giai] = $sub;
                    } else {
                        $tmp = $td[0]->find('td');
                        if (!empty($tmp) && is_array($tmp)) {
                            foreach ($tmp as $value) {
                                $so = $value->innertext();

                                if ($so == '')
                                    continue;

                                $pos = strpos($so, 'javascript');
                                if ($pos !== false) {
                                    if (preg_match_all('/(r\w+)=\'(\d+,\d+,\d+)\'.split/ism', $so, $capso)) {
                                        if (preg_match('/for\(j=0;j<(.*?).length/ism', $so, $biendau)) {
                                            foreach ($capso[1] as $j => $value) {
                                                if ($biendau[1] == $value) {
                                                    $sodau = explode(',', $capso[2][$j]);
                                                    if ($j == 1) {
                                                        $soduoi = explode(',', $capso[2][0]);
                                                        $so = $sodau[0] . $soduoi[1] . '-' . $sodau[1] . $soduoi[2] . '-' . $sodau[2] . $soduoi[0];
                                                    } else {
                                                        $soduoi = explode(',', $capso[2][1]);
                                                        $so = $sodau[0] . $soduoi[2] . '-' . $sodau[1] . $soduoi[0] . '-' . $sodau[2] . $soduoi[1];
                                                    }
//                                                    var_dump($sodau, $soduoi);
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    if ($so == '')
                                        continue;

                                    $arr_so = explode('-', $so);
                                    foreach ($arr_so as $value) {
                                        if ($value != '') {
                                            $sub = substr($value, -2, 2);
                                            $arr_loto[] = $sub;

                                            if (count($data_b[$ma_giai]) == 0)
                                                $data_b[$ma_giai] = $sub;
                                            else
                                                $data_b[$ma_giai] .= ',' . $sub;
                                        }
                                    }
                                }else {
                                    $sub = substr($so, -2, 2);
                                    $arr_loto[] = $sub;

                                    if (count($data_b[$ma_giai]) == 0)
                                        $data_b[$ma_giai] = $sub;
                                    else
                                        $data_b[$ma_giai] .= ',' . $sub;
                                }
                                $giai.=$so . '-';
                            }
                            $giai = substr($giai, 0, strlen($giai) - 1);
                        }
                    }

                    $data[$ma_giai] = $giai;
                    $ma_giai++;
                }
            }
        }

        if ($data) {
            ksort($data);
            ksort($data_b);

//            var_dump($data, $data_b, $arr_loto);
//            die;

            $duoi0 = "";
            $duoi1 = "";
            $duoi2 = "";
            $duoi3 = "";
            $duoi4 = "";
            $duoi5 = "";
            $duoi6 = "";
            $duoi7 = "";
            $duoi8 = "";
            $duoi9 = "";
            //lay loto duoi
            for ($j = 0; $j < count($arr_loto); $j++) {
                if (substr($arr_loto[$j], 0, 1) == '0') {
                    if ($duoi0 == '')
                        $duoi0 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi0 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '1') {
                    if ($duoi1 == '')
                        $duoi1 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi1 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '2') {
                    if ($duoi2 == '')
                        $duoi2 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi2 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '3') {
                    if ($duoi3 == '')
                        $duoi3 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi3 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '4') {
                    if ($duoi4 == '')
                        $duoi4 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi4 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '5') {
                    if ($duoi5 == '')
                        $duoi5 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi5 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '6') {
                    if ($duoi6 == '')
                        $duoi6 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi6 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '7') {
                    if ($duoi7 == '')
                        $duoi7 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi7 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '8') {
                    if ($duoi8 == '')
                        $duoi8 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi8 .= "," . substr($arr_loto[$j], 1, 1);
                }
                if (substr($arr_loto[$j], 0, 1) == '9') {
                    if ($duoi9 == '')
                        $duoi9 .= substr($arr_loto[$j], 1, 1);
                    else
                        $duoi9 .= "," . substr($arr_loto[$j], 1, 1);
                }
            }

            $extra = array();
            $extra[0] = $duoi0;
            $extra[1] = $duoi1;
            $extra[2] = $duoi2;
            $extra[3] = $duoi3;
            $extra[4] = $duoi4;
            $extra[5] = $duoi5;
            $extra[6] = $duoi6;
            $extra[7] = $duoi7;
            $extra[8] = $duoi8;
            $extra[9] = $duoi9;

            $extension = json_encode($extra);
            $a0 = $data[0];
            $a1 = $data[1];
            $a2 = $data[2];
            $a3 = $data[3];
            $a4 = $data[4];
            $a5 = $data[5];
            $a6 = $data[6];
            $a7 = $data[7];
            $a8 = $data[8];

            $b0 = $data_b[0];
            $b1 = $data_b[1];
            $b2 = $data_b[2];
            $b3 = $data_b[3];
            $b4 = $data_b[4];
            $b5 = $data_b[5];
            $b6 = $data_b[6];
            $b7 = $data_b[7];
            $b8 = $data_b[8];

            if (count($data) < 9) {
                $html->clear();
                $html = NULL;
                unset($html);
                ob_end_flush();
                echo '<div style="color:red">' . $day . '/' . $month . '/' . $year . ' khong co du lieu</div><script>location.href=\'' . $url_next . '\'</script>';
                die('<div style="color:red">' . $day . '/' . $month . '/' . $year . ' khong co du lieu</div>');
            }

            $data = array(
                "extension" => $extension,
                "a0" => $a0,
                "a1" => $a1,
                "a2" => $a2,
                "a3" => $a3,
                "a4" => $a4,
                "a5" => $a5,
                "a6" => $a6,
                "a7" => $a7,
                "a8" => $a8,
                "b0" => $b0,
                "b1" => $b1,
                "b2" => $b2,
                "b3" => $b3,
                "b4" => $b4,
                "b5" => $b5,
                "b6" => $b6,
                "b7" => $b7,
                "b8" => $b8,
            );

            $this->db->where("date", $ngay);
            $this->db->where("lid", $lid);
            $rs_id = $this->db->select('id')->from('xs_crawxs')->get()->row()->id;

            if (!$rs_id) {
                $data["lid"] = $lid;
                $data["date"] = $ngay;
                $this->db->insert('xs_crawxs', $data);
            } else {
                $this->xs_crawxs_model->update($rs_id, $data);
            }

//            echo '--> Xong.';
            echo '<div style="color:red">--> Xong.</div><script>location.href=\'' . $url_next . '\'</script>';
        } else {
            $html->clear();
            $html = NULL;
            unset($html);
            ob_end_flush();
            echo '<div style="color:red">' . $day . '/' . $month . '/' . $year . ' khong co du lieu</div><script>location.href=\'' . $url_next . '\'</script>';
            die('<div style="color:red">' . $day . '/' . $month . '/' . $year . ' khong co du lieu</div>');
        }

        ob_end_flush();
        exit;
    }

    public function convert() {
        //client/live/convert?UUbQpHAK=1&d=2002-01-05
        if (!isset($_GET['UUbQpHAK']))
            die;

        $this->load->model(array("xs_crawxs_model", "xs_result_model"));

        echo '<pre>';

        $date = (isset($_GET['d']) ? $_GET['d'] : date('Y-m-d'));

        $rs = $this->db->select('*')->from('xs_crawxs')->where("date", $date)->get()->result();
        if ($rs) {
            foreach ($rs as $item) {
                $rs_id = $this->db->select('id')
                                ->from('xs_result')
                                ->where("date", $item->date)
                                ->where("lid", $item->lid)
                                ->get()->row()->id;

                $data = array(
                    "extension" => $item->extension,
                    "a0" => $item->a0,
                    "a1" => $item->a1,
                    "a2" => $item->a2,
                    "a3" => $item->a3,
                    "a4" => $item->a4,
                    "a5" => $item->a5,
                    "a6" => $item->a6,
                    "a7" => $item->a7,
                    "a8" => $item->a8,
                    "b0" => $item->b0,
                    "b1" => $item->b1,
                    "b2" => $item->b2,
                    "b3" => $item->b3,
                    "b4" => $item->b4,
                    "b5" => $item->b5,
                    "b6" => $item->b6,
                    "b7" => $item->b7,
                    "b8" => $item->b8,
                    "source" => 1,
                );

                if (!$rs_id) {
                    $data["lid"] = $item->lid;
                    $data["date"] = $item->date;
                    $this->db->insert('xs_result', $data);
                } else {
                    $this->xs_result_model->update($rs_id, $data);
                }
            }

            $next_date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            $url_next = base_url() . 'client/live/convert?UUbQpHAK=1&d=' . $next_date;
            echo '<div style="color:red">--> Xong.</div><script>location.href=\'' . $url_next . '\'</script>';
        }
        echo '<div style="color:red">--> Het.</div>';
        exit;
    }

}
