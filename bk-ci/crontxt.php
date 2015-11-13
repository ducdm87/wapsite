<?php

class crontxt {

    function __construct() {
        $this->_timeMB = '18:05'; //$timer['MB'];
        $this->_timeMT = '17:14'; //$timer['MT'];
        $this->_timeMN = '16:12'; //$timer['MN'];

        $this->_timeMB_end = '20:45';
        $this->_timeMT_end = '20:45'; 
        $this->_timeMN_end = '20:45';

        $this->simple_cache = new Simple_cache();
    }

    function crawtxt($url,$lc) {
//        error_reporting(-1);
        global $_db;
        
        $area = 9;
        $time = date('H:i');
        
        if ($lc == 'mn') {
            $area = 2;
        } elseif ($lc == 'mt') {
            $area = 1;
        } elseif ($lc == 'mb') {
            $area = 0;
        }

        if (isset($_GET['a']))
            $area = (int) $_GET['a'];

        if (isset($_GET['save'])) {
            $data = file_get_contents('http://xoso.com:81/client/live/saveresult?UUbQpHAK=1&area=' . $area); //114
            $this->saveLogtxt('saveresult - ' . $data);
            $data = file_get_contents('http://s213.xoso.com/client/live/sendsms?UUbQpHAK=1&area=' . $area); //213
            $this->saveLogtxt('sendsms - ' . $data);
            $this->saveLogtxt($area . ' - Quay xong.');
            die;
        }

        if ($area < 9) {       	        	
        	$yesterday = strtotime('now') - 86400;
        	
        	if ($time < '12:00') {
        		$date = date('Y-m-d',$yesterday);
        	}else{
            $date = date('Y-m-d');         
        	}        	
            
            if (isset($_GET['date']))
                $date = $_GET['date'];

            $row = null;
            $row = $this->read_xmltxt($area, $date, 1);
            
            
            
            if (!$row || isset($_GET['date'])) {
            	
                $result = null;
                $domain = $url[array_rand($url)];
//print_r($domain);
                $this->saveLogtxt($area . ' - ' . $domain . ' ...');
                
                $result = $this->get_xstttxt_minhngoctxt($area, $domain, 0);
                
                if (isset($_GET['a'])) {
                    var_dump($result);
                }

                if ($result) {
                    $state = 1;
                    foreach ($result as $v) {
                        if ($v['status'] == 0) {
                            $state = 0;
                            break;
                        }
                    }

                    $_tmp = array();
                    $_tmp['area'] = $area;
                    $_tmp['data'] = $result;
                    if ($state == 1) {
                        $this->update_xmltxt($area, $date, $_tmp, $state);
                        sleep(5);
                        $data = file_get_contents('http://xoso.com:81/client/live/saveresult?UUbQpHAK=1&area=' . $area . '&date=' . $date); //114
                        $data = preg_replace('/[^0-9]/', '', $data);
                        $this->saveLogtxt('saveresult - ' . $data);
                        if ($data == 0) {
                            $i = 30;
                            while ($data == 0 && $i > 0) {
                                sleep(5);
                                $data = file_get_contents('http://xoso.com:81/client/live/saveresult?UUbQpHAK=1&area=' . $area . '&date=' . $date); //114
                                $data = preg_replace('/[^0-9]/', '', $data);
                                $this->saveLogtxt('saveresult - ' . $data);
                                $i--;
                            }
                        }
                        $data = file_get_contents('http://s213.xoso.com/client/live/sendsms?UUbQpHAK=1&area=' . $area . '&date=' . $date); //213
                        $data = preg_replace('/[^0-9]/', '', $data);
                        $this->saveLogtxt('sendsms - ' . $data);
                        if ($data == 0) {
                            $i = 30;
                            while ($data == 0 && $i > 0) {
                                sleep(5);
                                $data = file_get_contents('http://s213.xoso.com/client/live/sendsms?UUbQpHAK=1&area=' . $area . '&date=' . $date); //213
                                $data = preg_replace('/[^0-9]/', '', $data);
                                $this->saveLogtxt('sendsms - ' . $data);
                                $i--;
                            }
                        }

                        $this->saveLogtxt($area . ' - Quay xong.');
                        unset($row, $result, $v, $_tmp);
                        die;
                    }
                    unset($row, $result, $v, $_tmp);
//                    var_dump((get_defined_vars()));
                    return true;
                } else {
                    $this->saveLogtxt($area . ' - Ko lay dc du lieu!');
                    unset($row);
                    return false;
                }
            } else {
                die('Da quay xong.');
            }
        } else {
            die('Ko phai gio quay.');
        }
    }

