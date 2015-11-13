<?php
require_once 'helper.php';

$helper = new MainmenuHelper();

  
$menutype = $params->menutype;
$showChildren = $params->showAllChildren; 

$items = $helper->getItems($menutype, $showChildren);
 

require YiiModule::loadLayout("mainmenu",$tpl = "default");
?>
 
 
