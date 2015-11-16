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
    public function getUsers() {
        $obj_users = YiiUser::getInstance();
        $items = $obj_users->getUsers();
        return $items;
    }

    function getGroups() {
        $obj_user = YiiUser::getInstance();
        $groups = $obj_user->getGroups();
        $arr_new = array();
        foreach ($groups as $group) {
            $arr_new[$group['id']] = $group;
        }
        $groups = $arr_new;
        
        return $groups;
    }
    
    function getItem($cid){
        $obj_users = YiiUser::getInstance();
        $item = $obj_users->getUser($cid);
        return $item;
    }
    
    function getListEdit($main_item){
        $obj_user = YiiUser::getInstance();
 
        $condition = "`level` >= 1 ";
        $items = $obj_user->getGroups($condition, 'id value, name text, level');
        $list['groupID'] = buildHtml::select($items, $main_item->groupID, "groupID","","size=10", "&nbsp;&nbsp;&nbsp;","-");
         
                
        return $list;
    }

}
