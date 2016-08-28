<?php

class HomeModel extends BaseModel
{
    public function getLatestRegisteredUserUsername(int $count = NULL){
        $query= "SELECT username FROM `users` ORDER BY users.date_registered DESC";
        
        return $this->executeQuery($query, $count);
    }
    public function getLastPosts(int $count = NULL) {
        $query= "SELECT title,content,author_id, date_created, username FROM posts LEFT JOIN users ON posts.author_id = users.id ORDER BY posts.date_created DESC";
        
        return $this->executeQuery($query, $count);
    }
    
    private function executeQuery(string $query, int $count = NULL){
        $shouldBindParam = false;
        
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