<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Media extends CFormModel {

    private $table = "{{videos}}";
    private $table_episode = "{{episode}}";
    private $table_categories = "{{categories}}";
    private $command;
    private $connection;

    function __construct() {
        parent::__construct();

        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Media();
        }
        return $instance;
    }

    public function getCountTotal() {
        $query = $this->command->select('COUNT(*)')
                ->from($this->table)
                ->queryAll();
        return (int) count($query);
    }

    public function addMedia($data) {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->command->insert($this->table, $data['film']);

            $film_id = $this->connection->getLastInsertID();

            if (isset($data['episode']) && $data['episode']) {
                $data['episode']['film_id'] = $film_id;
                $this->command->insert($this->table_episode, $data['episode']);
            }
            return $transaction->commit();
        } catch (Exception $e) {
            Yii::log('Eror!: ' + $e->getMessage());
            return $transaction->rollBack();
        }
    }

    public function getMedias($limit = 10, $offset = 0, $where = array()) {

        if ($limit > 0) {
            $this->command->limit($limit, $offset);
        }

        if ($where && is_array($where)) {
            foreach ($where as $key => $value) {
                if (!is_array($value)) {
                    $this->command->where($key, $value);
                } else {
                    foreach ($value as $k => $v) {
                        $this->command->where($k, $v);
                    }
                }
            }
        }

        $results = $this->command->select('f.*,c.title as name')
                ->from("$this->table  f")
                ->leftJoin("$this->table_categories  c", 'f.catID=c.id')
                ->queryAll();

        return $results;
    }

    public function deleteRecord($id) {
        $transaction = $this->connection->beginTransaction();
        try {
            $query = "SELECT * FROM " . $this->table_episode . " WHERE film_id =" . $id . "";
            $conmmand = Yii::app()->db->createCommand($query);
            $check_episode = $conmmand->queryRow();
            if ($check_episode) {
                $this->command->delete($this->table_episode, 'episode_id=:ep_id', array('ep_id' => $check_episode['episode_id']));
            }
            $this->command->delete($this->table, 'id=:id', array('id' => $id));
            return $transaction->commit();
        } catch (Exception $e) {
            Yii::log('Eror!: ' + $e->getMessage());

            return $transaction->rollback();
        }
    }

    public function updateMedia($data) {
        $transaction = $this->connection->beginTransaction();
        try {
            if (isset($data['episode']) && $data['episode']) {
                $query = "SELECT * FROM " . $this->table_episode . " WHERE film_id =" . $data['film']['id'] . "";
                $conmmand = Yii::app()->db->createCommand($query);
                $check_episode = $conmmand->queryRow();
                if ($check_episode) {
                    $this->command->update($this->table_episode, $data['episode'], 'episode_id=:ep_id', array('ep_id' => $check_episode['episode_id']));
                }
            }
            $this->command->update($this->table, $data['film'], 'id=:id', array('id' => $data['film']['id']));
            return $transaction->commit();
        } catch (Exception $e) {
            Yii::log('Eror!: ' + $e->getMessage());
            return $transaction->rollBack();
        }
    }

    public function getMediaById($id) {

        $results = $this->command->select('f.*,ep.*')
                ->from("$this->table  f")
                ->leftJoin("$this->table_episode  ep", 'ep.film_id=f.id')
                ->where("f.id=$id")
                ->queryRow();
        //var_dump($results);die;
        return $results;
    }

}
