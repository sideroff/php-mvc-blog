<?php
class UsersModel extends BaseModel{
    
    public function login(string $usernameOrEmail, string $password){

        $pass_hash = hash(DEFAULT_HASH_ALGORITHM,$password);
        $statement = self::$db->prepare("SELECT * FROM users WHERE username = ?");
        $statement->bind_param("s",$usernameOrEmail);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        
        if($result){
            if(key_exists('id',$result)){
                return $result['id'];                
            }
        }
        return false;
    }
}