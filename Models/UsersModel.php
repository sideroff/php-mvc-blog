<?php
class UsersModel extends BaseModel{
    
    public function login(){
        $statement = self::$db->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $statement->bind_param("s",$_POST[FORM_USERNAME]);
        $statement->execute();
        return $statement;
    }

    public function register(){
        $statement = self::$db->prepare("INSERT INTO users (username, password_hash, first_name, last_name, email)"
                                        . "VALUES (?,?,?,?,?)");
        $statement->bind_param("sssss",
            $_POST[FORM_USERNAME],
            $_POST[FORM_PASSWORD],
            $_POST[FORM_FIRST_NAME],
            $_POST[FORM_LAST_NAME],
            $_POST[FORM_EMAIL]);
        $statement->execute();
        return $statement;
    }
}