<?php

class UsersController extends BaseController
{

    public function login()
    {        $this->checkIfLoggedIn();

        if ($this->isPost) {
            $username = $_POST['email-or-username'];
            $password = $_POST['password'];
            $userId = $this->model->login($username, $password);
            if($userId) {
                $_SESSION['userId'] = $userId;
                $_SESSION['username'] = $username;
                $this->addMessage("Login successful!",self::$successMsgType);
                $this->redirect("Home");
            }
        }
    }
    public function register(){
        $this->checkIfLoggedIn();

        if($this->isPost){
            var_dump($_POST);
            die();
        }
    }
    public function logout(){
        session_destroy();
        $this->redirect("Home");
    }
    private function checkIfLoggedIn(){
        $this->checkSession();
        if($this->isLoggedIn){
            $this->addMessage("You are already logged in!",self::$errorMsgType);
            $this->redirect("Home");
        }
    }
    private function checkSession(){
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
