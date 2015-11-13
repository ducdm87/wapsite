<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function setSysConfig($name, $value) {
    global $sys_config;
    $sys_config[$name] = $value;
}

function getSysConfig($name, $default = "") {
    global $sys_config;
    return isset($sys_config[$name]) ? $sys_config[$name] : $default;
}

function addListObjectID($data, $type = "news") {
    global $sys_config;
    $key = "$type-listcontent";
    if (!isset($sys_config[$key]))
        $sys_config[$key] = array();
    if (is_array($data)) { // du lieu la mang
        if (isset($data["id"])) { //1 chieu
            addObjectID($data["id"], $type);
        } else {
            foreach ($data as $item) {
                if (is_object($item)) { //mang cac doi tuong
                    if (isset($item->id))
                        addObjectID($item->id, $type);
                }else if (is_array($item)) { //mang 2 chieu
                    if (isset($item["id"])) {
                        addObjectID($item["id"], $type);
                    }
                }
            }
        }
    } else if (is_object($data)) { // du lieu la doi tuong
        if (isset($data->id))
            addObjectID($data->id, $type);
    }else {
        addObjectID($data, $type);
    }

    return count($sys_config[$key]);
}

function addObjectID($id, $type = "news") {
    global $sys_config;
    $key = "$type-listcontent";
    if (!isset($sys_config[$key]))
        $sys_config[$key] = array();
    $sys_config[$key][$id] = $id;
    return count($sys_config[$key]);
}

function getListObjectID($type = "news", $format = "string", $sperator = ",") {
    global $sys_config;
    $key = "$type-listcontent";
    if (!isset($sys_config[$key]))
        return false;
    if ($format == "string")
        return implode($sperator, $sys_config[$key]);
    return $sys_config[$key];
}

function fnCreateUrlNewsDetail($cid, $alias, $catid, $cat_alias) {
//    return Yii::app()->createUrl("news/detail", array("cid" => $cid, "alias" => $alias, "cat_alias" => $cat_alias));
    return Yii::app()->createUrl("articles/detail", array("id" => $cid, "alias" => $alias));
}

function fnShowPagenation($link, $total, $limit, $currentPage) {
    $totalPage = ceil($total / $limit);
    if ($totalPage <= 1)
        return "";

    ob_start();
    ?>
    <div class="pagination">
        <ul class="pagination-list">
            <?php
            $maxpage = $totalPage < 5 ? $totalPage : 5;
            $startPage = $currentPage - 3;
            $endPage = $currentPage + 4;
            if ($startPage <= 0)
                $startPage = 1;
            if ($endPage >= $total)
                $endPage = $total;

            if ($currentPage > 4) {
                $link_page = rtrim($link, "/");
                echo '<li><a href="' . $link . '"> << </a></li>';
            }
            if ($currentPage > 5) {
                $p = $currentPage - 4;
                $link_page = rtrim($link, "/");
                $link_page = $link_page . "/trang-$p";
                echo '<li><a href="' . $link_page . '"> ... </a></li>';
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $page = $i;
                if ($page > $totalPage)
                    continue;
                if ($currentPage == $i) {
                    echo '<li class="active">' . $i . '</li>';
                } else {
                    $link_page = rtrim($link, "/");
                    if ($i != 1)
                        $link_page = $link_page . "/trang-$i";
                    echo '<li><a href="' . $link_page . '">' . $i . '</a></li>';
                }
            }

            if ($currentPage + 5 < $totalPage) {
                $p = $currentPage + 5;
                $link_page = rtrim($link, "/");
                $link_page = $link_page . "/trang-$p";
                echo '<li><a href="' . $link_page . '"> ... </a></li>';
            }
            if ($currentPage + 4 < $totalPage) {
                $p = $currentPage + $total;
                $link_page = rtrim($link, "/");
                $link_page = $link_page . "/trang-$totalPage";
                echo '<li><a href="' . $link_page . '"> >> </a></li>';
            }
            ?>
        </ul>
    </div>
    <?php
    $str_out = ob_get_contents();
    ob_end_clean();
    return $str_out;
}

//"title", "controller","action","data-id|data-alias","link",is_homepage,[array_param]
function fnAddMenuItem($item, $parent = -1, $type = "mainmenu") {
    global $sys_menu;
    if (!isset($sys_menu[$type]))
        $sys_menu[$type] = array();
    if ($parent == -1) {
        $sys_menu[$type][] = $item;
        return count($sys_menu[$type]);
    } else {
        if (!isset($sys_menu[$type][$parent]))
            return null;
        if (!isset($sys_menu[$type][$parent]['_subitem']))
            $sys_menu[$type][$parent]['_subitem'] = array();
        $sys_menu[$type][$parent]['_subitem'][] = $item;
        return count($sys_menu[$type][$parent]['_subitem']);
    }
}

