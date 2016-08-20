<?php

abstract class BaseController
{
    protected $controllerName;
    protected $model;
    protected $action;
    protected $params;
    protected $posts;
    protected $isLoggedIn = false;
    protected $isPost = false;


    protected static $infoMsgType = "info";
    protected static $successMsgType = "success";
    protected static $errorMsgType = "error";

    public function __construct(string $controllerName, string $action){
        $this->controllerName = $controllerName;
        $modelName = $controllerName . "Model";
        
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            $this->isPost = true;
        }        
            
        if(class_exists($modelName)){
            $this->model = new $modelName();
        }
        $this->action = $action;
    }
    public function renderView(string $viewName = null, bool $includeLayout = true){
        if($viewName==null){
            $viewName=$this->action;
        }
        $path = "Views/" . $this->controllerName . "/" . $viewName . ".php";
        
        if($includeLayout){
            include("Views/_layout/header.php");
        }
        include($path);
        if($includeLayout){
            include("Views/_layout/footer.php");
        }
    }

    public function redirectToUrl (string $url){
        header("Location: " . $url);
        die;
    }

    public function redirect(string $controllerName, string $actionName = "index", array $params = null) {
        $url = APP_ROOT . "/" . $controllerName . "/" . $actionName;
        if($params && count($params)>0){
            $url .= implode('/', $params);
        }
        $this->redirectToUrl($url);
    }

    public function addMessage(string $msg, string $type){
        if(!key_exists("messages",$_SESSION)){
            $_SESSION["messages"] = [];
        }
        array_push($_SESSION["messages"],array('type' => $type , "text" => $msg));
    }
}