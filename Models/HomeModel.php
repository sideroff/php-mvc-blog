<?php

/**
 * Created by PhpStorm.
 * User: ivans
 * Date: 17.7.2016 г.
 * Time: 17:40
 */
class HomeModel extends BaseModel
{
    public function GetLastPosts(int $count = NULL) {
        $shouldBindParam = false;
        $query= "SELECT title,content,author_id, date_created, username FROM posts LEFT JOIN users ON posts.author_id = users.id ORDER BY posts.date_created DESC";
        if($count!=NULL){
            $query = $query ." LIMIT ?";
            $shouldBindParam = true;
        }


        $statement = self::$db->prepare($query);
        if($shouldBindParam){
            $statement->bind_param("i", $count);
        }
        $statement->execute();

        return $statement;
    }
}