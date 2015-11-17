<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MainFrame {

    protected $db;
    protected $user;
    protected $site;

    function __construct($db, $user, $site = "backend") {
        $this->db = $db;
        if(is_array($user)) $user = (object)$user;
        $this->user = $user;
        $this->site = $site;
    }

    static function & getInstance($db, $user, $site = "backend") {
        static $instance;

        if (!is_object($instance)) {
            $instance = new MainFrame($db, $user, $site);
        }
        return $instance;
    }

    function set($name, $value) {
        $this->$name = $value;
    }

    function getUser() {
        return $this->user;
    }

    function getUserID() {        
        return $this->user ? $this->user->id : 0;
    }

    function getUserUsername() {
        return $this->user ? $this->user->username : "";
    }

    function isLogin() {
        return $this->user ? true : false;
    }

    function isAdmin() {
        
        return $this->user ? ($this->user->backend == 1 ? true : false) : false;
    }

    function isBackEnd() {
        return $this->site == "backend" ? true : false;
    }

    public function redirect($url, $message = "", $terminate = true, $statusCode = 302) {
        if ($message != "") {
            Yii::app()->session['message'] = $message;
            Yii::app()->session['rasestatus'] = "notice";
        }
        if (is_array($url)) {
            $route = isset($url[0]) ? $url[0] : '';
            $url = $this->createUrl($route, array_splice($url, 1));
        }
        Yii::app()->getRequest()->redirect($url, $terminate, $statusCode);
    }

    function bind($toArray, $fromArray) {
        foreach ($toArray as $k => $value) {
            if (isset($fromArray[$k]) and $fromArray[$k] != "" and $fromArray[$k] != null)
                $toArray[$k] = $fromArray[$k];
        }
        return $toArray;
    }
    
    function convertalias($string) {
        $alias = $string;

        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ",
            "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", "ê", "ù", "à");

        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", "e", "u", "a");

        $alias = str_replace($coDau, $khongDau, $alias);

        $coDau = array("̀", "́", "̉", "̃", "̣", "“", "”", ".");
        $khongDau = array("", "", "", "", "", "", "", "");
        $alias = str_replace($coDau, $khongDau, $alias);

        $alias = preg_replace('/[^a-zA-Z0-9-.]/', '-', $alias);
        $alias = preg_replace('/^[-]+/', '', $alias);
        $alias = preg_replace('/[-]+$/', '', $alias);
        $alias = preg_replace('/[-]{2,}/', '-', $alias);
        return $alias;
    }

    public static function prepareAttachment($path) {
        $rn = "\r\n";
        if (file_exists($path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $ftype = finfo_file($finfo, $path);
            $file = fopen($path, "r");
            $attachment = chunk_split(base64_encode(fread($file, filesize($path))));
            fclose($file);
            $msg = 'Content-Type: \'' . $ftype . '\'; name="' . basename($path) . '"' . $rn;
            $msg .= "Content-Transfer-Encoding: base64" . $rn;
            $msg .= 'Content-ID: <' . basename($path) . '>' . $rn;
            $msg .= $rn . $attachment . $rn . $rn;
            return $msg;
        } else {
            return false;
        }
    }

    public static function sendMail($from, $to, $subject, $content, $reply_to="", $arr_file_attach = array(), $cc = '', $bcc = '') {
        if (!$from) return false;
        $rn = "\r\n";
        $boundary = md5(rand());
        $boundary_content = md5(rand());        
// Headers        
        $headers = "From: Resume builder <$from>" . $rn;
        if($reply_to) $headers .= "Reply-To: $from" . $rn;
        else $headers .= "Reply-To: $reply_to" . $rn;
        $headers .= 'Mime-Version: 1.0' . $rn;
        $headers .= 'Content-Type: multipart/related;boundary=' . $boundary . $rn;

        //adresses cc and ci
        if ($cc != '')
            $headers .= 'Cc: ' . $cc . $rn;
        if ($bcc != '')
            $headers .= 'Bcc: ' . $cc . $rn;
        $headers .= $rn;

// Message Body
        $msg = $rn . '--' . $boundary . $rn;
        $msg.= "Content-Type: multipart/alternative;" . $rn;
        $msg.= " boundary=\"$boundary_content\"" . $rn;

//Body Mode text
        $msg.= $rn . "--" . $boundary_content . $rn;
        $msg .= 'Content-Type: text/plain; charset=ISO-8859-1' . $rn;
        $msg .= strip_tags($content) . $rn;

//Body Mode Html       
        $msg.= $rn . "--" . $boundary_content . $rn;
        $msg .= 'Content-Type: text/html; charset=ISO-8859-1' . $rn;
        $msg .= 'Content-Transfer-Encoding: quoted-printable' . $rn;

        //equal sign are email special characters. =3D is the = sign
        $msg .= $rn . '<div>' . nl2br(str_replace("=", "=3D", $content)) . '</div>' . $rn;
        $msg .= $rn . '--' . $boundary_content . '--' . $rn;

//if attachement
        if (count($arr_file_attach)) {
            foreach ($arr_file_attach as $key => $file) {
                echo $key; echo '<hr />';
                if ($file != '' && file_exists($file)) {
                    $conAttached = self::prepareAttachment($file);
                    if ($conAttached !== false) {
                        $msg .= $rn . '--' . $boundary . $rn;
                        $msg .= $conAttached;
                    }
                }
            }
        }
// Fin
        $msg .= $rn . '--' . $boundary . '--' . $rn;
// Function mail()
        mail($to, $subject, $msg, $headers);
    }
    
    function stdMoney($strin = "", $numberDot = 3)
    {
        $strin = trim($strin);
        try{
            if(strpos($strin, ".") !== false){
                $strout = number_format($strin,$numberDot);
            }else if($strin == "" || $strin == "-"){
                $strout = $strin;
            }else{
                $strout = number_format($strin);
            }
        }  catch (Exception $e) { 
            var_dump($strin); die;
            
        }
        return $strout;
    }

    public static function changState($value = 0, $i, $canChange = true, $prefix = "archive.", $title_prefix = "day")
    {
        // Array of image, task, title, action
        $states	= array(
                0	=> array('unfeatured',	$prefix.'on', 'Toggle to change '.$title_prefix.' to on \' '),
                1	=> array('featured',	$prefix.'off', 'Toggle to change '.$title_prefix.' to off '),
        );
        $state	= isset($states[$value])?$states[$value]:$states[1];
        $icon	= $state[0];

        if ($canChange)
        {
                $html	= '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[1] . '\')" class="btn btn-micro hasTooltip' . ($value == 1 ? ' active' : '') . '" title="' . $state[2] . '"><i class="icon-'
                                . $icon . '"></i></a>';
        }
        else
        {
                $html	= '<a class="btn btn-micro hasTooltip disabled' . ($value == 1 ? ' active' : '') . '" title="' . $state[2] . '"><i class="icon-'
                                . $icon . '"></i></a>';
        }

        return $html;
    }
}
