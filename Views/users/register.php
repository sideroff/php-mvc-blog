<?php $this->title = "Register";

$fillUsername = false;
$fillEmail = false;
$fillFirstNAme = false;
$fillLastName = false;
if(key_exists("post-query",$_SESSION)){
    $data =$_SESSION['post-query'];
    if(key_exists(FORM_USERNAME,$data)){
        $fillUsername = $data[FORM_USERNAME];
    }
    if(key_exists(FORM_EMAIL,$data)){
        $fillEmail = $data[FORM_EMAIL];
    }
    if(key_exists(FORM_FIRST_NAME,$data)){
        $fillFirstNAme = $data[FORM_FIRST_NAME];
    }
    if(key_exists(FORM_LAST_NAME,$data)){
        $fillLastName = $data[FORM_LAST_NAME];
    }
    unset($_SESSION['post-query']);
}
?>


<form class="register-form" method="post">
    <div><label for="<?=FORM_USERNAME?>">Username:</label>
    <input type="text" required="required" id="<?=FORM_USERNAME?>" name="<?=FORM_USERNAME?>"<?php if($fillUsername) : ?> value="<?= $fillUsername; endif ?>"></div>
    <div><label for="<?=FORM_PASSWORD?>">Password:</label>
    <input type="password" required="required" id="<?=FORM_PASSWORD?>" name="<?=FORM_PASSWORD?>"></div>
    <div><label for="<?=FORM_CONFIRM_PASSWORD?>">Confirm password:</label>
    <input type="password" required="required" id="<?=FORM_CONFIRM_PASSWORD?>" name="<?=FORM_CONFIRM_PASSWORD?>"></div>
    <div><label for="<?=FORM_EMAIL?>">Email:</label>
    <input type="email" required="required" id="<?=FORM_EMAIL?>" name="<?=FORM_EMAIL?>"<?php if($fillEmail) : ?> value="<?= $fillEmail; endif ?>"></div>
    <div><label for="<?=FORM_FIRST_NAME?>">First name:</label>
    <input type="text" required="required" id="<?=FORM_FIRST_NAME?>" name="<?=FORM_FIRST_NAME?>"<?php if($fillFirstNAme) : ?> value="<?= $fillFirstNAme; endif ?>"></div>
    <div><label for="<?=FORM_LAST_NAME?>">Last name:</label>
    <input type="text" required="required" id="<?=FORM_LAST_NAME?>" name="<?=FORM_LAST_NAME?>"<?php if($fillLastName) : ?> value="<?= $fillLastName; endif ?>"></div>
    <div><input type="submit" value="submit"></div>
</form>