    function read_xmltxt($area, $date, $state) {
        $file = $this->get_file_nametxt($area);
        $data = file_get_contents($file);
        $data = json_decode($data);

        if ($state == 1 || $state == 0) {
            if ($data) {
                if ($data->date == $date && $data->area == $area && $data->state == $state) {
                    return $data;
                }
            }
        } else {
            if ($data) {
                if ($data->date == $date && $data->area == $area) {
                    return $data;
                }
            }
        }

        return NULL;
    }

    function get_file_nametxt($area = NULL) {
        $file = 'mb.txt';
        if ($area == 1)
            $file = 'mt.txt';
        elseif ($area == 2)
            $file = 'mn.txt';

        $file = 'xstt/' . $file;
        if (!file_exists($file)) {
            $fl = fopen($file, 'w');
            fclose($fl);
        }
        return $file;
    }

    function update_xmltxt($area, $date, $cache, $state) {
        if ($area == 0) {
            $filename = 'xstt/xsmb.php';
            if (!file_exists($filename)) {
                $fl = fopen($filename, 'w');
                fclose($fl);
            }
            if (is_writable($filename)) {
                if (!$f = fopen($filename, 'w')) {
                    $this->saveLogtxt('Cannot open file (' . $filename . ')');
                } else {
                    $tmp['data'] = $cache['data']['MB']['data'];
                    $tmp['extra'] = $cache['data']['MB']['extra'];
                    $tmp['status'] = $cache['data']['MB']['status'];
                    $tmp['sec'] = md5(date('d'));

                    $str = '';
                    foreach ($cache['data']['MB']['data_b'] as $k1 => $v1) {
                        if ($v1 != '') {
                            if ($str == '') {
                                $str = $v1;
                            } else {
                                $str .= ',' . $v1;
                            }
                        }
                    }
                    $arr = explode(',', $str);
                    sort($arr);
                    $tmp['data_b'] = $arr;
//                    $count_str = 0;
//                    foreach ($arr as $v1) {
//                        if ($v1 != '**' && $v1 != '++') {
//                            $count_str = $count_str + 1;
//                        }
//                    }
//                    $tmp['count_b'] = $count_str;

                    if (isset($cache['data']['MB']['dtthantai4']))
                        $tmp['dtthantai4'] = $cache['data']['MB']['dtthantai4'];
                    if (isset($cache['data']['MB']['dt123']))
                        $tmp['dt123'] = $cache['data']['MB']['dt123'];
                    if (isset($cache['data']['MB']['dt6x36']))
                        $tmp['dt6x36'] = $cache['data']['MB']['dt6x36'];

                    $str = 'MB(' . json_encode($tmp) . ')';

                    if (fwrite($f, $str) === FALSE) {
                        $this->saveLogtxt('Cannot write to file (' . $filename . ')');
                    } else {
//                        $this->saveLogtxt('Success, wrote to file (' . $filename . ')');
                        fclose($f);
                    }

                    unset($tmp, $str, $k1, $v1, $arr, $filename);
                }
            } else {
                $this->saveLogtxt('The file ' . $filename . ' is not writable');
            }
        }

        $file = $this->get_file_nametxt($area);
        if (is_writable($file)) {
            if (!$f = fopen($file, 'w')) {
                $this->saveLogtxt('Cannot open file (' . $file . ')');
            } else {
                $data = new stdClass();
                $data->area = $area;
                $data->date = $date;
                $data->cache = $cache;
                $data->state = $state;

                $data = json_encode($data);

                if (fwrite($f, $data) === FALSE) {
                    $this->saveLogtxt('Cannot write to file (' . $file . ')');
                } else {
//                    $this->saveLogtxt('Success, wrote to file (' . $file . ')');
                    fclose($f);
                }

                unset($cache, $state, $f, $data, $file);
            }
        } else {
            $this->saveLogtxt('The file ' . $file . ' is not writable');
        }
    }

    function saveLogtxt($str) {
        echo '<p>' . $str . '</p>';
        $f = fopen('xstt/log_' . date('Y-m-d') . '.txt', 'a');
        if ($f) {
            $time = date('[d/m/Y H:i:s] - ');
            fwrite($f, $time . $str . "\n");
            fclose($f);
        }
    }

