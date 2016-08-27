<?php

class UsersController extends BaseController
{
    public function profile($params){
        if($this->isPost){
            $this->checkSession();
            if(!$this->isLoggedIn){
                $this->addMessage("Action forbidden! Log in first!", self::$errorMsg);
                $this->redirect("Home");
            }






            $file_name = basename($_FILES['avatar']['name']);
            $file_type = pathinfo(AVATARS_PATH . $file_name, PATHINFO_EXTENSION);

            if(getimagesize($_FILES['avatar']['tmp_name'])==false){
                $this->addMessage('File is not an image',self::$errorMsg);
                $this->redirect("Users","profile");
            }
            if(file_exists(AVATARS_PATH . $file_name)){
                unlink(AVATARS_PATH . $file_name);
                $this->addMessage("Your old avatar has been deleted!", self::$infoMsg);
            }
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "../" . AVATARS_PATH . $_SESSION['userId'] . "." . $file_type);
            
            
            die();
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            $this->model->changeAvatar();
        }
        else{
            $username = $params[0];
            $statement = $this->model->profile($username);
            if($statement->error){
                $this->addMessage("Something's wrong!" . $statement->error,self::$errorMsg);
                $this->redirect("Home");
            }
            $_SESSION['statement'] = $statement;
        }     
    }
    
    public function register(){
        $this->checkIfLoggedIn();

        if($this->isPost){
            $this->checkRegistrationData();
            $this->model->register();
        }
    }

    public function login(){
        $this->checkIfLoggedIn();

        if ($this->isPost) {
            $username = $_POST[FORM_USERNAME];
            $password = $_POST[FORM_PASSWORD];
            $statement = $this->model->login($username, $password);
            
            if($statement->error) {
                $this->addMessage("Login failed" . $statement->error, self::$errorMsg);
                $this->redirect("Users","Login");
            }
            else{
                $result = $statement->get_result()->fetch_assoc();
                $_SESSION['userId'] = $result['id'];
                $_SESSION['username'] = $username;
                $this->addMessage("Login successful!",self::$successMsg);
                $this->redirect("Home");
            }
        }
    }

    public function logout(){
        session_destroy();
        $this->redirect("Home");
    }
    
    private function checkRegistrationData(){
        $shouldRedirect = false;
        
        //---------- FORM CHECKS ----------
        //username
        if(strlen($_POST[FORM_USERNAME]) < USERNAME_MIN_LENGTH ||
            strlen($_POST[FORM_USERNAME]) > USERNAME_MAX_LENGTH) {
            $this->addMessage("Username must be between " .
                USERNAME_MIN_LENGTH . " and " . USERNAME_MAX_LENGTH .
                " characters long.", self::$errorMsg);
            $shouldRedirect=true;
        }

        //password
        if(!preg_match(PASSWORD_REGEX,$_POST[FORM_PASSWORD])){
            $this->addMessage("Password should contain 1 lowercase letter, 1 uppercase letter, 1 digit, 1 special character, and be between"
                . PASSWORD_MIN_LENGTH . " and " . PASSWORD_MAX_LENGTH . " characters long.",self::$errorMsg);
            $shouldRedirect=true;
        }

        if ($_POST[FORM_PASSWORD] != $_POST[FORM_CONFIRM_PASSWORD]){
            $this->addMessage("Password and confirm password fields do not match.",self::$errorMsg);
            $shouldRedirect=true;
        }

        //email
        if(!preg_match(EMAIL_REGEX,$_POST[FORM_EMAIL])){
            $this->addMessage("Please enter a valid email.",self::$errorMsg);
            $shouldRedirect=true;
        }
        
        //first name
        if(strlen($_POST[FORM_FIRST_NAME]) < FIRST_NAME_MIN_LENGTH ||
            strlen($_POST[FORM_FIRST_NAME]) > FIRST_NAME_MAX_LENGTH){
            $this->addMessage("Name must be between " 
                . FIRST_NAME_MIN_LENGTH ." and " . FIRST_NAME_MAX_LENGTH 
                ." characters long.",self::$errorMsg);
            $shouldRedirect = true;
        }
        
        //last name
        if(strlen($_POST[FORM_LAST_NAME]) < LAST_NAME_MIN_LENGTH ||
            strlen($_POST[FORM_LAST_NAME]) > LAST_NAME_MAX_LENGTH){
            $this->addMessage("Last name must be between "
                . LAST_NAME_MIN_LENGTH ." and " . LAST_NAME_MAX_LENGTH
                ." characters long.",self::$errorMsg);
            $shouldRedirect = true;
        }
        
        //this field is for user end check only -> we don't need it
        unset($_POST[FORM_CONFIRM_PASSWORD]);
        
        if($shouldRedirect){
            //when rendering the form we don't want to fill in password fields
            unset($_POST[FORM_PASSWORD]);
            $_SESSION['post-query'] = $_POST;
            $this->redirect("Users","Register");
        }
        else{
            $_POST[FORM_PASSWORD] = hash(DEFAULT_HASH_ALGORITHM,$_POST[FORM_PASSWORD]);
            $statement = $this->model->register();
            
            if($statement->error){
                $this->addMessage($statement->error, self::$errorMsg);
                unset($_POST[FORM_PASSWORD]);
                $_SESSION['post-query'] = $_POST;
                $this->redirect("Users","Register");
            }
            else{
                $this->addMessage("Registration successful!",self::$successMsg);
                $this->isPost=true;
                $this->login();
            }
        }
    }    
    
    private function checkIfLoggedIn(){
        $this->checkSession();
        
        if($this->isLoggedIn){
            $this->addMessage("You are already logged in!",self::$errorMsg);
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