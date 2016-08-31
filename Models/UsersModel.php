<?php
class UsersModel extends BaseModel{
    
    public function login($username){
        $statement = self::$db->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $statement->bind_param("s",$username);
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

        public function profile(string $username){
        $statement = self::$db->prepare(
            "SELECT users.id, username, first_name, last_name, email, date_registered " .
            "FROM users " .
            "WHERE username = ? ");
        $statement->bind_param("s",$username);
        $statement->execute();
        
        return $statement;
    }

    public function changeAvatar(string $file_name, string $file_type){

        if(file_exists(AVATARS_PATH . $file_name)){
            unlink(AVATARS_PATH . $file_name);
        }
        $success = move_uploaded_file($_FILES["avatar"]["tmp_name"], "../" . AVATARS_PATH . $_SESSION['userId'] . "." . $file_type);
        
        return $success;
    }
}