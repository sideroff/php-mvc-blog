<?php

abstract class BaseController
{
    protected $controllerName;
    protected $model;
    protected $action;
    protected $params;
    protected $posts;

    public function __construct(string $controllerName, string $action){
        $this->controllerName = $controllerName;
        $modelName = $controllerName . "Model";
        if(class_exists($modelName)){
            $this->model = new $modelName();
        }
        $this->action = $action;
    }

    public function renderView(string $viewName = "index", bool $includeLayout = true){
        $path = "Views/" . $this->controllerName . "/" . $viewName . ".php";
        
        if($includeLayout){
            include("Views/_layout/header.php");
        }
        include($path);
        if($includeLayout){
            include("Views/_layout/footer.php");
        }
    }
}