    function get_ketquavesotxt($area = 0) {
        $link = array(
            'http://ketquaveso.com/ttkq/mien-bac.html?t=',
//            'http://ketquaveso.com/ttkq/mien-trung.html?t=',
//            'http://ketquaveso.com/ttkq/mien-nam.html?t='
        );

        $url = $link[$area] . time();

        $result = array();
        $opts = array('http' => array('header' => 'User-Agent:User-Agent:Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0', 'timeout' => 20));
        $context = stream_context_create($opts);
        $html = file_get_html($url, false, $context);

//        ob_start();
//        $str = ob_get_contents();
//        ob_end_clean();
//        $html = str_get_html($str);

        if (!$html) {
            $this->saveLogtxt('ketquaveso - HTML empty!');
            return null;
        }

//        if ($area == 0)
        $xs_title = $html->find('ul[class=gr-yellow]');
//        else
//            $xs_title = $html->find('ul[class=gr-yellow] li');

        if (!isset($xs_title[0])) {
            $this->saveLogtxt('ul[class=gr-yellow] Not Found!');
            return null;
        }

        $date = '';
        $pattern = '/'
                . '([0-9]{2})'            // 2 digits
                . '-'      // /
                . '([0-9]{2})'            // 2 digits
                . '-'      // /
                . '([0-9]{4})'            // 4 digits
                . '/';
        if (preg_match($pattern, trim($xs_title[0]->text()), $regs))
            $date = $regs[1] . '-' . $regs[2] . '-' . $regs[3];

        if ($date != date('d-m-Y')) {
            $this->saveLogtxt($date . ' khac hom nay - ' . date('d-m-Y'));
            return null;
        }

        $result = array();
        $arr_loc = array();
        $data_list = array();
        $datab_list = array();
        $arr_loto_list = array();
        $status_list = array();
//        if ($area > 0) {
//            $check_loc = true;
//            $area_str = '';
//            if ($area == 1)
//                $area_str = 'MT';
//            elseif ($area == 2)
//                $area_str = 'MN';
//
//            $code_today = array();
//            $location = array();
//            foreach ($this->data['location_today'][$area_str] as $value) {
//                $code_today[] = $value->code;
//                $location[$value->code] = $value;
//            }
//
//            foreach ($xs_title as $i => $value) {
//                if ($i == 0)
//                    continue;
//                $xs_loc = $value->find('span[class=s12]');
//                if (isset($xs_loc[0])) {
//                    $tmp = explode(':', $xs_loc[0]->text());
//                    if (isset($tmp[1])) {
//                        $code = trim($tmp[1]);
//                        if ($code == 'BT')
//                            $code = 'BTR';
//                        elseif ($code == 'QNG')
//                            $code = 'QNI';
//                        elseif ($code == 'DL')
//                            $code = 'LD';
//                        if (in_array($code, $code_today))
//                            $arr_loc[] = $code;
//                        else
//                            $check_loc = false;
//                    } else {
//                        $check_loc = false;
//                    }
//                } else {
//                    $check_loc = false;
//                }
//            }
//
////            $arr_loc = $code_today; //test
//            if ($check_loc == false)
//                return null;
//        } else {
        $arr_loc[0] = 'MB';
//        }
//        if ($area == 0)
        $xs_block = $html->find('ul[class=list-kqmb] li[class=pad5]');
//        else
//            $xs_block = $html->find('ul[class=list-col] li[class=pad5]');

        if (empty($xs_block)) {
            $this->saveLogtxt('ul[class=list-kqmb] li[class=pad5] Not Found!');
            return null;
        }

        foreach ($xs_block as $giai => $item) {
            $arr_so = $item->find('div span');
            foreach ($arr_so as $pos => $value) {
                $so = trim($value->text());
//                if ($area == 0)
                $pos = 0;

                if (!isset($status_list[$arr_loc[$pos]]))
                    $status_list[$arr_loc[$pos]] = 0;
                switch ($giai) {
                    case 0:
                        if ($area == 0 && $so != '')
                            $status_list[$arr_loc[$pos]] = 1;

                        if ($so == '') {
//                            if ($area == 0)
                            $so = '*****';
//                            else
//                                $so = '**';
                        }

                        $k = $giai;
//                        if ($area > 0)
//                            $k = 8;
                        $data_list[$arr_loc[$pos]][$k] = $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;
                        $datab_list[$arr_loc[$pos]][$k] = $sub;
                        break;
                    case 1:
                        if ($so == '') {
//                            if ($area == 0)
                            $so = '*****';
//                            else
//                                $so = '***';
                        }

                        $k = $giai;
//                        if ($area > 0)
//                            $k = 7;
                        $data_list[$arr_loc[$pos]][$k] = $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;
                        $datab_list[$arr_loc[$pos]][$k] = $sub;
                        break;
                    case 2:
                        if ($so == '') {
//                            if ($area == 0)
                            $so = '*****';
//                            else
//                                $so = '****';
                        }

                        $k = $giai;
//                        if ($area > 0) {
//                            $k = 6;
//                            $pos = $pos % count($arr_loc);
//                        }
                        if (!isset($data_list[$arr_loc[$pos]][$k]))
                            $data_list[$arr_loc[$pos]][$k] = $so;
                        else
                            $data_list[$arr_loc[$pos]][$k] .= '-' . $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;

                        if (!isset($datab_list[$arr_loc[$pos]][$k]))
                            $datab_list[$arr_loc[$pos]][$k] = $sub;
                        else
                            $datab_list[$arr_loc[$pos]][$k] .= ',' . $sub;
                        break;
                    case 3:
                        if ($so == '') {
//                            if ($area == 0)
                            $so = '*****';
//                            else
//                                $so = '****';
                        }

                        $k = $giai;
//                        if ($area > 0) {
//                            $k = 5;
//                            $data_list[$arr_loc[$pos]][$k] = $so;
//
//                            $sub = substr($so, -2, 2);
//                            $arr_loto_list[$arr_loc[$pos]][] = $sub;
//                            $datab_list[$arr_loc[$pos]][$k] = $sub;
//                        } else {
                        if (!isset($data_list[$arr_loc[$pos]][$k]))
                            $data_list[$arr_loc[$pos]][$k] = $so;
                        else
                            $data_list[$arr_loc[$pos]][$k] .= '-' . $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;

                        if (!isset($datab_list[$arr_loc[$pos]][$k]))
                            $datab_list[$arr_loc[$pos]][$k] = $sub;
                        else
                            $datab_list[$arr_loc[$pos]][$k] .= ',' . $sub;
//                        }
                        break;
                    case 4:
                        if ($so == '') {
//                            if ($area == 0)
                            $so = '****';
//                            else
//                                $so = '*****';
                        }

                        $k = $giai;
//                        if ($area > 0) {
//                            $pos = $pos % count($arr_loc);
//                        }
                        if (!isset($data_list[$arr_loc[$pos]][$k]))
                            $data_list[$arr_loc[$pos]][$k] = $so;
                        else
                            $data_list[$arr_loc[$pos]][$k] .= '-' . $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;

                        if (!isset($datab_list[$arr_loc[$pos]][$k]))
                            $datab_list[$arr_loc[$pos]][$k] = $sub;
                        else
                            $datab_list[$arr_loc[$pos]][$k] .= ',' . $sub;
                        break;
                    case 5:
                        if ($so == '') {
//                            if ($area == 0)
                            $so = '****';
//                            else
//                                $so = '*****';
                        }

                        $k = $giai;
//                        if ($area > 0) {
//                            $k = 3;
//                            $pos = $pos % count($arr_loc);
//                        }
                        if (!isset($data_list[$arr_loc[$pos]][$k]))
                            $data_list[$arr_loc[$pos]][$k] = $so;
                        else
                            $data_list[$arr_loc[$pos]][$k] .= '-' . $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;

                        if (!isset($datab_list[$arr_loc[$pos]][$k]))
                            $datab_list[$arr_loc[$pos]][$k] = $sub;
                        else
                            $datab_list[$arr_loc[$pos]][$k] .= ',' . $sub;
                        break;
                    case 6:
                        if ($so == '') {
//                            if ($area == 0)
                            $so = '***';
//                            else
//                                $so = '*****';
                        }

                        $k = $giai;
//                        if ($area > 0) {
//                            $k = 2;
//                            $data_list[$arr_loc[$pos]][$k] = $so;
//
//                            $sub = substr($so, -2, 2);
//                            $arr_loto_list[$arr_loc[$pos]][] = $sub;
//                            $datab_list[$arr_loc[$pos]][$k] = $sub;
//                        } else {
                        if (!isset($data_list[$arr_loc[$pos]][$k]))
                            $data_list[$arr_loc[$pos]][$k] = $so;
                        else
                            $data_list[$arr_loc[$pos]][$k] .= '-' . $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;

                        if (!isset($datab_list[$arr_loc[$pos]][$k]))
                            $datab_list[$arr_loc[$pos]][$k] = $sub;
                        else
                            $datab_list[$arr_loc[$pos]][$k] .= ',' . $sub;
//                        }
                        break;
                    case 7:
                        if ($so == '') {
//                            if ($area == 0)
                            $so = '**';
//                            else
//                                $so = '*****';
                        }

                        $k = $giai;
//                        if ($area > 0) {
//                            $k = 1;
//                            $data_list[$arr_loc[$pos]][$k] = $so;
//
//                            $sub = substr($so, -2, 2);
//                            $arr_loto_list[$arr_loc[$pos]][] = $sub;
//                            $datab_list[$arr_loc[$pos]][$k] = $sub;
//                        } else {
                        if (!isset($data_list[$arr_loc[$pos]][$k]))
                            $data_list[$arr_loc[$pos]][$k] = $so;
                        else
                            $data_list[$arr_loc[$pos]][$k] .= '-' . $so;

                        $sub = substr($so, -2, 2);
                        $arr_loto_list[$arr_loc[$pos]][] = $sub;

                        if (!isset($datab_list[$arr_loc[$pos]][$k]))
                            $datab_list[$arr_loc[$pos]][$k] = $sub;
                        else
                            $datab_list[$arr_loc[$pos]][$k] .= ',' . $sub;
//                        }
                        break;
//                    case 8:
//                        if ($area > 0) {
//                            if ($so != '')
//                                $status_list[$arr_loc[$pos]] = 1;
//
//                            if ($so == '')
//                                $so = '******';
//
//                            $data_list[$arr_loc[$pos]][0] = $so;
//
//                            $sub = substr($so, -2, 2);
//                            $arr_loto_list[$arr_loc[$pos]][] = $sub;
//                            $datab_list[$arr_loc[$pos]][0] = $sub;
//                        }
//                        break;

                    default:
                        break;
                }
            }
        }
//        if ($area == 0) {
        $code = 'MB';
        $result[$code]['lid'] = 1;
        $result[$code]['area'] = $area;
        $result[$code]['code'] = $code;
        $result[$code]['name'] = 'Miền Bắc';
        $result[$code]['alias'] = 'xo-so-mien-bac';

        $data_list[$code][8] = '';
        $datab_list[$code][8] = '';

        ksort($data_list[$code]);
        ksort($datab_list[$code]);

        $result[$code]['data'] = $data_list[$code];
        $result[$code]['data_b'] = $datab_list[$code];
        $result[$code]['extra'] = $this->getExtratxt($arr_loto_list[$code]);
        $result[$code]['status'] = $status_list[$code];
//        } else {
//            foreach ($arr_loc as $code) {
//                $result[$code]['lid'] = $location[$code]->id;
//                $result[$code]['area'] = $area;
//                $result[$code]['code'] = $code;
//                $result[$code]['name'] = $location[$code]->name;
//                $result[$code]['alias'] = $location[$code]->alias;
//
//                ksort($data_list[$code]);
//                ksort($datab_list[$code]);
//
//                $result[$code]['data'] = $data_list[$code];
//                $result[$code]['data_b'] = $datab_list[$code];
//                $result[$code]['extra'] = $this->getExtratxt($arr_loto_list[$code]);
//                $result[$code]['status'] = $status_list[$code];
//            }
//        }

        $html->clear();
        unset($html);

        unset($arr_loc, $link, $url, $data_list, $datab_list, $arr_loto_list, $status_list);
        unset($xs_title, $xs_block, $giai, $item, $arr_so, $http_response_header);
        unset($opts, $context, $date, $pattern, $regs, $pos, $value, $so, $k, $sub, $code);
//        var_dump((get_defined_vars()));
//        var_dump($result);
//        die;

        return $result;
    }

