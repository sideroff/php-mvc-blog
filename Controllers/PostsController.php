<?php

class PostsController extends BaseController
{
    public function index(){        
        
    }

    public function create(){
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