<?php
class UsersModel extends BaseModel{
    
    public function login(string $usernameOrEmail, string $password){
        $statement = self::$db->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $statement->bind_param("s",$usernameOrEmail);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        
        if($result &&
            key_exists('id',$result) &&
            key_exists('password_hash',$result)){

            if(password_verify($result['password_hash'],hash(DEFAULT_HASH_ALGORITHM,$password))){

                return $result['id'];
            }
        }
        return false;
    }
}