    function getExtratxt($arr_loto) {
        $result = array();

        $result[0] = '';
        $result[1] = '';
        $result[2] = '';
        $result[3] = '';
        $result[4] = '';
        $result[5] = '';
        $result[6] = '';
        $result[7] = '';
        $result[8] = '';
        $result[9] = '';

        //lay loto duoi
        $total = count($arr_loto);
        for ($j = 0; $j < $total; $j++) {
            $dau = substr($arr_loto[$j], 0, 1);
            $duoi = substr($arr_loto[$j], 1, 1);
            if ($dau == '0') {
                if ($result[0] == '')
                    $result[0] = $duoi;
                else
                    $result[0] .= ',' . $duoi;
            }elseif ($dau == '1') {
                if ($result[1] == '')
                    $result[1] = $duoi;
                else
                    $result[1] .= ',' . $duoi;
            }elseif ($dau == '2') {
                if ($result[2] == '')
                    $result[2] = $duoi;
                else
                    $result[2] .= ',' . $duoi;
            }elseif ($dau == '3') {
                if ($result[3] == '')
                    $result[3] = $duoi;
                else
                    $result[3] .= ',' . $duoi;
            }elseif ($dau == '4') {
                if ($result[4] == '')
                    $result[4] = $duoi;
                else
                    $result[4] .= ',' . $duoi;
            }elseif ($dau == '5') {
                if ($result[5] == '')
                    $result[5] = $duoi;
                else
                    $result[5] .= ',' . $duoi;
            }elseif ($dau == '6') {
                if ($result[6] == '')
                    $result[6] = $duoi;
                else
                    $result[6] .= ',' . $duoi;
            }elseif ($dau == '7') {
                if ($result[7] == '')
                    $result[7] = $duoi;
                else
                    $result[7] .= ',' . $duoi;
            }elseif ($dau == '8') {
                if ($result[8] == '')
                    $result[8] = $duoi;
                else
                    $result[8] .= ',' . $duoi;
            }elseif ($dau == '9') {
                if ($result[9] == '')
                    $result[9] = $duoi;
                else
                    $result[9] .= ',' . $duoi;
            }
        }

        return $result;
    }

