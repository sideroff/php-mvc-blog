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
}
?>


<form class="register-form" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"<?php if($fillUsername) : ?> value="<?= $fillUsername; endif ?>">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <label for="confirm-password">Confirm password:</label>
    <input type="password" id="confirm-password" name="confirm-password">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"<?php if($fillEmail) : ?> value="<?= $fillEmail; endif ?>">
    <label for="first-name">First name:</label>
    <input type="text" id="first-name" name="first-name"<?php if($fillFirstNAme) : ?> value="<?= $fillFirstNAme; endif ?>">
    <label for="last-name">Surname:</label>
    <input type="text" id="last-name" name="last-name"<?php if($fillLastName) : ?> value="<?= $fillLastName; endif ?>">
    <input type="submit" value="submit">
</form>