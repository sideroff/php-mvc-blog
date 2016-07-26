<?php

/**
 * Created by PhpStorm.
 * User: ivans
 * Date: 17.7.2016 г.
 * Time: 17:40
 */
class HomeModel extends BaseModel
{
    public function GetLastPosts(int $count = NULL) : array {
        $shouldBindParam = false;
        $query= "SELECT * FROM posts";
        if($count!=NULL){
            $query = $query ."LIMIT ?";
            $shouldBindParam = true;
        }


        $statement = self::$db->prepare($query);
        if($shouldBindParam){
            $statement->bind_param("i", $count);
        }
        $statement->execute();
        $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}