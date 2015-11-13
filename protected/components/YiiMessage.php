<?php

/**
 * Description of system
 *
 * @author Administrator
 */
class YiiMessage {

    //put your code here
    private static $message = "";

    static function raseNotice($message) {
        YiiMessage::$message = $message;
        Yii::app()->session['message'] = $message;
        Yii::app()->session['rasestatuscode'] = "danger";
    }

    static function raseWarning($message) {
        YiiMessage::$message = $message;
        Yii::app()->session['message'] = $message;
        Yii::app()->session['rasestatuscode'] = "warning";
    }
    
    static function raseInfo($message) {
        YiiMessage::$message = $message;
        Yii::app()->session['message'] = $message;
        Yii::app()->session['rasestatuscode'] = "info";
    }
    
    static function raseSuccess($message) {
        YiiMessage::$message = $message;
        Yii::app()->session['message'] = $message;
        Yii::app()->session['rasestatuscode'] = "success";
    }

    static function showMessage() {
        $message = Yii::app()->session['message'];
        if (!empty($message) and $message != "") {
            $status = Yii::app()->session['rasestatuscode'];
            $str_out = '<div class="alert alert-'.$status.'">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>'.  ucfirst($status).'!</strong> '.$message.'
              </div>';
            
            echo $str_out;
            Yii::app()->session['message'] = null;
            Yii::app()->session['rasestatuscode'] = null;
        }
    }

}