function fnSetMenuItems($items, $type = "mainmenu") {
    global $sys_menu;
    if (!isset($sys_menu[$type]))
        $sys_menu[$type] = array();
    $sys_menu[$type] = $items;
}

function fnGetMenuItem($type = "mainmenu", $pos = -1) {
    global $sys_menu;
    if (!isset($sys_menu[$type]))
        return null;
    if ($pos == -1)
        return $sys_menu[$type];
    if (isset($sys_menu[$type][$pos]))
        return $sys_menu[$type][$pos];
    return false;
}

function fnShowMenu($type = "mainmenu", $spacer = "", $show_submenu = true) {
    $itemsmenu = fnGetMenuItem($type);

    $active = -1;
    $levelfound = 100;
    $ItemID = Request::getVar('ItemID', null);
    if ($ItemID == null)
        $item_active = _fnFindItemMenu($itemsmenu, $active, $levelfound);
    else
        $active = $ItemID;

    $subactive = -2;
    $_levelfound = 100;
    $item_active = $itemsmenu[$active];
    if (isset($item_active['_subitem']))
        $subitem_active = _fnFindItemMenu($item_active['_subitem'], $subactive, $_levelfound, $file_level = 2);

    ob_start();
    ?> 
    <ul class="clearfix">
        <?php
        if($itemsmenu)
        foreach ($itemsmenu as $k => $item) {
            $link = $item[4];
            if ($link == null AND $item[1] !== null AND $item[2] !== null) {
                $arr = array();
                if (intval($item[3]) != 0)
                    $arr["cid"] = $item[3];
                else if ($item[3] != "")
                    $arr["alias"] = $item[3];
                if (isset($item[6]) AND is_array($item[6])) {
                    $arr = array_merge($arr, $item[6]);
                }

                $link = Yii::app()->createUrl("$item[1]/$item[2]", $arr);
            }
            $class = "";
            if ($active == $k)
                $class = "active";
            if (isset($item['_subitem']) AND count($item['_subitem']) > 0 AND $show_submenu == true) {
                $class .= " parent ";
                echo '<li class="' . $class . '">'
                . '<a href="' . $link . '"><span>' . $item[0] . '</span></a>';
                echo '<ul class="submenu">';
                $subitems = $item['_subitem'];
                foreach ($item['_subitem'] as $k2 => $subitem) {
                    $sub_class = "";
                    $sublink = $subitem[4];
                    if ($sublink == null AND $subitem[1] !== null AND $subitem[2] !== null) {
                        $arr = array();
                        if (intval($subitem[3]) != 0)
                            $arr["cid"] = $subitem[3];
                        else if ($subitem[3] != "")
                            $arr["alias"] = $subitem[3];
                        if (isset($subitem[6]) AND is_array($subitem[6])) {
                            $arr = array_merge($arr, $subitem[6]);
                        }

                        $sublink = Yii::app()->createUrl("$subitem[1]/$subitem[2]", $arr);
                    }
                    if ($subactive == $k2)
                        $sub_class = "active";
                    echo '<li class="' . $sub_class . '"><a href="' . $sublink . '"><span>' . $subitem[0] . '</span></a></li>';
                }
                echo '</ul>';
                echo '</li>' . $spacer;
            } else {
                echo '<li class="' . $class . '"><a href="' . $link . '"><span>' . $item[0] . '</span></a></li>' . $spacer;
            }
        }
        ?> 
    </ul>
    <?php
    $str_out = ob_get_contents();
    ob_end_clean();
    return $str_out;
}

/*
 * Tim item active
 * @$items: danh sach item menu
 * @$active: vị trí tìm thấy menu
 * @$levelfound: mặc định: 100
 *               trang chu: 20
 *               control: 15
 *                  + display: 10
 *                  + chitiet + category: 2
 *                  + chitiet + id|alias: 1
 *                  + action: 2
 *                  + action + id|alias: 1
 * @$file_level: = 1: lay item dau tien tim thay control
 *               = 2: nguoc lai
 *                          
 */

