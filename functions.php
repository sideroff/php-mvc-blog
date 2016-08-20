<?php


function parseURL(string $url){
    $gosho = substr($url,0,strlen(APP_ROOT ."/"));
    if($gosho != APP_ROOT . "/") {
        die('APP_ROOT IS NOT CORRECT, SHOULD BE blog');
    }
    $url = substr($url,strlen(APP_ROOT . "/"));
    $urlParts = array_values(array_filter(explode('/',$url)));

    //default:
    //TODO PUT DEFAULT VALUES IN CONFIG
    
    $controllerName = "home";
    $actionName = "index";
    $params = [];

    //if we have atleast 1 that must be controller name
    if(count($urlParts)>0){
        $controllerName = $urlParts[0];
        //if we have more than 1 next one must be action
        if(count($urlParts)>1){
            $actionName = $urlParts[1];
            //if we have more than 2 next ones must be params
            if(count($urlParts)>2){
                //parts after url must be params so we slice with offset of 2
                $params = array_slice($urlParts,2);
            }
        }
    }

    if(class_exists($controllerName . "controller")){
        $controllerClassName = $controllerName . "controller";
        //if class exists: init it with given params if any

        //TODO remove this
        echo("controller: " . $controllerName . " action: " . $actionName);


        $controller = new $controllerClassName($controllerName,$actionName);
    }
    else {
        die("Controller '$controllerName' not found!");
    }

    if(method_exists($controller,$actionName) && is_callable(array($controller,$actionName))){
        $controller->$actionName($params);
        $controller->renderView();
    }
}

function __autoload(string $className){
    $className = $className . ".php";
    $controllersPrefix = "controllers/";
    $modelsPrefix = "Models/";

    if(file_exists($controllersPrefix . $className)){
        include ($controllersPrefix . $className);
    }
    else if(file_exists($modelsPrefix . $className)){
        include($modelsPrefix . $className);
    }
}