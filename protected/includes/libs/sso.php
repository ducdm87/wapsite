<?php

class sso {

    function filterAction($task) {
        $arr_action = array("privatepage");
        return !in_array($task, $arr_action);
    }

    public static function checkAuthentication($apiKey) {
        global $apiKey, $isLogin, $link_ajax_login, $linkApi_Authen;

        if ($apiKey == "")
            return false;

        $link_request = $linkApi_Authen . "?apiKey=$apiKey&user=";
        $content = file_get_contents($link_request);
        $obj_json = json_decode($content, true);        
        $user = isset($obj_json['user']) ? $obj_json['user'] : "";
        if ($obj_json['status'] == -1) {
            setcookie('apiKey', '', -1);
            if (isset(Yii::app()->session['userfront'])) {
                unset(Yii::app()->session['userfront']);
            }
        } else {
            setcookie('apiKey', $apiKey, time() + $obj_json['time_out'],"/");
            Yii::app()->session['userfront'] = $obj_json['userInfo'];
        }

        return $obj_json['status'];
    }
}
