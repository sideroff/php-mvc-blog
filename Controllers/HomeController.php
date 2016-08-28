<?php

class HomeController extends BaseController
{    
    public function index($params){
        if(count($params)==0){
            $params[0] = NULL;
        }
        $statement = $this->model->GetLastPosts(NUMBER_OF_POSTS_ON_HOME_INDEX);
        if($statement->error) {
            require_once "../Views/_layout/internal-error.php";
            die();
        }
        $this->posts = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        
    }
}