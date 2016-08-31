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

        $newStatement = $this->model->deleteIfExists($comment_id,$voter_id);
        if($newStatement->error){
            echo '<div class="error" data-msg="Error when deleting old vote!" data-timeout="10000">Error when deleting old vote!</div>';
            return;
        }

        $newStatement = $this->model->insertVote($value,$comment_id,$voter_id);
        if($newStatement->error){
            echo '<div class="error" data-msg="Error when inserting new vote!" data-timeout="10000">Error when inserting, '. $newStatement->error .' </div>';
            return;
        }
    }




}