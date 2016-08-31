<?php

class CommentsModel extends BaseModel
{
    public function getCommentById($comment_id){
        $statement = self::$db->prepare("SELECT * ".
            "FROM `comments` ".
            "WHERE `comments`.`id` = ?");
        $statement->bind_param("i", $comment_id);
        $statement->execute();

        return $statement;
    }

    public function deleteCommentById($comment_id){
        $statement = self::$db->prepare("DELETE FROM `comments` WHERE `comments`.`id` = ?");
        $statement->bind_param("i", $comment_id);
        $statement->execute();

        return $statement;
    }
}