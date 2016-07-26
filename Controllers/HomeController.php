<?php

class HomeController extends BaseController
{    
    public function index($params){
        if(count($params)==0){
            $params[0] = NULL;
        }
        $this->posts = $this->model->GetLastPosts($params[0]);
    }
}