<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class buildHtml {
    /*
     *  0           =>      1   =>   2      =>  0
     * Unpublish    =>  Publish => Hidden   =>  Unpublish
     */

    static function status($cid, $status = 0, $fldName = 'cb') {
        $title = 'Unpublish';
        $task = 'publish';
        $img_name = "publish_g.png";
        if ($status == 0) {
            $title = 'Unpublish';
            $task = 'publish';
            $img_name = "publish_x.png";
        } else if ($status == 1) {
            $title = 'Publish';
            $task = 'hidden';
            $img_name = "publish_g.png";
        } else if ($status == 2) {
            $title = 'Hidden';
            $task = 'unpublish';
            $img_name = "disabled.png";
        }

        ob_start();
        $fldName = $fldName . "$cid";
        ?>
        <span class="editlinktip hasTip"><a onclick="return listItemTask('<?php echo $fldName; ?>', '<?php echo $task; ?>')" href="javascript:void(0);">
                <img width="16" height="16" border="0" alt="<?php echo $title; ?>" src="/admin/templates/standard/assets/images/icons/<?php echo $img_name; ?>"></a></span>
        <?php
        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }

    static function showBtnIcon($title, $link, $icon) {
        $img_name = $icon;
        ob_start();
        ?>
        <span class="editlinktip hasTip">
            <a href="<?php echo $link; ?>">
                <img width="16" height="16" border="0" alt="<?php echo $title; ?>" src="/admin/templates/standard/assets/images/icons/<?php echo $img_name; ?>">
            </a>
        </span>
        <?php
        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }

    static function choseStatus($name = "status", $value = 1, $show_default = 1) {
        ob_start();
        $id = trim(preg_replace('/[^\d\w]/ism', '_', $name), '_');
        ?>
        <select name="<?php echo $name; ?>" id="<?php echo $id; ?>">
            <?php if ($show_default == 1) { ?>
                <option <?php if ($value == -1) echo 'selected=""'; ?> value="-1"> -- Change status --</option>
            <?php } ?>
            <option <?php if ($value == 1) echo 'selected=""'; ?> value="1">Published</option>
            <option <?php if ($value == 2) echo 'selected=""'; ?> value="2">Hidden</option>
            <option <?php if ($value == 0) echo 'selected=""'; ?> value="0">Unpublished</option>
        </select>
        <?php
        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }

    static function limit($name, $current = 10) {
        $arr_limit = array(5, 10, 25, 50, 100);
        ob_start();
        $id = trim(preg_replace('/[^\d\w]/ism', '_', $name), '_');
        ?>
        <select name="<?php echo $name; ?>" id="<?php echo $id; ?>" onchange="javascript:document.adminForm.submit();">    
            <?php
            for ($i = 0; $i < count($arr_limit); $i++) {
                $value = $arr_limit[$i];
                ?>
                <option <?php if ($value == $current) echo 'selected=""'; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }

    static function pagination($total, $limitstart = 1, $limit = 20) {
        $pages_total = ceil($total / $limit);
        $pages_current = intval($limitstart / $limit) + 1;
        ob_start();
        ?>
        <div class="paging">
            <ul>
                <?php
                if ($pages_current != 1) {
                    $_limitstartjm = $limit * ($pages_current - 2);
                    ?>
                    <li class="pagenav-inactive">
                        <a href="?limitstart=<?php echo ("$_limitstartjm"); ?>" onclick="javascript: document.adminForm.limitstart.value =<?php echo ("$_limitstartjm"); ?>;
                                submitform();
                                return false;"> < </a
                    </li>
                    <?php
                }
                for ($j = 1; $j <= $pages_total; $j++) {
                    if ($pages_total <= 1) {
                        break;
                    }
                    if ($j > 1 && ($j < $pages_current - 3 || $j > $pages_current + 3)) {
                        continue;
                    }

                    $_limitstart = $limit * ($j - 1);
                    if ($j == $pages_current) {
                        ?>
                        <li class="pagenav-active">
                            <span><?php echo $j; ?></span>							
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="pagenav-inactive">
                            <a href="?limitstart=<?php echo ("$_limitstart"); ?>" onclick="javascript: document.adminForm.limitstart.value =<?php echo ("$_limitstart"); ?>;
                                    submitform();
                                    return false;">
                               <?php echo $j; ?>
                            </a>
                        </li>							
                        <?php
                    }
                }
                // next button
                if ($pages_current < $pages_total) {
                    $_limitstart = $limit * ($pages_current);
                    ?>
                    <li class="pagenav-inactive">
                        <a href="?limitstart=<?php echo ("$_limitstart"); ?>" onclick="javascript: document.adminForm.limitstart.value =<?php echo ("$_limitstart"); ?>;
                                submitform();
                                return false;"> > </a>
                    </li>
                    <?php
                }
                ?>
            </ul>            
        </div>
        <?php
        echo "<div style='display: inline-table;'>Total: $total item. Page $pages_current of $pages_total. </div>";
        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }

    static function headSort($title, $order, $order_current, $order_dir) {
        $imgsort = 'sort_desc';
        if (strtolower($order_dir) == 'asc') {
            $order_dir = 'desc';
            $imgsort = 'sort_asc';
        } else {
            $order_dir = 'asc';
            $imgsort = 'sort_desc';
        }

        ob_start();
        ?>
        <a title="Click to sort by this column" href="javascript:tableOrdering('<?php echo $order; ?>','<?php echo $order_dir; ?>','');">
            <?php echo $title; ?>                
            <?php
            if ($order == $order_current)
                echo '<img alt="" src="/admin/templates/standard/assets/images/' . $imgsort . '.png"></a>';
            $return = ob_get_contents();
            ob_end_clean();
            return $return;
        }

        static function select($items, $seleted = 0, $name, $id = "", $attr = " size=1 ", $text_level1 = "", $text_level2 = "") {
            if (!is_array($items))
                return "";
            if (count($items) <= 0)
                return "";

            if(!is_array($seleted)) $seleted = array($seleted); 
            
            $html = "<select name='$name' id='$id' $attr >";
            foreach ($items as $item) {
                $item = (object) $item;
                if ($text_level1 != "" and $item->level > 0) {
                    $item->text = str_repeat($text_level1, $item->level) . $text_level2 . ucfirst($item->text);
                }
                if (in_array($item->value, $seleted))
                    $html .= "<option value='$item->value' selected='true'>$item->text</option>";
                else
                    $html .= "<option value='$item->value'>$item->text</option>";
            }
            $html .= "</select>";
            return $html;
        }

        public static function changState($cid, $value = 0, $prefix = "archive.", $title_prefix = "day", $fldName = 'cb') {

            $title = 'Toggle to change ' . $title_prefix . ' to on ';
            $task = $prefix . "on";
            $img_name = "publish_g.png";
            if ($value == 0) {
                $title = 'Toggle to change ' . $title_prefix . ' to on ';
                $task = $prefix . "on";
                $img_name = "publish_x.png";
            } else if ($value == 1) {
                $title = 'Toggle to change ' . $title_prefix . ' to off ';
                $task = $prefix . "off";
                $img_name = "publish_g.png";
            }
            ob_start();
            $fldName = $fldName . "$cid";
            ?>
            <span class="editlinktip hasTip"><a onclick="return listItemTask('<?php echo $fldName; ?>', '<?php echo $task; ?>')" href="javascript:void(0);">
                    <img width="16" height="16" border="0" alt="<?php echo $title; ?>" src="/admin/templates/standard/assets/images/icons/<?php echo $img_name; ?>"></a></span>
            <?php
            $return = ob_get_contents();
            ob_end_clean();
            return $return;
        }

        static function renderField($type = "text", $name, $value = "", $title, $class = null, $placeholder = "", $w1 = 2, $w2 = 10, $width = "100%", $height = "400px") {
            if ($class == null)
                $class = "form-control";
            $html = '<div class="form-group row">';
            $html .= '<label class="control-label left col-md-' . $w1 . '">' . $title . '</label>';
            $html .= '<div class="col-md-' . $w2 . '">';
            if ($type == "text")
                $html .= '<input placeholder="' . $placeholder . '" type="text" name="' . $name . '" class="' . $class . '" value="' . $value . '">';
            else if ($type == "textarea")
                $html .= '<textarea rows="3" style="width: 100%;" name="' . $name . '" class="' . $class . '">' . $value . '</textarea>';
            else if ($type == "editor")
                $html .= buildHtml::editors($name, $value, $width, $height);
            else if ($type == "label")
                $html .= $value;
            else if ($type == "calander")
                $html .= '<input placeholder="' . $placeholder . '" type="text" name="' . $name . '" class="' . $class . ' datepicker" value="' . $value . '">';
            $html .= '</div>';
            $html .= '</div>';


            return $html;
        }

        static function editors($name, $value, $width = "100%", $height = "500px") {
            $base_url = Yii::app()->getBaseUrl(true);

            require_once(ROOT_PATH . 'editors/ckeditor/ckeditor.php');

            $config = array();
            $config['toolbar'] = array(
                array("name" => 'document', "items" => array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', "Subscript", "Superscript", "RemoveFormat")),
                array("name" => 'clipboard', "items" => array('Cut', "Copy", 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo')),
                array("name" => 'editing', "items" => array("Find", "Replace", "SelectAll", "Scayt")),
                array("name" => 'paragraph', "items" => array('NumberedList', 'BulletedList', 'Outdent', 'Indent', "Blockquote", "CreateDiv", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock")),
                array("name" => 'insert', "items" => array('Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe')),
                array("name" => 'links', "items" => array('Link', 'Unlink', 'Anchor')),
                array("name" => 'styles', "items" => array('Styles', 'Format', 'Font', 'FontSize', '-', 'TextColor', 'BGColor')),
                array("name" => 'tools', "items" => array('Maximize', '-', 'About')),
            );

            $config['height'] = $height;
            $config['returnOutput'] = true;
            //$events['instanceReady'] = 'function (ev) { }';
            $CKEditor = new CKEditor("$base_url/editors/ckeditor/");
            $CKEditor->returnOutput = true;
            $out = $CKEditor->editor($name, $value, $config, $events = null);

            return $out;
        }

        public static function TruncateText($text, $max_len = 30) {
            $len = mb_strlen($text, 'UTF-8');
            if ($len <= $max_len)
                return $text;
            else
                return mb_substr($text, 0, $max_len - 1, 'UTF-8') . '...';
        }

    }
    