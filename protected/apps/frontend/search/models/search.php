<?php

class User extends CFormModel {

    var $tablename = "{{users}}";
    var $tbl_resume = "{{rsm_resume}}";
    var $tbl_template = "{{rsm_template}}";
    var $default_groupID = 19;
    var $table_user_meta = "{{user_metas}}";
    var $str_error = "";
    var $db = "";
    var $user = null;
    private $command;
    private $connection;

    function __construct() {
        $this->default_groupID = DEFAULT_GROUPID;
//        dbuser
        $this->db = Yii::app()->db;
        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new User();
        }
        return $instance;
    }

    public function getMedias($limit = 10, $offset = 0, $where = array(), $query = array(), $oder = 'm.viewed', $by = 'DESC', $random = false) {

        if ($limit > 0) {
            $this->command->limit($limit, $offset);
        }

        if ($where && is_array($where)) {
            foreach ($where as $key => $value) {
                if (!is_array($value)) {
                    $param = explode('.', $key);
                    if (is_array($param))
                        $param = $param[1];
                    $this->command->where(array("OR", "$key" . "=:" . "$param"), array("$param" => $value));
                }
            }
        }
        
        if ($query) {
            $this->command->where(array('like', 'm.title', "%$query%"));
        }
        if ($oder) {
            $this->command->order("$oder $by");
        }
        if ($random) {
            $this->command->order(array('RAND()'));
        }
        $results = $this->command->select('m.*,c.title as name,c.alias as calias, c.id as cid,ep.*,lk.*')
                ->from("$this->table  m")
                ->join("$this->table_categories  c", 'm.category_id=c.id')
                ->join("$this->table_episode  ep", 'm.id=ep.film_id')
                ->leftjoin("$this->table_like lk", "m.id=lk.fid")
                ->queryAll();
        return $results;
    }
}
