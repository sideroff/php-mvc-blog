<?php

class PostsController extends BaseController
{
    private $currentPostId;
    private $currentCommentId;

    public function all(){
        $statement = $this->model->getPosts();
        $this->checkStatement($statement);
        $this->posts = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function index($params=null){
        if($params && count($params)>0){
            $this->currentPostId = $params[0];
        }
        else{
            $this->addMessage("No id of post supplied!",self::$errorMsg);
            $this->redirect("Posts","all");
        }
        //--- IF POSTING 
        if($this->isPost){
            $this->checkSession();
            if(!$this->isLoggedIn){
                $this->addMessage("Action prohibited! Log in first!",self::$errorMsg);
                $this->redirect("Posts","index",[$this->currentPostId]);
            }
            if($_POST && key_exists('content',$_POST) && strlen($_POST['content'])>=5){
                $statement = $this->model->comment($this->currentPostId);

                if($statement->error){
                    $this->addMessage("Something went wrong while proccessing your request! " . $statement->error,self::$errorMsg);
                }
                else{
                    $this->addMessage("Your comment has been posted!", self::$successMsg);
                }
            }
            else{
                $this->addMessage("Please fill comment with atleast 5 symbols!",self::$errorMsg);
            }
            $this->redirect("Posts","index",[$this->currentPostId]);
        }

        //---GET POST
        $statement = $this->model->getPostById($this->currentPostId);
        if($statement->error){
            $this->addMessage("Something went wrong while proccessing your reqeust! ".$statement->error, self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $post = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        if(count($post)==0){
            $this->addMessage("No post with such id found", self::$errorMsg);
            $this->redirect("Posts","all");
        }

        //---GET COMMENTS
        $statement = $this->model->getComments($this->currentPostId);
        if($statement->error){
            $this->addMessage("Something went wrong while retrieving comments! " . $statement->error,self::$errorMsg);
            $this->redirect("Posts","index",$this->currentPostId);
        }
        $comments = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach($comments as &$comment){
            $statement = $this->model->getVotesForComment(true,$comment['comment_id']);
            if($statement->error){
                continue;
            }
            $upvotes = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
            $comment['upvotes'] = $upvotes;

            $newStatement = $this->model->getVotesForComment(false,$comment['comment_id']);
            if($newStatement->error){
                continue;
            }
            $downvotes = $newStatement->get_result()->fetch_all(MYSQLI_ASSOC);
            $comment['downvotes'] = $downvotes;
        }
        $_SESSION['statement']['post'] = $post[0];
        $_SESSION['statement']['comments'] = $comments;
    }

    public function create(){
        $this->checkSession();
        if(!$this->isLoggedIn){
            $this->addMessage("You must be logged in first!", self::$errorMsg);
            $this->redirect("Users","login");
        }
        var_dump($_POST);
        if($this->isPost){
            if(!$_POST ||
                !key_exists(FORM_POST_TITLE, $_POST) ||
                !key_exists(FORM_POST_CONTENT,$_POST) ||
                strlen($_POST[FORM_POST_TITLE])<1 ||
                strlen($_POST[FORM_POST_CONTENT])<1){
                $_SESSION['post-query'] = $_POST;
                $this->addMessage("Please fill all fields in order to submit the post!", self::$errorMsg);
                $this->redirect("Posts","create");
            }
            $statement = $this->model->create();
            if($statement->error){
                $this->addMessage("Something went wrong while proccessing your request! " . $statement->error, self::$errorMsg);
                $this->redirect("Posts","create");
            }
            $this->addMessage("Your post has been submitted!",self::$successMsg);
            $id=$statement->insert_id;
            $this->redirect("Posts","index",[$id]);
        }
    }    

    public function edit($params = null){
        if($params && count($params)>0){
            $this->currentPostId = $params[0];
        }
        else{
            $this->addMessage("No id of post supplied!",self::$errorMsg);
            $this->redirect("Posts","all");
        }

        if(!$this->isPost){
            $statement = $this->model->getPostById($this->currentPostId);
            if($statement->error){
                $this->addMessage("Something went wrong while getting post! ".$statement->error, self::$errorMsg);
                $this->redirect("Posts","all");
            }
            $post = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
            if(count($post)==0){
                $this->addMessage("No post with such id found", self::$errorMsg);
                $this->redirect("Posts","all");
            }
            $post= $post[0];
            $this->checkSession();
            if(!($this->isLoggedIn) || $post['username']!=$_SESSION['username']){
                $this->addMessage("Action prohibited!", self::$errorMsg);
                $this->redirect("Posts","all");
            }
            $_SESSION['post'] = $post;
            return;
        }
        $title=null;
        $content=null;
        if($_POST && key_exists('title',$_POST) && strlen($_POST['title'])>0 ){
            $title=$_POST['title'];
        }

        if(($_POST && key_exists('content',$_POST) && strlen($_POST['content'])>0 )){
            $content=$_POST['content'];
        }
        if(!$title || !$content){
            $this->addMessage("Post title/content cannot be blank!",self::$errorMsg);
            $this->redirect("Posts","index",[$this->currentPostId]);
        }
        $statement = $this->model->edit($_SESSION['post']['post_id'],$title,$content);
        if($statement->error){
            $this->addMessage("Something went wrong while editing post: " . $statement->error,self::$errorMsg);
            $this->redirect("Posts","all");
        }
        else{
            $this->addMessage("Your changes have been saved!",self::$successMsg);
            $this->redirect("Posts","index",[$this->currentPostId]);
        }
    }
    
    public function delete($params = null){
        if($params && count($params)>0){
            $this->currentPostId = $params[0];
        }
        else{
            $this->addMessage("No id of post supplied!",self::$errorMsg);
            $this->redirect("Posts","all");
        }

        $statement = $this->model->getPostById($this->currentPostId);
        if($statement->error){
            $this->addMessage("Something went wrong while getting post! ".$statement->error, self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $post = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        if(count($post)==0){
            $this->addMessage("No post with such id found", self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $post= $post[0];
        $this->checkSession();
        if(!($this->isLoggedIn) || $post['username']!=$_SESSION['username']){
            $this->addMessage("Action prohibited!", self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $_SESSION['post'] = $post;
        
        if($this->isPost){
            $statement = $this->model->delete($this->currentPostId);
            if($statement->error){
                $this->addMessage("Something went wrong while deleting post! ".$statement->error, self::$errorMsg);
            }
            else{
                $this->addMessage("Post deleted sucessfully!",self::$infoMsg);
            }
            $this->redirect("Posts","all");
        }
    }
    
    public function deleteComment($params = null){
        if($params && count($params)>0){
            $this->currentCommentId = $params[0];
        }
        else{
            $this->addMessage("No id of post supplied!",self::$errorMsg);
            $this->redirect("Posts","all");
        }
        if(!$this->isPost){

            $this->addMessage("Action prohibited!",self::$errorMsg);
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
        if($this->isPost){
            $statement = $this->model->deleteCommentById([$this->currentPostId]);
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