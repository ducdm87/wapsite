<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    public $tablename = "{{users}}";
    public $table_group = "{{users_group}}";

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        global $mainframe, $user;

        if ($mainframe->isBackEnd()) {

            $query = "SELECT u.*,g.lft,g.name groupname, g.backend "
                    . "FROM " . $this->table_group . " g right join " . $this->tablename . " u ON g.id = u.groupID "
                    . " WHERE username = :username ANd password=:password AND u.status = 1 ";
            $password = md5($this->password);
            $conmmand = Yii::app()->db->createCommand($query);
            $conmmand->bindParam(':username', $this->username);
            $conmmand->bindParam(':password', $password);
            $result = $conmmand->queryRow();
            
            if (!$result) {
                YiiMessage::raseWarning("Invalid your usename or password");
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {
                $query = "UPDATE " . $this->tablename . " SET lastvisit = now() WHERE id = " . $result['id'];
                $command = Yii::app()->db->createCommand($query);
                $command->execute();
                $this->errorCode = self::ERROR_NONE;
            }

            $user = Yii::app()->session['userbackend'] = $result;

            $mainframe->set("user",$user);
            return !$this->errorCode;
        }else{
             $query = "SELECT * "
                    . "FROM " . $this->tablename
                    . " WHERE email = :username ANd password=:password AND status = 1 AND verify = 1 ";
             $password = md5($this->password);
            $conmmand = Yii::app()->dbuser->createCommand($query);
            $conmmand->bindParam(':username', $this->username);
            $conmmand->bindParam(':password', $password);
            $result = $conmmand->queryRow();

            if (!$result) {                
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {                
                $this->errorCode = self::ERROR_NONE;
            }
            $result['suppliers'] = "";
            $user = Yii::app()->session['userfront'] = $result;
            $mainframe->set("user",$user);
            return !$this->errorCode;
        }
    }

}
