<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Users extends CFormModel {

    public $tablename = "{{users}}";
    public $table_group = "{{users_group}}";

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Users();
        }
        return $instance;
    }
 
    public function getUsers($groupID = null, $order = null, $geAllChild = false) {
        $filter_state = Request::getVar('filter_state', -2);
        $filter_group = Request::getVar('filter_group', 0);
        $where = array();
        $cond = null;
        
       if($filter_state != -2 ) $where[] = "status = $filter_state";
        
        if($groupID != null){ 
            if($geAllChild == true){
                 $modelGroup = new Group(); 
                $groups = $modelGroup->getItems($groupID);
                $groups_id = array_keys($groups);
                $groups_id = implode(",", $groups_id);
                $where[] = " groupID IN($groups_id)";
            }else{
                $where[] = " groupID = $groupID"; 
            }
        }       

        if(count($where) > 0){
            $cond = implode(" AND ", $where); 
        }
        
        $obj_users = YiiUser::getInstance();       
        $items = $obj_users->getUsers($cond, '*', $order);
        return $items;
    }
    
    function getGroups($parentID = null, $getAll = true) {
        $obj_user = YiiUser::getInstance();
        $cond = "";
        if($parentID != null){ $cond = " parentID = $parentID"; }

        $groups = $obj_user->getGroups($cond);
        $arr_new = array();
        foreach ($groups as $group) {
            $arr_new[$group['id']] = $group;
        }
        $groups = $arr_new;
        
        return $groups;
    }
    
    function getList(){ 
        
        $lists = array();
        $filter_state = Request::getVar('filter_state', -2);
        $filter_search = Request::getVar('filter_search', "");
        $filter_group = Request::getVar('filter_group', 0);
        
        $items = array();
        $items[] = array("value"=>-2, "text"=>"- Select state -");
        $items[] = array("value"=>0, "text"=>"Unpublish");
        $items[] = array("value"=>1, "text"=>"Publish");
        $items[] = array("value"=>-1, "text"=>"Block");
       
        $lists['filter_state'] = buildHtml::select($items, $filter_state, "filter_state", "filter_state", "onchange=\"document.adminForm.submit();\"");
         
        global $user;
        
        $obj_user = YiiUser::getInstance();
        $group = $obj_user->getGroup($user->groupID);
        $condition = "parentID > 0";
        if($group->parentID != 1){
            $condition = "`lft` >= $group->lft AND `rgt` <= $group->rgt ";
        }
         
        $groups = $obj_user->getGroups($condition, 'id value, name text, level');
        array_unshift($groups, array("value"=>0, 'text'=>'-- Select group --'));
        $lists['filter_group'] = buildHtml::select($groups, $filter_group, "filter_group","","onchange=\"document.adminForm.submit();\"", "&nbsp;&nbsp;&nbsp;","");
         
        return $lists;
    }
    
    
    function getResources(){
        
    }
    
    function getGranted(){
        $cid = Request::getVar('cid',0);
        $obj_res_xref = YiiTables::getInstance(TBL_RSM_RESOURCE_XREF);
        $items = $obj_res_xref->loads("*"," object_type = 1 AND objectID = $cid");        
        if(count($items)){
            $arr_new = array();
            $arr_new['allow'] = array();
            $arr_new['deny'] = array();
            foreach($items as $item){
                if($item['value'] == 1)
                    $arr_new['allow'][$item['resourceID']] = $item['resourceID'];
                else $arr_new['deny'][$item['resourceID']] = $item['resourceID'];
            }
            $items = $arr_new;
        }
        return $items;
    }
    
    function getListGrant()
    {
        $lists = array();
        
        $items_status = array();
        $items_status[] = array(-1,'Default','danger');
        $items_status[] = array(1,'Allow','success');
        $items_status[] = array(0,'Deny','danger');
        $lists['item_status'] = $items_status;
        
        return $lists;
    }
     

}
