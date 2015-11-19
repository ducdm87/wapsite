<?php

class HomeController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{menus}}";
    var $tbl_menuitem = "{{menu_item}}";
    var $item = null;
    var $item2 = null;
    var $items = array();

    function init() {
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionDisplay() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to install extension");
            $this->redirect(Router::buildLink("cpanel"));
        }
        $this->render('default');
    }
    
    public function actionUploadext() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to install extension");
            $this->redirect(Router::buildLink("cpanel"));
        }


        $pack_install = $_FILES['install_package'];
        if ($pack_install == null or $pack_install['error'] != 0) {
            YiiMessage::raseWarning("Unable to find install package");
            $this->redirect(Router::buildLink("installer"));
        }


       // $YiiFile = new YiiFile; 

        $path_file_pach_install = PATH_TMP . $pack_install['name'];
        YiiFile::upload($pack_install['tmp_name'], $path_file_pach_install); 

        $file_info = pathinfo($path_file_pach_install);
        if (strtolower($file_info['extension']) != "zip") {

            YiiMessage::raseWarning("Invalid extension install package");
            YiiFile::delete($path_file_pach_install);
            $this->redirect(Router::buildLink("installer"));
        }
        $filename = $file_info['filename'];
        

        $zip = new ZipArchive;
        $res = $zip->open($path_file_pach_install);
        $path_extact = PATH_TMP . $filename;
        if ($res === TRUE) {
            $zip->extractTo($path_extact);
            $zip->close();
        } else {
            YiiMessage::raseWarning("Invalid extract file install package");
            YiiFile::delete($path_file_pach_install);
            $this->redirect(Router::buildLink("installer"));
        }
        $files_xml = YiiFolder::files($path_extact, "\.xml", 1, true);
        if (count($files_xml) == 0) {
            YiiFile::delete($path_file_pach_install);
            YiiFolder::delete($path_extact);
            YiiMessage::raseWarning("Invalid extension install package");
            $this->redirect(Router::buildLink("installer"));
        }
        $xml = null;

        foreach ($files_xml as $file_xml) {
            $xml = simplexml_load_file($file_xml);
            if (!$xml){
                unset($xml);
                continue;
            }
                
            if ($xml->getName() != 'extension') {
                unset($xml);
                continue;
            }
            $type = (string) $xml->attributes()->type;
            if (!in_array($type, array("app", "module")))
            {
                unset($xml);
                continue;
            }
        }

        $type = (string) $xml->attributes()->type;
        $row_ext = YiiTables::getInstance(TBL_EXTENSIONS);
        
        $arr_info = array();
        $arr_info['title'] = (string)$xml->title;
        $arr_info['name'] = (string)$xml->name;
        $arr_info['alias'] = $this->convertalias($arr_info['title']);
        $arr_info['author'] = (string)$xml->author;
        $arr_info['version'] = (string)$xml->version;
        $arr_info['creationDate'] = (string)$xml->creationDate;
        $arr_info['description'] = (string)$xml->description;
        $arr_info['type'] = (string) $xml->attributes()->type;
        $arr_info['folder'] = trim(preg_replace('/[^\w\d]+/is', '', $row_ext->title));
        $arr_info['client'] = (string) $xml->attributes()->client;
        if($arr_info['client'] == "") $arr_info['client'] = 1;
        
        $row_ext->loadRow("*", "title = '".$arr_info['title']."' OR alias = '" .$arr_info['alias']. "'");
      
        $ext_new = false;
        if($row_ext->id == 0){
            $row_ext->cdate = date("Y-m-d H:i:s");
            $ext_new = true;
        } 
        
        $row_ext->mdate = date("Y-m-d H:i:s");
        $row_ext->bind($arr_info);
        
        $path_ext = PATH_MODULES . $row_ext->folder;
        if($row_ext->type == "app" and $row_ext->client == 1 )
            $path_ext = PATH_APPS_FRONT. $row_ext->folder;
        else if($row_ext->type == "app" and $row_ext->client == 0 )
            $path_ext = PATH_APPS_BACKEND. $row_ext->folder;
             
        if(!YiiFolder::create($path_ext,0775))
        {
            YiiMessage::raseWarning("FILESYSTEM ERROR Could not create directory");
            YiiFile::delete($path_file_pach_install);
            YiiFolder::delete($path_extact);
            $this->redirect(Router::buildLink("installer"));
        }
                

        $bool = YiiFolder::copy($path_extact, $path_ext,'',1);
        if($row_ext->type == "module" AND $ext_new == true){
            $row_module = YiiTables::getInstance(TBL_MODULES);
            $row_module->title = $row_ext->title;
            $row_module->alias = $row_ext->alias;
            $row_module->cdate = date("Y-m-d H:i:s");
            $row_module->mdate = date("Y-m-d H:i:s");
            $row_module->module = $row_ext->folder;
            $row_module->status = 0;
            $row_module->store();
        }
        YiiFile::delete($path_file_pach_install);
        YiiFolder::delete($path_extact);
            
         $this->redirect(Router::buildLink("installer"), "Succesfully install package");
    }

    
     
}
