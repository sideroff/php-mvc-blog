<?php


class BaseModel
{
    protected static $db;

    public function __construct()
    {
        if(!isset($db)) {
            // Create connection
            self::$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASS, DB_NAME);
            self::$db->set_charset('utf8');

            // Check connection
            if (self::$db->connect_error) {
                die("Connection failed: " . self::$db->connect_error);
            }
        }
    }
    
    public function getPosts(int $limit = NULL) {
        $query= "SELECT title,content,author_id, date_created, username FROM posts LEFT JOIN users ON posts.author_id = users.id ORDER BY posts.date_created DESC";

        return $this->executeQuery($query, $limit);
    }

    protected function executeQuery(string $query, int $count = NULL){
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