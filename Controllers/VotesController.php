<?php

class VotesController extends BaseController
{
    public function index(){
        if(!$this->isPost) {
            echo '<div class="error" data-msg="Only post methods accepted!!" data-timeout="10000">Only post methods accepted!</div>';
            return;
        }
        if(! (key_exists('boolVote',$_POST) &&
            key_exists('comment_id',$_POST) &&
            key_exists('voter_id',$_POST))){
            echo '<div class="error" data-msg="Query data corrupted, please try again!" data-timeout="10000">Query data corrupted, please try again!</div>';
            return;
        }
        $value = $_POST['boolVote'];

        if($value=="true"){
            $value=true;
        }
        $comment_id = $_POST['comment_id'];
        $voter_id = $_POST['voter_id'];

        $statement = $this->model->deleteIfExists($comment_id,$voter_id);
        if($statement->error){
            echo '<div class="error" data-msg="Error when deleting old vote!" data-timeout="10000">Error when deleting old vote!</div>';
            return;
        }

        $statement = $this->model->insertVote($value,$comment_id,$voter_id);
        if($statement->error){
            echo '<div class="error" data-msg="Error when inserting new vote!" data-timeout="10000">Error when inserting, '. $statement->error .' </div>';
            return;
        }

        $statement = $this->model->getVotesForComment(true, $comment_id);
        if($statement->error){
            echo '<div class="error" data-msg="Error when getting votes for comment!" data-timeout="10000">Error when getting votes for comment! </div>';
            return;
        }
        $upvotes = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach($upvotes as $upvote){
            if($upvote['voter_id'] == $voter_id){
                $upvotes['user_voted']=true;
                break;
            }
        }
        $upvotes = json_encode($upvotes);

        $statement = $this->model->getVotesForComment(false, $comment_id);
        if($statement->error){
            echo '<div class="error" data-msg="Error when getting votes for comment!" data-timeout="10000">Error when getting votes for comment! </div>';
            return;
        }
        $downvotes = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach($downvotes as $downvote){
            if($downvote['voter_id'] == $voter_id){
                $downvotes['user_voted']=true;
                break;
            }
        }
        $downvotes = json_encode($downvotes);
        echo $upvotes;
        echo "|";
        echo $downvotes;
    }




}