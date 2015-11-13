<?php

class cron {

    function __construct() {
        $this->_timeMB = '18:10';
        $this->_timeMT = '17:14';
        $this->_timeMN = '16:12';

        $this->_timeMB_end = '19:00';
        $this->_timeMT_end = '18:00';
        $this->_timeMN_end = '17:00';

        $this->simple_cache = new Simple_cache();

        if (isset($_GET['url']) && $_GET['url'] == 1) {
            $this->_domain = 'http://www.minhngoc.net.vn/';
        } else {
            $this->_domain = 'http://minhngoc.net.vn/';
        }

//        $url = 'http://cms.kienthuc.net.vn/zoomh/500/uploaded/ngoctuan/2014_07_02/tàu điện/1_viaf.jpg';
//        $url = urlencode($url);
//        echo $url . '<br/>';
//        $url = str_replace(array('%3A', '%2F', '+'), array(':', '/', ' '), $url);
//        echo $url;
//        die;
    }

    function craw() {
//        error_reporting(-1);
        global $_db;

        $area = 9;
        $time = date('H:i');
        if ($time >= $this->_timeMN && $time < $this->_timeMN_end) {
            $area = 2;
        } elseif ($time >= $this->_timeMT && $time < $this->_timeMT_end) {
            $area = 1;
        } elseif ($time >= $this->_timeMB && $time < $this->_timeMB_end) {
            $area = 0;
        }

        if (isset($_GET['a']))
            $area = (int) $_GET['a'];

        if ($area == 0) {
            $row = $this->getLastRow(1);
            if (!$row) {
                if (isset($_GET['url']) && $_GET['url'] == 2) {
                    $this->saveLog($area . ' - ketquaveso');
                    $result = $this->get_ketquaveso($area, null);
                    return $result;
                }
                $this->saveLog($area . ' - minhngoc');
                $result = $this->get_xstt_minhngoc($area, null);
                return $result;
            } else {
                if ($row->magiai == 9) {
                    file_get_contents('http://xoso.com:81/live.php?898=1'); //114
                    $_db->close();
                    die('Da quay xong.');
                }

                if (isset($_GET['url']) && $_GET['url'] == 2) {
                    $this->saveLog($area . ' - ketquaveso');
                    $result = $this->get_ketquaveso($area, $row);
                    return $result;
                }
                $this->saveLog($area . ' - minhngoc');
                $result = $this->get_xstt_minhngoc($area, $row);
                return $result;
            }
        } elseif ($area == 1 || $area == 2) {
            if (!$this->simple_cache->is_cached('location')) {
                $query = 'SELECT id,name,alias,code,lich,id_tinh,area FROM xs_location ORDER BY ordering ASC';
                $_db->setQuery($query);
                $result = $_db->loadObjectList();
                $location = array();
                foreach ($result as $value) {
                    if ($value->area != 'MB') {
                        $value->id_tinh = str_replace(',', '', $value->id_tinh);
                        if ($value->area == 'MT')
                            $value->area = 1;
                        elseif ($value->area == 'MN')
                            $value->area = 2;
                        for ($i = 1; $i <= 7; $i++) {
                            if (strpos($value->lich, strval($i)) !== false)
                                $location[$value->area][$i][] = $value;
                        }
                    }
                }

                // store in cache
                $this->simple_cache->cache_item('location', $location);
            } else {
                $location = $this->simple_cache->get_item('location');
            }
            $today = strval(date('w') + 1);
            $location_today = $location[$area][$today];

            if ($area == 2 && isset($_GET['url']) && $_GET['url'] == 3) {
                $html = $this->curl_page2('http://vesophuongtrang.com/doi_ve_trung.php', 1);
                // get cookie
                $m = array();
                preg_match('/^Set-Cookie:\s*([^;]*)/mi', $html, $m);
                $cookies = array();
                parse_str($m[1], $cookies);

                if (isset($cookies['PHPSESSID'])) {
                    $cookie = 'PHPSESSID=' . $cookies['PHPSESSID'] . '; path=/';
                    $html = $this->curl_page2('http://vesophuongtrang.com/tools/cap_nhat_truc_tiep.php?new=', 0, $cookie);
                } else {
                    return true;
                }

//                if (!$html) {
//                    $this->saveLog('vesophuongtrang - HTML empty!');
//                    unset($html);
//                    return false;
//                }

                if (strpos($html, '<-!->') === false) {
                    $this->saveLog('"<-!->" Not Found!');
                    unset($html);
                    return true;
                }
            } else {
                $link = array(
                    $this->_domain . 'xstt/MB/MB.php?visit=0',
                    $this->_domain . 'xstt/MT/MT.php?visit=0',
                    $this->_domain . 'xstt/MN/MN.php?visit=0'
                );

                $html = $this->curl_page2($link[$area]);

                if (!$html) {
                    $this->saveLog($link[$area] . ' - HTML empty!');
                    unset($html);
                    return false;
                }

                if (strpos($html, 'runtt=1') === false) {
                    $this->saveLog('"runtt=1" Not Found!');
                    unset($html);
                    return true;
                }
            }

            $check_finished = true;
            foreach ($location_today as $value) {
                $row = $this->getLastRow($value->id);
                if (!$row) {
                    $check_finished = false;
                    if ($area == 2 && isset($_GET['url']) && $_GET['url'] == 3)
                        $this->get_vesophuongtrang($area, null, $html, $value);
                    else
                        $this->get_xstt_minhngocMN($area, null, $html, $value);
                } else {
                    if ($row->magiai != 0) {
                        $check_finished = false;
                        if ($area == 2 && isset($_GET['url']) && $_GET['url'] == 3)
                            $this->get_vesophuongtrang($area, $row, $html, $value);
                        else
                            $this->get_xstt_minhngocMN($area, $row, $html, $value);
                    }
                }
            }

            if ($check_finished) {
                file_get_contents('http://xoso.com:81/live.php?898=1'); //114
                $_db->close();
                die('Da quay xong.');
            }

            if ($area == 2 && isset($_GET['url']) && $_GET['url'] == 3)
                $this->saveLog($area . ' - vesophuongtrang');
            else
                $this->saveLog($area . ' - minhngoc');
            return true;
        } else {
            $_db->setQuery('TRUNCATE TABLE xs_live');
            $_db->query();
            $_db->close();
            die('Ko phai gio quay.');
        }
    }