function _fnFindItemMenu($items, &$active = -1, &$levelfound = 100, $file_level = 1) {
    $controll = Yii::app()->controller->id;
    $action = Yii::app()->controller->action->id;
    $cat_alias = Request::getVar('cat_alias', null);
    $alias = Request::getVar('alias', null);
    $cid = Request::getInt('cid', null);
    
    if(count($items))
    foreach ($items as $k => $item) {
        if ($active == -1 AND $item[5] == 1) {  // trang chu
            $active = $k;
            $levelfound = 20;
        }
        if ($controll == $item[1]) {
            if ($levelfound > 15 AND $file_level == 1) { // khop voi control lan dau
                $active = $k;
                $levelfound = 15;
            }

            if ($item[2] == "display" AND $levelfound > 10) {
                $active = $k;
                $levelfound = 10;
            } else if ($action == "detail") {
                if ($item[2] == "category") {
                    if ($cat_alias == $item[3] AND $levelfound > 2) {
                        $levelfound = 2;
                        $active = $k;
                    }
                } else if ($item[2] == "detail" AND ( $cid == $item[3] OR $alias == $item[3])) {
                    // menu chi tiet co id hoac alias trung
                    $active = $k;
                    $levelfound = 1;
                    break;
                }
            } else {
                if ($action == $item[2]) {
                    if ($cid == $item[3] OR $alias == $item[3]) {
                        $levelfound = 1;
                        $active = $k;
                    }
                }
            }
        }
    }
    if (isset($items[$active]))
        return $items[$active];
    else
        return null;
}

function fnProcessThumb($link, $width = 70) {
    if (strpos($link, "vietbao.vn") !== false) {
        $link = preg_replace('/images\/\d+\//ism', "images/" . $width . "/", $link);
    }
    return $link;
}

function fnShowNewsColumn($items, $numberThumb = 2, $redirect = 1) {
    $str_out = "";
    $items1 = array_splice($items, 0, $numberThumb);

    $tg = "";

    ob_start();
    echo '<div class="featured">';
    foreach ($items1 as $item) {
        if ($redirect == 1) {
            $item['link'] = $item['link_original'];
            $tg = "_blank";
        }
        ?>
        <div class="imgs">
            <a target="<?php echo $tg; ?>" href="<?php echo $item['link']; ?>" title="<?php echo htmlspecialchars($item['title']) ?>">
                <img width="94" height="94" src="<?php echo ($item['thumbnail']); ?>" alt="<?php echo htmlspecialchars($item['title']) ?>" title="<?php echo htmlspecialchars($item['title']) ?>" >
            </a>
        </div>
        <div class="infor">
            <a class="title-news" href="<?php echo $item['link']; ?>"><?php echo $item['title'] ?></a>
            <p><?php echo $item['introtext']; ?></p>
        </div>
        <?php
    }
    echo '</div>';
    if (count($items)) {
        echo '<ul class="read-more">';
        foreach ($items as $item) {
            if ($redirect == 1) {
                $item['link'] = $item['link_original'];
                $tg = "_blank";
            }
            ?>
            <li class="item">
                <a target="<?php echo $tg; ?>" href="<?php echo $item['link']; ?>" title="<?php echo htmlspecialchars($item['title']) ?>">
                    <?php echo $item['title'] ?>
                </a>
            </li>
            <?php
        }
        echo '</ul>';
    }
    ?>
    <?php
    $str_out = ob_get_contents();
    ob_end_clean();
    return $str_out;
}

