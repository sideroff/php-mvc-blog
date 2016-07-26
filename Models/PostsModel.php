<?php

class PostsModel extends BaseModel
{
    public function getPosts(int $count = '*') {
        $statement = self::$db->query("SELECT $count FROM posts ORDER BY DESC");
        $result=$statement->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}