<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InstallerController extends BackEndController {

    var $tablename = "{{extensions}}";
    var $tbl_menu = '{{menus}}';
    var $tbl_module = '{{modules}}';
    var $primary = 'id';
    var $item = null;
    private $model;

    function init() {
        yii::import('application.models.backend.installer.*');
        parent::init();
    }

    public function actionDisplay() {
        $this->render('install');
    }

    public function actionUploadext() {
       // $path_file_pach_install = "D:\wamp\www\bhmedia\benhvien\alpha/tmp/mainmenu.zip";
       // $filename = "mainmenu";
        
            $pack_install = $_FILES['install_package'];
            if ($pack_install == null or $pack_install['error'] != 0) {
                YiiMessage::raseWarning("Unable to find install package");
                $this->redirect($this->createUrl("/installer"));
            }

             
           // $YiiFile = new YiiFile; 
            
            $path_file_pach_install = PATH_TMP . $pack_install['name'];
            YiiFile::upload($pack_install['tmp_name'], $path_file_pach_install); 
            
            $file_info = pathinfo($path_file_pach_install);
            if (strtolower($file_info['extension']) != "zip") {
                
                YiiMessage::raseWarning("Invalid extension install package");
                YiiFile::delete($path_file_pach_install);
                $this->redirect($this->createUrl("/installer"));
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
            $this->redirect($this->createUrl("/installer"));
        }
        $files_xml = YiiFolder::files($path_extact, "\.xml", 1, true);
        if (count($files_xml) == 0) {
            YiiFile::delete($path_file_pach_install);
            YiiFolder::delete($path_extact);
            YiiMessage::raseWarning("Invalid extension install package");
            $this->redirect($this->createUrl("/installer"));
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
            $this->redirect($this->createUrl("/installer"));
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
            
         $this->redirect($this->createUrl("/installer"), "Succesfully install package");
    }

    public function actionUninstall(){
 
    }
    /* MANAGER */

    public function actionManager() {
        $task = Request::getVar('task', "");
        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatus($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatus($cid, 2);
                else
                    $this->changeStatus($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for extention");
        }else if ($task == "delete") {
            var_dump($_POST);
            die;
        }
 
        $obj_ext = YiiExtensions::getInstance();
        $extension = $obj_ext->loadExts();

        // $this->addIconToolbar("Edit", $this->createUrl("/user/edit"), "edit", 1, 1, "Please select a item from the list to edit");
        //$this->addIconToolbar("New", $this->createUrl("/user/new"), "new");
        $this->addIconToolbarDelete("Uninstall");
        $this->addBarTitle("Extension Manager <small>[Manage]</small>", "user");

        $this->render('manager', array("extentions" => $extension));
    }

    function changeStatus($cid, $value) {
        $obj_ext = YiiExtensions::getInstance();
        $obj_tblExt = $obj_ext->loadExt($cid);
        $obj_tblExt->status = $value;
        $obj_tblExt->store();
    }

}