    function get_xstttxt($area = 2) {//114
        $link = array(
            'http://xoso.com:81/xoso_mobile/ttttmb.php',
            'http://xoso.com:81/xoso_mobile/ttttmt.php',
            'http://xoso.com:81/xoso_mobile/ttttmn.php'
        );

        $result = array();
        $xml = simplexml_load_file($link[$area], 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($area > 0) {
            foreach (get_object_vars($xml) as $code => $item) {
                $data = array();
                $data_b = array();
                $result[$code]['area'] = $area;
                $result[$code]['code'] = $code;
                $result[$code]['status'] = 0;

                if (!$this->simple_cache->is_cached('location-' . $code)) {
                    $this->saveLogtxt('Location ' . $tinh . ' Not Found!');
                    return null;
                } else {
                    $_list = $this->simple_cache->get_item('location-' . $code);
                }

                if ($_list) {
                    $result[$code]['lid'] = $_list->id;
                    $result[$code]['name'] = $_list->name;
                    $result[$code]['alias'] = $_list->alias;
                } else {
                    $this->saveLogtxt('Location ' . $tinh . ' Not Found!');
                    return null;
                }
                foreach (get_object_vars($item) as $k => $v) {
                    $v = trim($v);
                    if (isset($titleList[$k])) {
                        $k = $titleList[$k];
                    } else if (preg_match('/dau(\d)/ism', $k, $matche)) {
                        $k = $matche[1];
                        $result[$code]['extra'][$k] = $v;
                    } else if (preg_match('/giai([\w]+)/ism', $k, $matche)) {
                        if ($matche[1] != 'dacbiet') {
                            if (($k == 'giaidacbietsauso' || $k == 'giaidacbiet') && ($v == '.?' || $v == '.?.'))
                                $v = '******';
                            elseif (($k == 'giainhat' || $k == 'giainhi') && $v == '?.')
                                $v = '*****';
                            elseif ($k == 'giaiba')
                                $v = str_replace('?', '*****', $v);
                            elseif ($k == 'giaitu')
                                $v = str_replace('?', '*****', $v);
                            elseif ($k == 'giainam' && $v == '?.')
                                $v = '****';
                            elseif ($k == 'giaisau')
                                $v = str_replace('?', '****', $v);
                            elseif ($k == 'giaibay' && $v == '?.')
                                $v = '***';
                            elseif ($k == 'giaitam' && $v == '?.')
                                $v = '**';

                            $data[] = $v;
                            $arr_v = explode('-', $v);
                            if ($arr_v) {
                                $arr_data_b = array();
                                foreach ($arr_v as $value) {
                                    $arr_data_b[] = substr($value, -2, 2);
                                }
                                $data_b[] = implode(',', $arr_data_b);
                            }
                        }
                    } else if (preg_match('/status/ism', $k, $matche)) {
                        if ($v == 'quayxong')
                            $result[$code]['status'] = 1;
                    }
                }

                if (!isset($data[8]))
                    $data[8] = '';
                if (!isset($data_b[8]))
                    $data_b[8] = '';

                $result[$code]['data'] = $data;
                $result[$code]['data_b'] = $data_b;
            }
        } else {
            $code = 'MB';
            $result[$code]['area'] = $area;
            $result[$code]['code'] = $code;
            $result[$code]['status'] = 0;
            $result[$code]['lid'] = 1;
            $result[$code]['name'] = 'Miền Bắc';
            $result[$code]['alias'] = 'xo-so-mien-bac';
            $data = array();
            $data_b = array();
            foreach (get_object_vars($xml) as $k => $v) {
                if (strpos($k, '@') === 0) {
                    continue;
                }
                $k = trim($k);
                $v = trim($v);
                if (isset($titleList[$k])) {
                    $k = $titleList[$k];
                } else if (preg_match('/dau(\d)/ism', $k, $matche)) {
                    $k = $matche[1];
                    $result[$code]['extra'][$k] = $v;
                } else if (preg_match('/giai([\w]+)/ism', $k, $matche)) {
                    if ($v == '.?.')
                        $v = '*****';
                    elseif ($v == '?-?')
                        $v = '*****-*****';
                    elseif ($k == 'giaiba')
                        $v = str_replace('?', '*****', $v);
                    elseif ($k == 'giaitu' || $k == 'giainam')
                        $v = str_replace('?', '****', $v);
                    elseif ($k == 'giaisau')
                        $v = str_replace('?', '***', $v);
                    elseif ($k == 'giaibay')
                        $v = str_replace('?', '**', $v);

                    $data[] = $v;
                    $arr_v = explode('-', $v);
                    if ($arr_v) {
                        $arr_data_b = array();
                        foreach ($arr_v as $value) {
                            $arr_data_b[] = substr($value, -2, 2);
                        }
                        $data_b[] = implode(',', $arr_data_b);
                    }
                } else if (preg_match('/status/ism', $k, $matche)) {
                    if ($v == 'quayxong')
                        $result[$code]['status'] = 1;
                }
            }

            if (!isset($data[8]))
                $data[8] = '';
            if (!isset($data_b[8]))
                $data_b[8] = '';

            $result[$code]['data'] = $data;
            $result[$code]['data_b'] = $data_b;
        }
        return $result;
    }

    function get_xstttxt_minhngoctxt($area = 2, $domain = '', $sendSMS = 0) {
        $link = array(
            $domain . 'xstt/MB/MB.php?visit=0',
            $domain . 'xstt/MT/MT.php?visit=0',
            $domain . 'xstt/MN/MN.php?visit=0'
        );

        $result = array();
//         $html = $this->curl_page2txt($link[$area]);
        $html = file_get_contents($link[$area]);
       
// 		var_dump($html);die;
        if ($html) {
            $rs_array = explode(';', $html);
        } else {
            $this->saveLogtxt($link[$area] . ' - HTML empty!');
            unset($html);
            return null;
        }

        if ($rs_array[0] != 'runtt=1') {
            $this->saveLogtxt('"runtt=1" Not Found!');
            unset($html);
            return null;
        }
		
        $rs_array[1] = str_replace('"', '', $rs_array[1]);
        list($var, $arr_tinh) = explode('=', $rs_array[1]);
        $arr_tinh = explode(',', $arr_tinh);
// 		var_dump($link[$area]);die;
        foreach ($arr_tinh as $tinh) {
            if ($area > 0) {
                if (!$this->simple_cache->is_cached('location' . $tinh)) {
                    $this->saveLogtxt('Location ' . $tinh . ' Not Found!');
                    return null;
                } else {
                    $_list = $this->simple_cache->get_item('location' . $tinh);
                }
                $code = $_list->code;
                $result[$code]['lid'] = $_list->id;
                $result[$code]['name'] = $_list->name;
                $result[$code]['alias'] = $_list->alias;
            } else {
                $code = 'MB';
                $result[$code]['lid'] = 1;
                $result[$code]['name'] = 'Miền Bắc';
                $result[$code]['alias'] = 'xo-so-mien-bac';
            }

            $result[$code]['area'] = $area;
            $result[$code]['code'] = $code;
            $data = array();
            $data_b = array();
            $arr_loto = array();
            $data[8] = '';
            $data_b[8] = '';
            foreach ($rs_array as $value) {
                list($tengiai, $so) = explode('=', $value);
                $tengiai = trim($tengiai);
                $so = trim(str_replace('"', '', $so));
                if ($tengiai == 'kqxs["T' . $tinh . '_G8"]') {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;
                    $data_b[8] = $sub;
                    $data[8] = $so;
//                    } elseif (preg_match('/^kqxs\["T' . $tinh . '_G7/ism', $tengiai)) {
                } elseif (strpos($tengiai, 'kqxs["T' . $tinh . '_G7') !== false) {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;

                    if (!isset($data_b[7]))
                        $data_b[7] = $sub;
                    else
                        $data_b[7] .= ',' . $sub;

                    if (!isset($data[7]))
                        $data[7] = $so;
                    else
                        $data[7] .= '-' . $so;
//                    }elseif (preg_match('/^kqxs\["T' . $tinh . '_G6/ism', $tengiai)) {
                } elseif (strpos($tengiai, 'kqxs["T' . $tinh . '_G6') !== false) {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;

                    if (!isset($data_b[6]))
                        $data_b[6] = $sub;
                    else
                        $data_b[6] .= ',' . $sub;

                    if (!isset($data[6]))
                        $data[6] = $so;
                    else
                        $data[6] .= '-' . $so;
//                    }elseif (preg_match('/^kqxs\["T' . $tinh . '_G5/ism', $tengiai)) {
                } elseif (strpos($tengiai, 'kqxs["T' . $tinh . '_G5') !== false) {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;

                    if (!isset($data_b[5]))
                        $data_b[5] = $sub;
                    else
                        $data_b[5] .= ',' . $sub;

                    if (!isset($data[5]))
                        $data[5] = $so;
                    else
                        $data[5] .= '-' . $so;
//                    }elseif (preg_match('/^kqxs\["T' . $tinh . '_G4/ism', $tengiai)) {
                } elseif (strpos($tengiai, 'kqxs["T' . $tinh . '_G4') !== false) {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;

                    if (!isset($data_b[4]))
                        $data_b[4] = $sub;
                    else
                        $data_b[4] .= ',' . $sub;

                    if (!isset($data[4]))
                        $data[4] = $so;
                    else
                        $data[4] .= '-' . $so;
//                    }elseif (preg_match('/^kqxs\["T' . $tinh . '_G3/ism', $tengiai)) {
                } elseif (strpos($tengiai, 'kqxs["T' . $tinh . '_G3') !== false) {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;

                    if (!isset($data_b[3]))
                        $data_b[3] = $sub;
                    else
                        $data_b[3] .= ',' . $sub;

                    if (!isset($data[3]))
                        $data[3] = $so;
                    else
                        $data[3] .= '-' . $so;
//                    }elseif (preg_match('/^kqxs\["T' . $tinh . '_G2/ism', $tengiai)) {
                } elseif (strpos($tengiai, 'kqxs["T' . $tinh . '_G2') !== false) {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;

                    if (!isset($data_b[2]))
                        $data_b[2] = $sub;
                    else
                        $data_b[2] .= ',' . $sub;

                    if (!isset($data[2]))
                        $data[2] = $so;
                    else
                        $data[2] .= '-' . $so;
                }elseif ($tengiai == 'kqxs["T' . $tinh . '_G1"]') {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;
                    $data_b[1] = $sub;
                    $data[1] = $so;
                } elseif ($tengiai == 'kqxs["T' . $tinh . '_Gdb"]') {
                    $sub = substr($so, -2, 2);
                    $arr_loto[] = $sub;
                    $data_b[0] = $sub;
                    $data[0] = $so;
                }
                if ($area == 0) {
                    if ($tengiai == 'kqxs["Tdttt4_G1"]')
                        $result[$code]['dtthantai4'] = $so;
                    elseif ($tengiai == 'kqxs["Tdt123_G1"]')
                        $result[$code]['dt123'][0] = $so;
                    elseif ($tengiai == 'kqxs["Tdt123_G2"]')
                        $result[$code]['dt123'][1] = $so;
                    elseif ($tengiai == 'kqxs["Tdt123_G3"]')
                        $result[$code]['dt123'][2] = $so;
                    elseif ($tengiai == 'kqxs["Tdt6x36_G1"]')
                        $result[$code]['dt6x36'][0] = $so;
                    elseif ($tengiai == 'kqxs["Tdt6x36_G2"]')
                        $result[$code]['dt6x36'][1] = $so;
                    elseif ($tengiai == 'kqxs["Tdt6x36_G3"]')
                        $result[$code]['dt6x36'][2] = $so;
                    elseif ($tengiai == 'kqxs["Tdt6x36_G4"]')
                        $result[$code]['dt6x36'][3] = $so;
                    elseif ($tengiai == 'kqxs["Tdt6x36_G5"]')
                        $result[$code]['dt6x36'][4] = $so;
                    elseif ($tengiai == 'kqxs["Tdt6x36_G6"]')
                        $result[$code]['dt6x36'][5] = $so;
                }
            }
			
//var_dump($data);
//echo "xuongday";
            ksort($data);
            ksort($data_b);
            $result[$code]['data'] = $data;
            $result[$code]['data_b'] = $data_b;
            $result[$code]['extra'] = $this->getExtratxt($arr_loto);

            $status = 0;
            if (strpos($data[0], '*') === false && strpos($data[0], '+') === false)
                $status = 1;

//                if ($sendSMS == 1) {
//                    if ($status == 1) {
//                        //gui tin nhan den cac so dien thoai dang ky nhan KQXS 30 ngay
////                        $this->sendSMS_KQXS($code, $result[$code]['data']);
//                        $this->sendSMS_KQXS_($code, $result[$code]['data']);
//                        //gui tin nhan tung giai den cac so dien thoai dang ky TTTT
////                        $this->sendSMS_TTXS($code, $result[$code]['data']);
//                        $this->sendSMS_TTXS_($code, $result[$code]['data']);
//                    } else {
//                        //gui tin nhan tung giai den cac so dien thoai dang ky TTTT
////                        $this->sendSMS_TTXS($code, $result[$code]['data']);
//                        $this->sendSMS_TTXS_($code, $result[$code]['data']);
//                    }
//                }

            $result[$code]['status'] = $status;
        }

//        $this->saveLogtxt('Location today: ' . json_encode($arr_tinh));

        unset($link, $html, $rs_array, $arr_tinh, $var, $tinh, $_list, $code, $data, $data_b, $arr_loto, $value, $so, $tengiai, $sub, $status);
//        var_dump((get_defined_vars()));
//        var_dump($result);
//        die;
        return $result;
    }

    function curl_page2txt($url) {
        $referer = 'http://www.google.com/';
        $useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0';
        $timeout = 20;
        $connecttimeout = 5;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connecttimeout);
        $html_content = curl_exec($ch);
        curl_close($ch);
 //var_dump($html_content);
        return $html_content;
    }

}