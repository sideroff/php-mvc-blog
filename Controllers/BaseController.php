<?php

abstract class BaseController
{
    protected static $successMsg = ["type" => "success", "timeout" => 3000];
    protected static $infoMsg = ["type" => "info", "timeout" => 5000];
    protected static $errorMsg = ["type" => "error", "timeout" => 10000];
    
    protected $controllerName;
    protected $model;
    protected $action;
    protected $params;
    protected $posts;
    protected $isLoggedIn = false;
    protected $isPost = false;

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
    
    public function renderView(string $viewName = null, bool $includeLayout = true, bool $includePath = true){
        if($viewName==null){
            $viewName=$this->action;
        }
        $path = "Views/" . $this->controllerName . "/" . $viewName . ".php";
        
        if($includeLayout){
            include("Views/_layout/header.php");
        }
        if($includePath){
            include($path);
        }
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
            $url .= "/" . implode('/', $params);
        }
        $this->redirectToUrl($url);
    }

    public function addMessage(string $text, array $msg, int $forceTimeoutInMS = null){
        if(!key_exists("messages",$_SESSION)){
            $_SESSION["messages"] = [];
        }
        array_push($_SESSION["messages"],array("type" => $msg['type'] ,
                                                "text" => $text,
                                                "timeout" => (!$forceTimeoutInMS) ? $msg['timeout'] : $forceTimeoutInMS));
    }

    public function checkSession(){
        if(isset($_SESSION) &&
            count($_SESSION)>0 &&
            key_exists('username', $_SESSION) &&
            key_exists('userId',$_SESSION)){

            $this->isLoggedIn = true;
            return;
        }
        $this->isLoggedIn = false;
    }
}