<?php

class ResumeapiController extends FrontEndController {

    public $item = array();
    public $tablename = "{{rsm_resume}}";
    public $primary = "id";

    function init() {
        $this->layout = "//resume/default";
        parent::init();
    }

    public function actionGetall() {
        $format = Request::getVar("format", "json");
        $userid = Request::getVar("userid", 0);
        $apikey = Request::getVar("apikey", "");
        $obj_result = new stdClass();
        $obj_result->status = true;
        $obj_result->message = "";
        if ($userid == 0 and strlen($apikey) < 10) {
            $obj_result->status = false;
            $obj_result->message = "Something errors";
        }
        $obj_result->userid = $userid;
        $obj_result->apikey = $apikey;
        $model = ResumeApi::getInstance();
        $resumes = $model->getResumes($userid, $apikey);
        $items = array();
        for ($i = 0; $i < count($resumes); $i++) {
            $resume = $resumes[$i];
            $item = new stdClass();
            $item->id = $resume["id"];
            $item->name = $resume["name"];
            $item->alias = $resume["alias"];
            $item->cdate = $resume["cdate"];
            $item->mdate = $resume["mdate"];
            $item->linkedit = WEB_URL . $this->createUrl("/resume/edit-layout/" . $item->id . '-' . $item->alias) . '.html';
            $item->linkview = WEB_URL . $this->createUrl("/resume/view-layout/" . $item->id . '-' . $item->alias) . '.html';
            $items[] = $item;
        }
        $obj_result->length = count($items);
        $obj_result->items = $items;

        $str_return = json_encode($obj_result);
        echo $str_return;
        die;
    }

//    http://resumebuilder.com/resume/api/down-file.rsm?format=json&userid=55&apikey=hadabdabd913uqdbadbqadada&resume_id=173&type=pdf
    
    function actionDownfile() {
        $format = Request::getVar("format", "json");
        $userid = Request::getVar("userid", 0);
        $apikey = Request::getVar("apikey", "");
        $cid = Request::getVar('resume_id', 0);
        $type = Request::getVar('type', "pdf");
        $obj_result = new stdClass();
        $obj_result->status = true;
        $obj_result->message = "";
        $obj_result->statuscode = "#200";
        
       
        if ($userid == 0 and strlen($apikey) < 10) {
            $obj_result->status = false;
            $obj_result->message = "Something errors";
            $obj_result->statuscode = "#443";
        }
        $obj_result->userid = $userid;
        $obj_result->apikey = $apikey;
        $obj_result->resume_id = $cid;
        $obj_result->type = $type;
        $model = ResumeApi::getInstance();

        if($obj_result->status == true)
        {
            // lay tat ca resume cua 1 user
            $resumes = $model->getResumes($userid, $apikey);
            if(count($resumes) == 0)
            {
                $obj_result->status = false;
                $obj_result->message = "Something errors";
                $obj_result->statuscode = "#404";
            }
        }
        
        if($obj_result->status == true)
        {
            $resume = $model->getResume($cid, $userid, $apikey);        
            if($resume == null){
                $obj_result->status = false;
                $obj_result->message = "Something errors";
                $obj_result->statuscode = "#405";
            }
        }
  
        if($obj_result->status == true)
        {
            $html_resume = $model->getHtml($cid, $resume['template_id']);
            $file_name = md5(uniqid("download-resume-"));
            file_put_contents(PATH_APIFILE.$file_name, $html_resume);
            $link_download = WEB_URL."/download.php?action=api&type=$type&dest=".$file_name;

            $obj_result->name = $resume['name'];
            $obj_result->link = $link_download;
        }
        
        $str_return = json_encode($obj_result);
        echo $str_return;
        die;
    }

    function postUrl($SourceURL_c, & $content = "", $fields = array()) {
        $curl_options_html = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => true, // don't return headers
            //       CURLOPT_NOBODY         => true,
            //       CURLOPT_CUSTOMREQUEST  => 'HEAD',
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11", // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        );
        $ch = curl_init($SourceURL_c);
        curl_setopt_array($ch, $curl_options_html);
        if (count($fields)) {
            $fields_string = "";
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . urlencode($value) . '&';
            }
            rtrim($fields_string, '&');
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        }

        $content = curl_exec($ch);
        $header_items = curl_getinfo($ch);
        curl_close($ch);
        return $header_items;
    }

}
