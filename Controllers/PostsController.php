<?php

class PostsController extends BaseController
{
    private $currentPostId;
    public function index($params=null){
        if($params && count($params)>0){
            $this->currentPostId = $params[0];
        }
        else{
            $this->addMessage("No id of post supplied!",self::$errorMsg);
            $this->redirect("Posts","all");
        }
        if($this->isPost){
            $title=null;
            $content=null;
            if($_POST && key_exists('title',$_POST) && strlen($_POST['title'])>0 ){
                $title=$_POST['title'];
            }

            if(($_POST && key_exists('title',$_POST) && strlen($_POST['content'])>0 )){
                $content=$_POST['content'];
            }
            if(!$title || !$content){
                $this->addMessage("Post title/content cannot be blank!",self::$errorMsg);
                $this->redirect("Posts","index",[$this->currentPostId]);
            }
            $statement = $this->model->index($title,$content);
            if($statement->error){
                $this->addMessage("Something went wrong while proccessing your request: " . $statement->error,self::$errorMsg);
                $this->redirect("Posts","all");
            }
            else{
                $this->addMessage("Your changes have been saved!",self::$successMsg);
                $this->redirect("Posts","index",[$this->currentPostId]);
            }
        }

        $statement = $this->model->getPostById($this->currentPostId);
        if($statement->error){
            $this->addMessage("Something went wrong while proccessing your reqeust! ".$statement->error, self::$errorMsg);
            $this->redirect("Posts","all");
        }
        $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        if(count($result)==0){
            $this->addMessage("No post with such id found", self::$errorMsg);
            $this->redirect("Posts","all");
        }

        $_SESSION['statement'] = $result[0];
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
            $this->model->create();
        }
    }

}