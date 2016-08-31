<?php

class HomeController extends BaseController
{
    protected $latestUserRegisteredUsername;

    public function index($params){
        if(count($params)==0){
            $params[0] = NULL;
        }
        $statement = $this->model->getPosts(NUMBER_OF_POSTS_ON_HOME_INDEX);
        $this->checkStatement($statement);
        $this->posts = $statement->get_result()->fetch_all(MYSQLI_ASSOC);


        $statement = $this->model->getLatestRegisteredUserUsername(1);
        $this->checkStatement($statement);
        $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->latestUserRegisteredUsername = $result[0]['username'];
        
    }
    
}