<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  

class YiiModule{
    private $items = array();
    private $item = array();
    private $active = 0;
    var $_db = null;
    
    private $table = "{{modules}}";
    
    function __construct($db = null) {
        $this->_db = $db;        
        if($this->_db == null) $this->_db = Yii::app()->db;
        
         $this->table = TBL_MODULES;
    }
    
    static function & getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new YiiModule();
        }

        return $instance;
    } 
    
    function loadItems($field = null, $condition = ""){
        if($field == null){
           $field = "a.id, a.title, a.alias, a.showtitle, a.cdate, a.mdate, a.ordering, a.position, a.menu, a.module, a.description, a.status + 2*(b.status - 1) as status, a.params";
        }
        
        $command = $this->_db->createCommand()->select($field)
                ->from(TBL_MODULES . " as a")
                ->leftjoin(TBL_EXTENSIONS . " as b", " a.module = b.folder");
        if($condition != null) $command->where($condition);
        $items = $command->queryAll();     
        return $items;
    }
    
    function loadItem($id, $field = "*"){
        $table_menu = YiiTables::getInstance(TBL_MODULES);
        $table_menu->load($id);
       return $table_menu;
    }
    
    function loadXrefMenu($moduleID)
    {
        $obj_menuitem = YiiTables::getInstance(TBL_MODULE_MENUITEM_REF);
        return $obj_menuitem->loadColumn("menuID", "moduleID = $moduleID", null,null);
    }
    
    
    // load modules
    static function loadModules($position = "top", $type = "yii"){
        global $Yii_datamodule;
        if(!isset($Yii_datamodule)) $Yii_datamodule = array();
        if(isset($Yii_datamodule[$position])) return implode ("", $Yii_datamodule[$position]);
        
        $Yii_datamodule[$position] = array();
        $menuID = Request::getVar('menuID',1);
    
        $obj_module = YiiModule::getInstance();
        $items = $obj_module->loadItems(null, " position = '$position'");
         if(count($items)){
             foreach($items as $item){
                $str_module = $obj_module->loadModule($item);
                if($str_module!=""){
                    $fn = "modYii_$type";
                    if(function_exists($fn))
                        $Yii_datamodule[$position][] = $fn($str_module, $item);
                    else $Yii_datamodule[$position][] = $str_module;
                }
            }
         }
        return implode ("", $Yii_datamodule[$position]);
    }
    
    function loadModule($module = null){
        global $path_module;    
        
        $moduleName = $module['module'];
//         $module['params']; title, menu

        $path = Yii::app()->basePath . "/extensions/modules/$moduleName";
        $module_xml_file = "$path/$moduleName.xml";
        $module_main_file = "$path/$moduleName.php";
        $params = json_decode($module['params']);        
        if(file_exists($module_main_file)){
            ob_start();
            require_once $module_main_file;
            $str = ob_get_contents();
            ob_end_clean();
            return $str;
        }
        return "";
    }
    
    function loadLayout($moduleName, $tpl = "default"){
        $path = Yii::app()->basePath . "/extensions/modules/$moduleName";
        $module_layout = "$path/tmpl/$tpl.php";
        return $module_layout;
    }
}