function fnShowNewColRight($scope = "*", $catID, $limit = 10) {
    $modelNews = News::getInstance();
    $dataCart = $modelNews->getTinTuc($scope, $catID, $limit);
    $dataCart = $dataCart[$catID];
    $items = $dataCart['contents'];

    $tg = "";
    if ($dataCart['redirect'] == 1) {
        $dataCart['link'] = $dataCart['link_original'];
        $tg = "_blank";
    }
    ?>
    <div class="box-std box-newscolumn">
        <div class="box-title">
            <h3 class="head"><a target="<?php echo $tg; ?>" href="<?php echo $dataCart['link']; ?>"><?php echo $dataCart['title']; ?></a></h3>
        </div>
        <div class="inner">
            <ul class="items">
                <?php
                for ($i = 0; $i < count($items); $i++) {
                    $item = $items[$i];
                    if ($dataCart['redirect'] == 1) {
                        $item['link'] = $item['link_original'];
                        $tg = "_blank";
                    }
                    ?>
                    <li class="item">
                        <a target="<?php echo $tg; ?>" href="<?php echo $item['link']; ?>">
                            <img src="<?php echo $item["thumbnail"]; ?>" />
                            <?php echo $item["title"]; ?>
                        </a>
                        <p class="time"><?php echo date("H:i d/m/Y", strtotime($item['created'])); ?></p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php
}

function fnShowTienIch() {
    ?>
    <div class="mod-modules">
        <div class="mod-content">
            <ul class="list-atm">
                <li class="clearfix">
                    <a class="atm left" href="http://vietbao.vn/vn/diem-dat-atm/"><span>Điểm đặt ATM</span></a>
                    <a class="hdatm left" href="http://vietbao.vn/vn/hoi-dap-atm/"><span>Hỏi đáp ATM</span></a>						
                </li>
                <li class="clearfix">
                    <a class="ls left" href="http://vietbao.vn/vn/lai-suat-tiet-kiem/"><span>Lãi suất</span></a>
                    <a class="lmt right" href="http://vietbao.vn/vn/lien-minh-the/"><span>Liên minh thẻ</span></a>
                </li>
                <li class="clearfix">
                    <a class="tg right" href="http://vietbao.vn/vn/ty-gia-ngoai-te/"><span>Tỷ giá ngoại tệ</span></a>
                    <a class="pgd right" href="http://vietbao.vn/vn/lien-lac-trung-tam-the/"><span>Phòng giao dịch</span></a>
                </li>
                <li class="clearfix">
                    <a class="gv left" href="http://vietbao.vn/vn/market/gia-vang/"><span>Giá vàng</span></a>
                    <a class="gc right" href="http://vietbao.vn/vn/gia-ca-thi-truong/"><span>Giá cả thị trường</span></a>
                </li>
                <li class="clearfix">
                    <a class="gtk left" href="http://vietbao.vn/vn/chung-khoan-truc-tuyen/"><span>Giá chứng khoán</span></a>						
                    <a class="tkt left" href="http://vietbao.vn/Kinh-te/"><span>Tin kinh tế</span></a>						
                </li>
                <li class="clearfix">
                    <a class="gtk left" href="http://giaxang.vietbao.vn"><span>Giá xăng</span></a>						
                    <a class="tkt left" href="http://giadien.vietbao.vn"><span>Giá điện</span></a>						
                </li>
            </ul>
        </div>
    </div>
    <?php
}

function fnDisplayVideo($item){
    $pl_id = "player-".$item['id'];   
    $html = "";
    if(isset($item['videocode']) AND $item['videocode'] != "" AND $item['videocode'] != null){
        $html = "<div id='$pl_id' class='video-player'>";
            $html .= $item['videocode'];
        $html .= "</div>";
    }else if(isset($item['videourl']) AND $item['videourl'] != "" AND $item['videourl'] != null){
        $html = "<div id='$pl_id' class='video-player'></div>";
        ob_start();
        ?>
            <script type="text/javascript">
                jwplayer("<?php echo $pl_id; ?>").setup({
                    width: "100%", height: "350px",
                    aspectratio: "12:7",
                    file: "<?php echo $item['videourl']; ?>",
                    image: "<?php echo $item['image']; ?>"
                });                
            </script>
        <?php
        $str_script = ob_get_contents();
        ob_end_clean();
        $html .= $str_script;
    }
    
    return $html;
}

function sysLoadXmlParama($xml_file, $values = null, $type = "Module"){
    global $mainframe;
        $obj_xml = simplexml_load_file($xml_file);
        
        $params_value = json_decode($values, true);
      
        if(!is_array($params_value)) $params_value = array();
        
        if ($obj_xml == false) {
            $message = "Failed loading module: ";
            foreach (libxml_get_errors() as $error) {
                $message .= "<br>". $error->message;
            }
            YiiMessage::raseSuccess($message);
            return false;
        }
//        print_r($obj_xml); die;
        
        $config = $obj_xml->config?$obj_xml->config:false;
        if($config == false) return array();
        
        $array_param =array();
        foreach($config->param as $k=> $param){
            $obj_param = new stdClass();
            $param_title = "$type Parameters(".(count($array_param) + 1).")";
            
            if(isset($param->attributes()->title)){
                $param_title = (string)$param->attributes()->title;
            }
            
            $obj_param->title = $param_title;
            $obj_param->fields = array();
            foreach($param->field as $field){                
                $field_name = (string)$field['name'];
                $field_value = isset($params_value[$field_name])?$params_value[$field_name]:null;
                $obj_param->fields[] = YiiElement::render($field, $field_value);
              
            }
            $array_param[] = $obj_param;            
        }
       return $array_param;
}
//
//global $YiiMenu;
//$YiiMenu = new YiiMenu();