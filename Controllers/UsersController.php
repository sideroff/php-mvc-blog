<?php

class UsersController extends BaseController
{

    public function login()
    {
        $this->checkIfLoggedIn();

        if ($this->isPost) {
            $username = $_POST[FORM_USERNAME];
            $password = $_POST[FORM_PASSWORD];
            $userId = $this->model->login($username, $password);
            if($userId) {
                $_SESSION['userId'] = $userId;
                $_SESSION['username'] = $username;
                $this->addMessage("Login successful!",self::$successMsgType);
                $this->redirect("Home");
            }
            else{
                $this->addMessage("Login was not successful!", self::$errorMsgType);
                $this->redirect("Users","Login");
            }
        }
    }
    public function register(){
        $this->checkIfLoggedIn();

        if($this->isPost){
            $this->checkRegistrationData();
            $this->model->register($_POST);
        }
    }
    private function checkRegistrationData(){
        $shouldRedirect = false;
        
        if(strlen($_POST[FORM_USERNAME]) < USERNAME_MIN_LENGTH ||
            strlen($_POST[FORM_USERNAME]) > USERNAME_MAX_LENGTH) {
            $this->addMessage("Username must be between " .
                USERNAME_MIN_LENGTH . " and " . USERNAME_MAX_LENGTH .
                " characters long.", self::$errorMsgType);
            unset($_POST[FORM_USERNAME]);
            
            $shouldRedirect=true;
        }
        else if(!preg_match(PASSWORD_REGEX,$_POST[FORM_PASSWORD])){
            $this->addMessage("Password should contain 1 lowercase letter, 1 uppercase letter, 1 digit, 1 special character, and be between"
            . PASSWORD_MIN_LENGTH . " and " . PASSWORD_MAX_LENGTH . " characters long.",self::$errorMsgType);
            unset($_POST[FORM_PASSWORD]);
            $shouldRedirect=true;
        }

        else if(!preg_match(EMAIL_REGEX,$_POST[FORM_EMAIL])){
            $this->addMessage("Please enter a valid email.",self::$errorMsgType);
            unset($_POST[FORM_EMAIL]);
            $shouldRedirect=true;
        }
        else if(strlen($_POST[FORM_FIRST_NAME]) < FIRST_NAME_MIN_LENGTH ||
            strlen($_POST[FORM_FIRST_NAME]) > FIRST_NAME_MAX_LENGTH){
            $this->addMessage("Name must be between " 
                . FIRST_NAME_MIN_LENGTH ." and " . FIRST_NAME_MAX_LENGTH 
                ." characters long.",self::$errorMsgType);
            unset($_POST[FORM_FIRST_NAME]);
            $shouldRedirect = true;
        }

        else if(strlen($_POST[FORM_LAST_NAME]) < LAST_NAME_MIN_LENGTH ||
            strlen($_POST[FORM_LAST_NAME]) > LAST_NAME_MAX_LENGTH){
            $this->addMessage("Last name must be between "
                . LAST_NAME_MIN_LENGTH ." and " . LAST_NAME_MAX_LENGTH
                ." characters long.",self::$errorMsgType);
            unset($_POST[FORM_LAST_NAME]);
            $shouldRedirect = true;
        }
        if($shouldRedirect){
            $this->redirect("Users","Register",$_POST);
        }
        else{
            unset($_POST[FORM_CONFIRM_PASSOWRD]);
            $id = $this->model->register($_POST);
            if($id){
                $this->addMessage("Registration successful!",self::$successMsgType);
                $this->isPost=true;
                $this->login();
            }
            else{
                $this->addMessage("Something went wrong while processing your request. Please try again.", self::$errorMsgType);
                $this->redirect("Users","Register",$_POST);
            }
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
