<?php
die;
define('THIS_PATH', dirname(__FILE__));
require_once(THIS_PATH . '/nusoap.php');
$base_url = 'http://xoso.com/';

$server = new nusoap_server(false);
$server->configureWSDL('WS_WITH_SMS', $base_url, false, 'rpc', 'http://schemas.xmlsoap.org/soap/http', false);
$server->wsdl->schemaTargetNamespace = $base_url;

function updateXOSO($pass, $mobile, $item_id, $dau_so_nhan_tin, $msgbody, $time, $so) {
    $rs = array();
    $rs['content'] = '';
    $rs['status'] = -1;
    if ($pass != '123465789') {
        $rs_json = $rs['content'].'//'.$rs['status'];
        return $rs_json; // sai mat khau
    }

    require(THIS_PATH . '/database.php');
    require(THIS_PATH . '/query.php');

    $host = "localhost";
    $user = "xoso";
    $pass = "b03d1556f7";
    $db = "xosov2";
    $_db = new database($host, $user, $pass, $db);

    $day30 = 0;
    if ($dau_so_nhan_tin == '8788' && substr($item_id, 0, 2) == 'KQ')
        $day30 = 1;

    if ($day30 == 1) {
        $query = "SELECT id FROM xs_sms WHERE mobile='$mobile' AND item_id='$item_id' AND dau_so_nhan_tin='8788'";
        $row = $_db->setQuery($query);
        $row = $_db->loadObject($item);
        if (!$item) {
            $_db->setQuery("INSERT INTO xs_sms SET
                mobile='" . $mobile . "'
                ,item_id='" . $item_id . "'
                ,dau_so_nhan_tin='" . $dau_so_nhan_tin . "'
                ,msgbody='" . $msgbody . "'
                ,time=0
                ,created=" . time() . "
                ,day30=30
                ,status=1
            ");
            $_db->query();
        } else {
            $_db->setQuery("UPDATE xs_sms SET day30=30,time=0 WHERE id=" . $item->id);
            $_db->query();
        }
        $rs['content'] = 'Ban da dang ky nhan KQXS trong 30 ngay lien tiep, chung toi se gui ket qua cho ban ngay sau khi thoi gian quay so ket thuc';
        $rs['status'] = 1;

        $rs_json = $rs['content'].'//'.$rs['status'];
        return $rs_json;
    } elseif (substr($item_id, 0, 2) == 'TT' && $dau_so_nhan_tin == '8588') {
        $query = "SELECT id FROM xs_sms WHERE mobile='$mobile' AND item_id='$item_id' AND day30=999";
        $row = $_db->setQuery($query);
        $row = $_db->loadObject($item);

        if (!$item) {
            $_db->setQuery("INSERT INTO xs_sms SET
                mobile='" . $mobile . "'
                ,item_id='" . $item_id . "'
                ,dau_so_nhan_tin='" . $dau_so_nhan_tin . "'
                ,msgbody='" . $msgbody . "'
                ,time=0
                ,created=" . time() . "
                ,day30=999
                ,status=0
            ");
            $_db->query();
        } else {
            $_db->setQuery("UPDATE xs_sms SET a_all='',status=0 WHERE id=" . $item->id);
            $_db->query();
        }
    } else {
        $_db->setQuery("INSERT INTO xs_sms SET
                mobile='" . $mobile . "'
                ,item_id='" . $item_id . "'
                ,dau_so_nhan_tin='" . $dau_so_nhan_tin . "'
                ,msgbody='" . $msgbody . "'
                ,time=" . $time . "
                ,created=" . time() . "
                ,day30=0
                ,status=0
            ");
        $_db->query();
    }

    $rs['status'] = 1;
    if (substr($item_id, 0, 2) == 'KQ' && $dau_so_nhan_tin == '8188') {
        $rs['content'] = KQXS($_db, $item_id, $time);
    } elseif (substr($item_id, 0, 2) == 'TK' && $dau_so_nhan_tin == '8588') {
        $rs['content'] = TKXS($_db, $item_id, $so);
    } elseif (substr($item_id, 0, 2) == 'TT' && $dau_so_nhan_tin == '8588') {
        $rs['content'] = TTXS($_db, $item_id, $mobile);
    } else {
        $rs['status'] = -1;
    }

//    $str = "INSERT INTO vote_sms SET
//        mobile='" . $mobile . "'
//        ,dau_so_nhan_tin='" . $dau_so_nhan_tin . "'
//        ,value='" . $value . "'
//        ,time='" . time() . "'
//        ";
//    $fp = fopen(THIS_PATH . '/log_sms_vote.txt', 'w');
//    // define script name
//    $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
//    // define current time and suppress E_WARNING if using the system TZ settings
//    // (don't forget to set the INI setting date.timezone)
//    $time = @date('[d/M/Y:H:i:s]');
//    // write current time, script name and message to the log file
//    fwrite($fp, "$time ($script_name) $str" . PHP_EOL);
//    //fwrite($fp, $str."\n");
//    fclose($fp);

    $rs_json = $rs['content'].'//'.$rs['status'];
    return $rs_json;
}

function KQXS($_db, $item_id, $time) {
    $code = substr($item_id, 2, strlen($item_id));

    if ($time == 0) {
        $query = "SELECT r.* FROM xs_result AS r
                    LEFT JOIN xs_location AS l ON r.lid = l.id
                    WHERE l.code='" . $code . "' 
                    ORDER BY r.date DESC 
                    LIMIT 1"
        ;
    } else {
        $date = date('Y-m-d', $time);
        $query = "SELECT r.* FROM xs_result AS r
                    LEFT JOIN xs_location AS l ON r.lid = l.id
                    WHERE l.code='" . $code . "' AND r.date='" . $date . "'
                    LIMIT 1"
        ;
    }
    $row = $_db->setQuery($query);
    $row = $_db->loadObject($item);
    if (!$item) {
        return 'Tinh ban chon khong ton tai hoac chua den gio quay';
    }

    $content = $code . ' ' . date('d/m', strtotime($item->date)) . ":\n";
    if ($item->a0 != '')
        $content .= "DB:" . $item->a0 . "\n";
    if ($item->a1 != '')
        $content .= "1:" . $item->a1 . "\n";
    if ($item->a2 != '')
        $content .= "2:" . $item->a2 . "\n";
    if ($item->a3 != '')
        $content .= "3:" . $item->a3 . "\n";
    if ($item->a4 != '')
        $content .= "4:" . $item->a4 . "\n";
    if ($item->a5 != '')
        $content .= "5:" . $item->a5 . "\n";
    if ($item->a6 != '')
        $content .= "6:" . $item->a6 . "\n";
    if ($item->a7 != '')
        $content .= "7:" . $item->a7 . "\n";
    if ($code != 'MB' && $item->a8 != '')
        $content .= "8:" . $item->a8 . "\n";

    return $content;
}

function TKXS($_db, $item_id, $so) {
    $code = substr($item_id, 2, strlen($item_id));
    $so = trim($so);
    $content = '';

    $query = "SELECT CONCAT_WS(',',r.a0,r.a1,r.a2,r.a3,r.a4,r.a5,r.a6,r.a7,r.a8) AS data,r.date
                    FROM xs_result AS r
                    LEFT JOIN xs_location AS l ON r.lid = l.id
                    WHERE l.code='" . $code
            . " ORDER BY r.date DESC"
            . " LIMIT 0,30"
    ;

    $row = $_db->setQuery($query);
    $row = $_db->loadObjectList($list);

    if ($list) {
        $count = 0;
        $date = '';
        foreach ($list as $v1) {
            $arr = explode(',', $v1->data);
            foreach ($arr as $v2) {
                if (strpos($v2 . '-', $so . '-') !== false) {
                    $count++;
                    if ($date == '') {
                        $date = $v1->date;
                    }
                }
            }
        }

        if ($date != '') {
            $content = 'Day so ' . $so . ' xuat hien ' . $count . ' lan trong 30 ngay gan nhat, ngay ve gan nhat la ' . date('d/m/Y', strtotime($date));
        } else {
            $content = 'Day so ' . $so . ' khong xuat hien trong 30 ngay gan nhat';
        }
    } else {
        $content = 'Day so ' . $so . ' khong xuat hien trong 30 ngay gan nhat';
    }

    return $content;
}

function TTXS($_db, $item_id, $mobile) {
    $content = 'Ban da dang ky nhan KQXS tuong thuat truc tiep trong ngay hom nay ' . date('d/m/Y', time());

    if ($item_id == 'TT')
        $code = 'MB';
    else
        $code = substr($item_id, 2, strlen($item_id));

    $date = date('Y-m-d', time());
    $query = "SELECT r.* FROM xs_result AS r
                    LEFT JOIN xs_location AS l ON r.lid = l.id
                    WHERE l.code='" . $code . "' AND r.date='" . $date . "'
                    LIMIT 1"
    ;
    $row = $_db->setQuery($query);
    $row = $_db->loadObject($item);
    if ($item) {
        if ($item->a0 == '')
            return $content;

        $content = $code . ' ' . date('d/m', time()) . ":\n";
        $content .= "DB:" . $item->a0 . "\n";
        $content .= "1:" . $item->a1 . "\n";
        $content .= "2:" . $item->a2 . "\n";
        $content .= "3:" . $item->a3 . "\n";
        $content .= "4:" . $item->a4 . "\n";
        $content .= "5:" . $item->a5 . "\n";
        $content .= "6:" . $item->a6 . "\n";
        $content .= "7:" . $item->a7 . "\n";
        if ($code != 'MB')
            $content .= "8:" . $item->a8 . "\n";

        $_db->setQuery("UPDATE xs_sms SET status='1' WHERE mobile='$mobile' AND item_id='$item_id' AND day30=999");
        $_db->query();
    }

    return $content;
}

$server->register('updateXOSO', array('pass' => 'xsd:string',
    'mobile' => 'xsd:string',
    'item_id' => 'xsd:string',
    'dau_so_nhan_tin' => 'xsd:string',
    'msgbody' => 'xsd:string',
    'time' => 'xsd:string',
    'so' => 'xsd:string'
        ), array('result' => 'xsd:string'), $base_url, false, false, false, '', '');

// Khoi tao Webservice        
$HTTP_RAW_POST_DATA = (isset($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
