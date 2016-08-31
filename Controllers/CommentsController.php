<?php

class CommentsController extends BaseController
{
    private $currentCommentId;


    public function delete($params = null){
        if($params && count($params)>0){
            $this->currentCommentId = $params[0];
        }
        else{
            $this->addMessage("No id of post supplied!",self::$errorMsg);
            $this->redirect("Posts","all");
        }

        $statement = $this->model->getCommentById($this->currentCommentId);
        if($statement->error){
            $this->addMessage("Something went wrong while getting comment! ".$statement->error, self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $comment = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        if(count($comment)==0){
            $this->addMessage("No comment with such id found", self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $comment= $comment[0];
        $this->checkSession();
        if(!($this->isLoggedIn) || $comment['author_id']!=$_SESSION['userId']){
            $this->addMessage("Action prohibited weeeeee!", self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $_SESSION['comment'] = $comment;
        if($this->isPost){
            $statement = $this->model->deleteCommentById($this->currentCommentId);
            if($statement->error){
                $this->addMessage("Something went wrong while deleting comment! ".$statement->error, self::$errorMsg);
            }
            else{
                $this->addMessage("Comment deleted sucessfully!",self::$infoMsg);
            }
            $this->redirect("Posts","all");
        }

    }

}