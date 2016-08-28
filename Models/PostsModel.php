<?php

class PostsModel extends BaseModel
{
    public function getPosts() {
        $statement = self::$db->query("SELECT title,content,author_id, date_created, username   FROM posts LEFT JOIN users ON posts.author_id = users.id ORDER BY posts.date_created DESC");
        $result=$statement->fetch_all(MYSQLI_ASSOC);
        
        return $result;
    }
    
    public function create(){
        $title = $_POST[FORM_POST_TITLE];
        $content = $_POST[FORM_POST_CONTENT];
        
        $statement = self::$db->prepare("INSERT INTO `posts` (`title`, `content`,`author_id`) VALUES (?,?,?)");
        $statement->bind_param("ssi", $title, $content,$_SESSION['userId']);
        $statement->execute();
        
        return $statement;        
    }
}