    function getLastRow($matinh) {
        global $_db;

        $result = null;

        if ($matinh == 1)
            $query = 'SELECT matinh,magiai,thutu,giai,created FROM xs_live ORDER BY created DESC,magiai DESC,thutu DESC LIMIT 1';
        else
            $query = 'SELECT matinh,magiai,thutu,giai,created FROM xs_live WHERE matinh=' . $matinh . ' ORDER BY created DESC,magiai ASC,thutu DESC LIMIT 1';

        $row = $_db->setQuery($query);
        $row = $_db->loadObject($result);
        return $result;
    }

    function saveLog($str) {
        echo '<p>' . $str . '</p>';
        $f = fopen('log/cron_' . date('Y-m-d') . '.txt', 'a');
        if ($f) {
            $time = date('[d/m/Y H:i:s] - ');
            fwrite($f, $time . $str . "\n");
            fclose($f);
        }
    }

    function get_vesophuongtrang($area, $row, $html, $item) {
        global $_db;

        $this->_domain = 'http://vesophuongtrang.com/';

        $arr_tinh = array();
        $arr_tinh[2] = 2; //Tp. Hồ Chí Minh
        $arr_tinh[3] = 12; //Cà Mau
        $arr_tinh[4] = 30; //Đồng Tháp
        $arr_tinh[7] = 14; //Bạc Liêu
        $arr_tinh[8] = 13; //Bến Tre
        $arr_tinh[9] = 3; //Vũng Tàu
        $arr_tinh[12] = 15; //Đồng Nai
        $arr_tinh[13] = 17; //Sóc Trăng
        $arr_tinh[14] = 16; //Cần Thơ            
        $arr_tinh[17] = 19; //Bình Thuận
        $arr_tinh[18] = 1; //An Giang
        $arr_tinh[19] = 18; //Tây Ninh
        $arr_tinh[23] = 9; //Bình Dương
        $arr_tinh[24] = 21; //Trà Vinh
        $arr_tinh[25] = 20; //Vĩnh Long
        $arr_tinh[28] = 23; //Bình Phước
        $arr_tinh[29] = 24; //Hậu Giang
        $arr_tinh[30] = 22; //Long An
        $arr_tinh[33] = 26; //Kiên Giang
        $arr_tinh[34] = 27; //Lâm Đồng
        $arr_tinh[35] = 25; //Tiền Giang

        $tinh = $arr_tinh[$item->id];

        $magiai = 8;
        $thutu = 0;
        if ($row) {
            $magiai = $row->magiai;
            $thutu = $row->thutu;
            if ($row->thutu > 0)
                $thutu = $row->thutu - 1;
        }

        $tmp = array();
        if (preg_match('/<-\!->' . $tinh . '(<-->.*?8<->.*?<-->)/is', $html, $tmp))
            $html = $tmp[1];
        else
            return true;

        if (preg_match('/<-->' . $magiai . '<->(.*?)<-->/is', $html, $tmp)) {
            $arr_value = explode('<>', $tmp[1]);
            if (isset($arr_value[$thutu]) && strpos($arr_value[$thutu], '-') === false)
                $value = $arr_value[$thutu];
            else
                return true;

            if (!$row) {
                $_db->setQuery('INSERT IGNORE INTO xs_live SET
                            matinh=' . $item->id . '
                            ,magiai=8
                            ,giai=\'' . $value . '\'
                            ,source=\'' . $this->_domain . '\'
                            ,created=' . time() . '
                        ');
                $_db->query();
                $this->saveLog($area . ' - ' . $item->id . '.8 : ' . $value);
            } else {
                if ($row->giai != $value) {
                    $_db->setQuery('UPDATE xs_live SET
                            giai=\'' . $value . '\'
                            ,created=' . time() . '
                            WHERE matinh=' . $item->id . ' AND magiai=' . $row->magiai . ' AND thutu=' . $row->thutu . '
                        ');
                    $_db->query();
                    $this->saveLog($area . ' - ' . $item->id . '.' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                }
//                var_dump($row->magiai, $row->thutu);
                if ($row->magiai == 8)
                    $row->magiai = 7;
                elseif ($row->magiai == 7)
                    $row->magiai = 6;
                elseif ($row->magiai == 6 && $row->thutu == 3) {
                    $row->magiai = 5;
                    $row->thutu = 0;
                } elseif ($row->magiai == 5) {
                    $row->magiai = 4;
                    $row->thutu = 0;
                } elseif ($row->magiai == 4 && $row->thutu == 7) {
                    $row->magiai = 3;
                    $row->thutu = 0;
                } elseif ($row->magiai == 3 && $row->thutu == 2) {
                    $row->magiai = 2;
                    $row->thutu = 0;
                } elseif ($row->magiai == 2) {
                    $row->magiai = 1;
                    $row->thutu = 0;
                } elseif ($row->magiai == 1) {
                    $row->magiai = 0;
                    $row->thutu = 0;
                }

                if ($row->magiai == 6 || $row->magiai == 4 || $row->magiai == 3)
                    $row->thutu = $row->thutu + 1;

                $magiai = $row->magiai;
                $thutu = $row->thutu;
                if ($row->thutu > 0)
                    $thutu = $row->thutu - 1;
//                var_dump($row->magiai, $row->thutu);

                if (preg_match('/<-->' . $magiai . '<->(.*?)<-->/is', $html, $tmp)) {
                    $arr_value = explode('<>', $tmp[1]);
                    if (isset($arr_value[$thutu]) && strpos($arr_value[$thutu], '-') === false)
                        $value = $arr_value[$thutu];
                    else
                        return true;

                    $_db->setQuery('INSERT IGNORE INTO xs_live SET
                            matinh=' . $item->id . '
                            ,magiai=' . $row->magiai . '
                            ,thutu=' . $row->thutu . '
                            ,giai=\'' . $value . '\'
                            ,source=\'' . $this->_domain . '\'
                            ,created=' . time() . '
                        ');
                    $_db->query();
                    $this->saveLog($area . ' - ' . $item->id . '.' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                }
            }
        }
        return true;
    }

    function get_xstt_minhngocMN($area, $row, $html, $item) {
        global $_db;

        $tinh = $item->id_tinh;

        $magiai = 8;
        $thutu = 0;
        if ($row) {
            $magiai = $row->magiai;
            if ($magiai == 0)
                $magiai = 'db';
            $thutu = $row->thutu;
        }

        if ($thutu == 0)
            $pattern = '/kqxs\["T' . $tinh . '_G' . $magiai . '"\]="(\d+)";/is';
        else
            $pattern = '/kqxs\["T' . $tinh . '_G' . $magiai . '_' . $thutu . '"\]="(\d+)";/is';

        $tmp = array();
        if (preg_match($pattern, $html, $tmp)) {
            $value = $tmp[1];

            if (!$row) {
                $_db->setQuery('INSERT IGNORE INTO xs_live SET
                            matinh=' . $item->id . '
                            ,magiai=8
                            ,giai=\'' . $value . '\'
                            ,source=\'' . $this->_domain . '\'
                            ,created=' . time() . '
                        ');
                $_db->query();
                $this->saveLog($area . ' - ' . $item->id . '.8 : ' . $value);
            } else {
                if ($row->giai != $value) {
                    $_db->setQuery('UPDATE xs_live SET
                            giai=\'' . $value . '\'
                            ,created=' . time() . '
                            WHERE matinh=' . $item->id . ' AND magiai=' . $row->magiai . ' AND thutu=' . $row->thutu . '
                        ');
                    $_db->query();
                    $this->saveLog($area . ' - ' . $item->id . '.' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                }
//                var_dump($row->magiai, $row->thutu);
                if ($row->magiai == 8)
                    $row->magiai = 7;
                elseif ($row->magiai == 7)
                    $row->magiai = 6;
                elseif ($row->magiai == 6 && $row->thutu == 3) {
                    $row->magiai = 5;
                    $row->thutu = 0;
                } elseif ($row->magiai == 5) {
                    $row->magiai = 4;
                    $row->thutu = 0;
                } elseif ($row->magiai == 4 && $row->thutu == 7) {
                    $row->magiai = 3;
                    $row->thutu = 0;
                } elseif ($row->magiai == 3 && $row->thutu == 2) {
                    $row->magiai = 2;
                    $row->thutu = 0;
                } elseif ($row->magiai == 2) {
                    $row->magiai = 1;
                    $row->thutu = 0;
                } elseif ($row->magiai == 1) {
                    $row->magiai = 0;
                    $row->thutu = 0;
                }

                if ($row->magiai == 6 || $row->magiai == 4 || $row->magiai == 3)
                    $row->thutu = $row->thutu + 1;

                $magiai = $row->magiai;
                $thutu = $row->thutu;
//                var_dump($row->magiai, $row->thutu);
                if ($magiai == 0)
                    $magiai = 'db';

                if ($thutu == 0)
                    $pattern = '/kqxs\["T' . $tinh . '_G' . $magiai . '"\]="(\d+)";/is';
                else
                    $pattern = '/kqxs\["T' . $tinh . '_G' . $magiai . '_' . $thutu . '"\]="(\d+)";/is';

                if (preg_match($pattern, $html, $tmp)) {
                    $value = $tmp[1];
                    $_db->setQuery('INSERT IGNORE INTO xs_live SET
                            matinh=' . $item->id . '
                            ,magiai=' . $row->magiai . '
                            ,thutu=' . $row->thutu . '
                            ,giai=\'' . $value . '\'
                            ,source=\'' . $this->_domain . '\'
                            ,created=' . time() . '
                        ');
                    $_db->query();
                    $this->saveLog($area . ' - ' . $item->id . '.' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                }
            }
        }
        return true;
    }

    function get_xstt_minhngoc($area, $row) {
        global $_db;

        $link = array(
            $this->_domain . 'xstt/MB/MB.php?visit=0',
            $this->_domain . 'xstt/MT/MT.php?visit=0',
            $this->_domain . 'xstt/MN/MN.php?visit=0'
        );

        $html = $this->curl_page2($link[$area]);

        if (!$html) {
            $this->saveLog($link[$area] . ' - HTML empty!');
            unset($html);
            return false;
        }

        if (strpos($html, 'runtt=1') === false) {
            $this->saveLog('"runtt=1" Not Found!');
            unset($html);
            return true;
        }

        $magiai = 1;
        $thutu = 0;
        if ($row) {
            $magiai = $row->magiai;
            if ($magiai == 9)
                $magiai = 'db';
            $thutu = $row->thutu;
        }

        if ($thutu == 0)
            $pattern = '/kqxs\["T\d+_G' . $magiai . '"\]="(\d+)";/is';
        else
            $pattern = '/kqxs\["T\d+_G' . $magiai . '_' . $thutu . '"\]="(\d+)";/is';

        $tmp = array();
        if (preg_match($pattern, $html, $tmp)) {
            $value = $tmp[1];

            if (!$row) {
                $_db->setQuery('INSERT IGNORE INTO xs_live SET
                            matinh=1
                            ,magiai=1
                            ,giai=\'' . $value . '\'
                            ,source=\'' . $this->_domain . '\'
                            ,created=' . time() . '
                        ');
                $_db->query();
                $this->saveLog($area . ' - 1 : ' . $value);
            } else {
                if ($row->giai != $value) {
                    $_db->setQuery('UPDATE xs_live SET
                            giai=\'' . $value . '\'
                            ,created=' . time() . '
                            WHERE matinh=1 AND magiai=' . $row->magiai . ' AND thutu=' . $row->thutu . '
                        ');
                    $_db->query();
                    $this->saveLog($area . ' - ' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                }
//                var_dump($row->magiai, $row->thutu);
                if ($row->magiai == 1)
                    $row->magiai = 2;
                elseif ($row->magiai == 2 && $row->thutu == 2) {
                    $row->magiai = 3;
                    $row->thutu = 0;
                } elseif ($row->magiai == 3 && $row->thutu == 6) {
                    $row->magiai = 4;
                    $row->thutu = 0;
                } elseif ($row->magiai == 4 && $row->thutu == 4) {
                    $row->magiai = 5;
                    $row->thutu = 0;
                } elseif ($row->magiai == 5 && $row->thutu == 6) {
                    $row->magiai = 6;
                    $row->thutu = 0;
                } elseif ($row->magiai == 6 && $row->thutu == 3) {
                    $row->magiai = 7;
                    $row->thutu = 0;
                } elseif ($row->magiai == 7 && $row->thutu == 4) {
                    $row->magiai = 9;
                    $row->thutu = 0;
                }

                if ($row->magiai != 9)
                    $row->thutu = $row->thutu + 1;

                $magiai = $row->magiai;
                $thutu = $row->thutu;
//                var_dump($row->magiai, $row->thutu);
                if ($magiai == 9)
                    $magiai = 'db';

                if ($thutu == 0)
                    $pattern = '/kqxs\["T\d+_G' . $magiai . '"\]="(\d+)";/is';
                else
                    $pattern = '/kqxs\["T\d+_G' . $magiai . '_' . $thutu . '"\]="(\d+)";/is';

                if (preg_match($pattern, $html, $tmp)) {
                    $value = $tmp[1];
                    $_db->setQuery('INSERT IGNORE INTO xs_live SET
                            matinh=1
                            ,magiai=' . $row->magiai . '
                            ,thutu=' . $row->thutu . '
                            ,giai=\'' . $value . '\'
                            ,source=\'' . $this->_domain . '\'
                            ,created=' . time() . '
                        ');
                    $_db->query();
                    $this->saveLog($area . ' - ' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                }
            }
        }
        return true;
    }

    function get_ketquaveso($area, $row) {
        global $_db;

        $this->_domain = 'http://ketquaveso.com/';
        $url = $this->_domain . 'ttkq/mien-bac.html?t=' . time();

        $opts = array('http' => array('header' => 'User-Agent:User-Agent:Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0', 'timeout' => 20));
        $context = stream_context_create($opts);
        $html = file_get_html($url, false, $context);

        if (!$html) {
            $this->saveLog($url . ' - HTML empty!');
            unset($html);
            return false;
        }

        $xs_title = $html->find('div[class=gr-yellow]');

        if (!isset($xs_title[0])) {
            $this->saveLog('div[class=gr-yellow] Not Found!');
            unset($html);
            return true;
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
            $this->saveLog($date . ' khac hom nay - ' . date('d-m-Y'));
            unset($html);
            return true;
        }

        $xs_block = $html->find('ul[class=list-kqmb] li[class=pad5]');

        if (empty($xs_block)) {
            $this->saveLog('ul[class=list-kqmb] li[class=pad5] Not Found!');
            unset($html);
            return true;
        }

        $magiai = 1;
        $thutu = 0;
        if ($row) {
            $magiai = $row->magiai;
            if ($magiai == 9)
                $magiai = 0;
            $thutu = $row->thutu;
            if ($row->thutu > 0)
                $thutu = $row->thutu - 1;
        }

        if (isset($xs_block[$magiai])) {
            $arr_so = $xs_block[$magiai]->find('div span');
            if (isset($arr_so[$thutu])) {
                $value = trim($arr_so[$thutu]->text());
                if ($value != '') {
                    if (!$row) {
                        $_db->setQuery('INSERT IGNORE INTO xs_live SET
                            matinh=1
                            ,magiai=1
                            ,giai=\'' . $value . '\'
                            ,source=\'' . $this->_domain . '\'
                            ,created=' . time() . '
                        ');
                        $_db->query();
                        $this->saveLog($area . ' - 1 : ' . $value);
                    } else {
                        if ($row->giai != $value) {
                            $_db->setQuery('UPDATE xs_live SET
                                giai=\'' . $value . '\'
                                ,created=' . time() . '
                                WHERE matinh=1 AND magiai=' . $row->magiai . ' AND thutu=' . $row->thutu . '
                            ');
                            $_db->query();
                            $this->saveLog($area . ' - ' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                        }
//                        var_dump($row->magiai, $row->thutu);
                        if ($row->magiai == 1)
                            $row->magiai = 2;
                        elseif ($row->magiai == 2 && $row->thutu == 2) {
                            $row->magiai = 3;
                            $row->thutu = 0;
                        } elseif ($row->magiai == 3 && $row->thutu == 6) {
                            $row->magiai = 4;
                            $row->thutu = 0;
                        } elseif ($row->magiai == 4 && $row->thutu == 4) {
                            $row->magiai = 5;
                            $row->thutu = 0;
                        } elseif ($row->magiai == 5 && $row->thutu == 6) {
                            $row->magiai = 6;
                            $row->thutu = 0;
                        } elseif ($row->magiai == 6 && $row->thutu == 3) {
                            $row->magiai = 7;
                            $row->thutu = 0;
                        } elseif ($row->magiai == 7 && $row->thutu == 4) {
                            $row->magiai = 9;
                            $row->thutu = 0;
                        }

                        if ($row->magiai != 9)
                            $row->thutu = $row->thutu + 1;

                        $magiai = $row->magiai;
                        if ($magiai == 9)
                            $magiai = 0;
                        $thutu = $row->thutu;
                        if ($row->thutu > 0)
                            $thutu = $row->thutu - 1;
//                        var_dump($row->magiai, $row->thutu);

                        if (isset($xs_block[$magiai])) {
                            $arr_so = $xs_block[$magiai]->find('div span');
                            if (isset($arr_so[$thutu])) {
                                $value = trim($arr_so[$thutu]->text());
                                if ($value != '') {
                                    $_db->setQuery('INSERT IGNORE INTO xs_live SET
                                        matinh=1
                                        ,magiai=' . $row->magiai . '
                                        ,thutu=' . $row->thutu . '
                                        ,giai=\'' . $value . '\'
                                        ,source=\'' . $this->_domain . '\'
                                        ,created=' . time() . '
                                    ');
                                    $_db->query();
                                    $this->saveLog($area . ' - ' . $row->magiai . '.' . $row->thutu . ' : ' . $value);
                                }
                            }
                        }
                    }
                }
            }
        }

        $html->clear();
        unset($html);
        unset($xs_block, $arr_so);
//        var_dump((get_defined_vars()));

        return true;
    }

    function curl_page2($url, $curl_header = 0, $cookie = '') {
        $referer = 'http://www.google.com/';
        $useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0';
        $timeout = 20;
        $connecttimeout = 5;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $curl_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

        if ($cookie != '')
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);

        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connecttimeout);
        $html_content = curl_exec($ch);
        curl_close($ch);

        return $html_content;
    }

}