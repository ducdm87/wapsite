<?php

$data_json = null;
$chuaquay = 1;
$trung = 0;
$dsgiai = 0;
$giatri = 0;
if ($sos != '') {
    $arr_so = explode(',', $sos);
    $tmp = explode(':', $arr_so[0]);
    $so = trim($tmp[0]);
//    $fromdate = date('d/m/Y', strtotime($fromdate));
    if ($items) {
        $class = '';
        $giaithuong = array(
            200000000
            , 20000000
            , 5000000
            , 2000000
            , 400000
            , 200000
            , 100000
            , 40000
            , 40000
        );
        $url = '';
        switch ($items->area) {
            case 'MB':
                $l_area = 'Truyền thống';
                $class = ' kqmienbac';
                $url = $url_mienbac;
                break;
            case 'MT':
                $l_area = 'Miền Trung';
                $class = ' kqmiennam';
                $url = $url_mientrung;
                if (strlen($items->a0) == 5)
                    $giaithuong = array(
                        250000000
                        , 40000000
                        , 10000000
                        , 5000000
                        , 2500000
                        , 1000000
                        , 500000
                        , 250000
                        , 100000
                        , 0
                        , 500000
                    );
                else
                    $giaithuong = array(
                        1500000000
                        , 40000000
                        , 10000000
                        , 5000000
                        , 2500000
                        , 1000000
                        , 500000
                        , 250000
                        , 100000
                        , 100000000
                        , 7000000
                    );
                break;
            case 'MN':
                $l_area = 'Miền Nam';
                $class = ' kqmiennam';
                $url = $url_miennam;
                $giaithuong = array(
                    1500000000
                    , 30000000
                    , 20000000
                    , 10000000
                    , 3000000
                    , 1000000
                    , 400000
                    , 200000
                    , 100000
                    , 100000000
                    , 6000000
                );
                break;
        }

        if ($result[$so] === '' || $result[$so] === NULL) {
            $chuaquay = 0;
        } elseif ($result[$so] == 999) {
            $chuaquay = 0;
            $trung = -1;
        } else {
            $giai = array();
            $trigia = 0;
            $arr_result = explode(',', $result[$so]);
            foreach ($arr_result as $rs) {
                if ($rs === '')
                    continue;

                $trigia = $trigia + $giaithuong[$rs];
                $trigia = $trigia * $soluong[$so];
                switch ($rs) {
                    case 0:
                        $giai[] = 'giải Đặc Biệt';
                        break;
                    case 1:
                        $giai[] = 'giải Nhất';
                        break;
                    case 2:
                        $giai[] = 'giải Nhì';
                        break;
                    case 3:
                        $giai[] = 'giải Ba';
                        break;
                    case 4:
                        $giai[] = 'giải Tư';
                        break;
                    case 5:
                        $giai[] = 'giải Năm';
                        break;
                    case 6:
                        $giai[] = 'giải Sáu';
                        break;
                    case 7:
                        $giai[] = 'giải Bảy';
                        break;
                    case 8:
                        $giai[] = 'giải Tám';
                        if ($items->area == 'MB')
                            $giai[] = 'giải Khuyến Khích';
                        break;
                    case 9:
                        $giai[] = 'giải Đặt Biệt Phụ';
                        break;
                    case 10:
                        $giai[] = 'giải Khuyến Khích';
                        break;
                }
            }
            $chuaquay = 0;
            if ($trigia > 0) {
                $trung = 1;
                $dsgiai = implode(',', $giai);
                $giatri = $trigia;
            }
        }
    } else {
        $chuaquay = 1;
    }

    $data_json['so'] = $sos;
    $data_json['tinh'] = $alias;
    $data_json['tentinh'] = $lname;
    $data_json['ngay'] = $fromdate;
    $data_json['trangthai']['chuaquay'] = $chuaquay;
    $data_json['trangthai']['trung'] = $trung;
    $data_json['trangthai']['giai'] = $dsgiai;
    $data_json['trangthai']['trigia'] = $giatri;
}

if ($data_json) {
    $data = array('status' => "1", "msg" => "", "result" => $data_json);
    $rest->response($rest->json($data), 200);
} else {
    $error = array('status' => "0", "msg" => "Not Found");
    $rest->response($rest->json($error), 200);
}
?>