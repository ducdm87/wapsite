<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Users extends CFormModel {

    public $tablename = "{{users}}";
    public $table_group = "{{users_group}}";

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function getUsers($groupID = null, $order = null, $geAllChild = false) {
        $filter_state = Request::getVar('filter_state', -2);
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
        
        $list = array();
        $filter_state = Request::getVar('filter_state', -2);
        $filter_search = Request::getVar('filter_search', "");
        
        $items = array();
        $items[] = array("value"=>-2, "text"=>"- Select state -");
        $items[] = array("value"=>0, "text"=>"Unpublish");
        $items[] = array("value"=>1, "text"=>"Publish");
        $items[] = array("value"=>-1, "text"=>"Block");
       
        $list['filter_state'] = buildHtml::select($items, $filter_state, "filter_state", "filter_state", "onchange=\"document.adminForm.submit();\"");
         
        return $list;
    }
    
    function getItem($cid){
        $obj_users = YiiUser::getInstance();
        $item = $obj_users->getUser($cid);
        return $item;
    }
    
    function getListEdit($main_item){
        global $user;
        $modelGroup = new Group();
        
        $obj_user = YiiUser::getInstance();
        $group = $modelGroup->getItem($user->groupID);
        $condition = "";
        if($group->parentID != 1){
            $condition = "`lft` >= $group->lft AND `rgt` <= $group->rgt ";
        }

        $items = $obj_user->getGroups($condition, 'id value, name text, level');
        $list['groupID'] = buildHtml::select($items, $main_item->groupID, "groupID","","size=10", "&nbsp;&nbsp;&nbsp;","-");
         
        $items = array();
        $items[] = array("value"=>-2, "text"=>"- Select status -");
        $items[] = array("value"=>0, "text"=>"Unpublish");
        $items[] = array("value"=>1, "text"=>"Publish");
        $items[] = array("value"=>-1, "text"=>"Block");
       
        $list['status'] = buildHtml::select($items, $main_item->status, "status", "status");
         
                
        return $list;
    }

}
