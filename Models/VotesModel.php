<?php

class VotesModel extends BaseModel
{
    public function deleteIfExists($comment_id,$voter_id){
        $statement = self::$db->prepare("DELETE FROM `comment_votes` WHERE `comment_votes`.`comment_id` = ? AND `comment_votes`.`voter_id` = ?");
        $statement->bind_param("ii",$comment_id,$voter_id);
        $statement->execute();

        return $statement;
    }

    public function insertVote($value,$comment_id,$voter_id){
        $statement = self::$db->prepare("INSERT INTO `comment_votes`(`comment_id`, `voter_id`,`value`) VALUES (?,?,?)");
        $val = intval($value);
        $statement->bind_param("iii",$comment_id,$voter_id,$val);
        $statement->execute();

        return $statement;
    }

    public function getVotesForComment(bool $upOrDownVote,int $commentId){
        $statement = self::$db->prepare("SELECT * FROM comment_votes WHERE comment_votes.value=? AND comment_votes.comment_id = ?");
        $val = intval($upOrDownVote);
        $statement->bind_param("ii", $val,$commentId);
        $statement->execute();

        return $statement;
    }
}